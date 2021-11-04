<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_outgoingsupp;
use App\Models\tbl_requestsupp;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class RequestSuppliesController extends Controller
{

    public function getSuppliesList(Request $request)
    {
        return tbl_masterlistsupp::all();
    }
    public function get(Request $t)
    {
        $table = tbl_requestsupp::select(['ref', 'user', 'request_date'])
            ->selectRaw('min(status) as status')
            ->groupBy(['ref', 'user', 'request_date'])
            ->wherein('status', [1, 2, 3])
            ->where('branch', auth()->user()->branch)
            ->get();
        $return = [];
        foreach ($table  as $key => $value) {
            $temp = [];
            $temp['row']  = $key + 1;
            $temp['id'] = $value->ref;
            $temp['ref'] = $value->ref;
            $temp['status'] = $value->status;
            $temp['user'] = $value->user_details->name;
            $temp['request_date'] = $value->request_date;
            array_push($return, $temp);
        }
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }

    public function storeSupplies(Request $request)
    {
        //---------------------------delete upon update
        //get all the request row
        $ids = [];
        foreach ($request->all() as $key => $value) {
            array_push($ids, $value['id']);
        }
        //if the ref is found and id is not found in that reference then status = 0
        tbl_requestsupp::where('ref', $request[0]['ref'])->whereNotIn('supply_name', $ids)->update(['status' => 0]);



        //---------------------------update / save as new row for exsiting request or if no reference fount save all.

        $date =  date("Y-m-d h:i:s");
        foreach ($request->all() as $key => $value) {
            //first find the ref and id
            if (tbl_requestsupp::where(['ref' => $value['ref'], 'supply_name' => $value['id']])->get()->count() > 0) {
                tbl_requestsupp::where(['ref' => $value['ref'], 'supply_name' => $value['id']])
                    ->update(
                        [
                            'supply_name' => $value['id'],
                            'quantity' => $value['quantity'],
                            'request_date' => $date,
                            'user' => auth()->user()->id
                        ]
                    );
            } else {
                //if the item have ref then add new with that ref.
                if ($value['ref']) {
                    tbl_requestsupp::create(
                        [
                            'ref' => $value['ref'],
                            'supply_name' => $value['id'],
                            'quantity' => $value['quantity'],
                            'request_date' => $date,
                            'branch' => auth()->user()->branch,
                            'user' => auth()->user()->id
                        ]
                    );
                } else {
                    //if no ref found then save as new ref
                    $refno = strtotime(date("Y-m-d h:i:s"));
                    tbl_requestsupp::create(
                        [
                            'ref' =>  $refno,
                            'supply_name' => $value['id'],
                            'quantity' => $value['quantity'],
                            'request_date' => $date,
                            'branch' => auth()->user()->branch,
                            'user' => auth()->user()->id
                        ]
                    );
                }
            }
        }
        return $request;
    }

    public function getRequested(Request $request)
    {
        $table = tbl_requestsupp::where('ref', $request->ref)
            ->wherein("status", [1, 2])
            ->where('deleted', 0)
            ->get();
        $return = [];
        foreach ($table  as $key => $value) {
            $temp = [];
            $temp['id'] = $value->supply_name;
            $temp['supply_name'] = $value->supply_name_details['supply_name'] . ' ' . $value->supply_name_details['description'];
            $temp['unit']  = $value->supply_name_details['supply_name'];
            $temp['quantity'] = $value->quantity;
            $temp['status'] = $value->status;
            array_push($return, $temp);
        }
        return  $return;
    }

    public function completeRequest(Request $request)
    {



        foreach (tbl_requestsupp::where(['ref' => $request->ref])->where('status', '!=', 0)->get() as $key => $value) {


            $date1 =  date("Y-m-d 00:00:00", strtotime(date("Y") . "-" . date("m") . "-01"));
            $date2 = date("Y-m-t 23:59:59", strtotime(date("Y") . '-' . date("m") . '-' . date("t")));


            $get_amount = tbl_incomingsupp::where("supply_name", $value->supply_name)
                ->whereBetween('incoming_date', [$date1, $date2]);
            $get_quantity = tbl_incomingsupp::where("supply_name", $value->supply_name)
                ->whereBetween('incoming_date', [$date1, $date2]);


            $get_quantity->sum('quantity');
            $get_wov = ($get_amount->sum('amount') ? $get_amount->sum('amount') / $get_quantity->sum('quantity') : 0);

            tbl_outgoingsupp::create(
                [   'category'=> tbl_masterlistsupp::where("id",$value->supply_name)->first()->category,
                    'supply_name' => $value->supply_name,
                    'quantity' => $value->quantity,
                    'requesting_branch' => $value->branch,
                    'request_ref' => $value->ref,
                    'amount' => $get_wov  * $value->quantity,
                    'outgoing_date' => date('Y-m-d h:i:s'),
                ]
            );
        }

        tbl_requestsupp::where(['ref' => $request->ref])->where('status', '!=', 0)->update(['status' => 3]);
    }
}
