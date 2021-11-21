<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\tbl_incomingprod;
use App\Models\tbl_masterlistprod;
use App\Models\tbl_outgoingprod;
use App\Models\tbl_requestprod;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RequestProductsController extends Controller
{

    public function getProductsList(Request $request)
    {
        $where = ($request->category ? "category !=0  and category=" . $request->category : "category != 0");

        // return $where;
        $table = tbl_masterlistprod::with("category", "sub_category")
            ->selectRaw("*, case when exp_date is null THEN null when datediff(exp_date,current_timestamp) > 7 THEN null ELSE datediff(exp_date,current_timestamp) end as days")
            ->whereRaw($where);

        if ($request->search) { //we will be using wherehas if this portion is in relationship
            // if not. just use where
            $table = $table->where('product_name', 'like', "%" . $request->search . "%");

        }

        return $table->get();
    }

    public function get(Request $t)
    {
        $table = tbl_requestprod::select(['ref', 'user', 'request_date'])
            ->selectRaw('min(status) as status')
            ->groupBy(['ref', 'user', 'request_date'])
            ->wherein('status', [1, 2])
            ->where('branch', auth()->user()->branch)
            ->orderBy("request_date", "desc")
            ->get();
        $return = [];
        foreach ($table as $key => $value) {
            $temp = [];
            $temp['row'] = $key + 1;
            $temp['id'] = $value->ref;
            $temp['ref'] = $value->ref;
            $temp['status'] = $value->status;
            $temp['user'] = $value->user_details->name;
            $temp['request_date'] = $value->request_date;
            array_push($return, $temp);
        }
        $items = Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }

    public function storeProducts(Request $request)
    {
        //---------------------------delete upon update
        //get all the request row
        $ids = [];
        foreach ($request->all() as $key => $value) {
            array_push($ids, $value['id']);
        }
        //if the ref is found and id is not found in that reference then status = 0
        tbl_requestprod::where('ref', $request[0]['ref'])->whereNotIn('product_name', $ids)->update(['status' => 0]);

        //---------------------------update / save as new row for exsiting request or if no reference fount save all.
        $date = date("Y-m-d H:i:s");
        $refno = strtotime(date("Y-m-d h:i:s")); //hanap ka ng ibang pang create ng ref no. may diffrence yan sa seconds.

        foreach ($request->all() as $key => $value) {
            //first find the ref and id
            if (tbl_requestprod::where(['ref' => $value['ref'], 'product_name' => $value['id']])->get()->count() > 0) {
                tbl_requestprod::where(['ref' => $value['ref'], 'product_name' => $value['id']])
                    ->update(
                        [
                            'product_name' => $value['id'],
                            'quantity' => $value['quantity'],
                            'request_date' => $date,
                            'user' => auth()->user()->id,
                        ]
                    );
            } else {
                //if the item have ref then add new with that ref.
                if ($value['ref']) {
                    tbl_requestprod::create(
                        [
                            'ref' => $value['ref'],
                            'product_name' => $value['id'],
                            'quantity' => $value['quantity'],
                            'request_date' => $date,
                            'branch' => auth()->user()->branch,
                            'user' => auth()->user()->id,
                        ]
                    );
                } else {
                    //if no ref found then save as new ref
                    tbl_requestprod::create(
                        [
                            'ref' => $refno,
                            'product_name' => $value['id'],
                            'quantity' => $value['quantity'],
                            'request_date' => $date,
                            'branch' => auth()->user()->branch,
                            'user' => auth()->user()->id,
                        ]
                    );
                }
            }
        }
        return $request;
    }

    public function getRequested(Request $request)
    {
        $table = tbl_requestprod::where('ref', $request->ref)
            ->wherein("status", [1, 2])
            ->where('deleted', 0)
            ->get();
        $return = [];
        foreach ($table as $key => $value) {
            $temp = [];
            $temp['id'] = $value->product_name;
            $temp['product_name'] = $value->product_name_details['product_name'] . ' ' . $value->product_name_details['description'];
            $temp['quantity'] = $value->quantity;
            $temp['status'] = $value->status;
            array_push($return, $temp);
        }
        return $return;
    }

    public function completeRequest(Request $request)
    {
        foreach (tbl_requestprod::where(['ref' => $request->ref])->where('status', '!=', 0)->get() as $key => $value) {

            $date1 = date("Y-m-d 00:00:00", strtotime(date("Y") . "-" . date("m") . "-01"));
            $date2 = date("Y-m-t 23:59:59", strtotime(date("Y") . '-' . date("m") . '-' . date("t")));

            $get_amount = tbl_incomingprod::where("product_name", $value->product_name)
                ->whereBetween('incoming_date', [$date1, $date2]);
            $get_quantity = tbl_incomingprod::where("product_name", $value->product_name)
                ->whereBetween('incoming_date', [$date1, $date2]);

            $get_quantity->sum('quantity');
            $get_wov = ($get_amount->sum('amount') ? $get_amount->sum('amount') / $get_quantity->sum('quantity') : 0);

            tbl_outgoingprod::create(
                ['category' => tbl_masterlistprod::where("id", $value->product_name)->first()->category,
                    'product_name' => $value->product_name,
                    'sub_category' =>tbl_masterlistprod::where("id", $value->product_name)->first()->sub_category,
                    'quantity' => $value->quantity,
                    'requesting_branch' => $value->branch,
                    'request_ref' => $value->ref,
                    'amount' => $get_wov * $value->quantity,
                    'outgoing_date' => date('Y-m-d h:i:s'),
                ]
            );
        }
        tbl_requestprod::where(['ref' => $request->ref])->where('status', '!=', 0)->update(['status' => 3]);
    }

    public function cancelRequest(Request $request)
    {
        tbl_requestprod::where(['ref' => $request->ref])->where('status', '!=', 0)->update(['status' => 0]);
    }
}
