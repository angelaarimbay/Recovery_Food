<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_branches;
use App\Models\tbl_incomingsupp;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OutgoingSuppliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function save(Request $data)
    {
        $table = tbl_outgoingsupp::where("supply_name", "!=", null);
        $date1 = date("Y-m-d h:i:s", strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s", strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 11:59:59'));

        $get_amount = tbl_incomingsupp::where("supply_name", $data->supply_name['id'])
        ->whereBetween('incoming_date', [$date1,$date2]);
        $get_quantity = $get_amount = tbl_incomingsupp::where("supply_name", $data->supply_name['id'])
        ->whereBetween('incoming_date', [$date1,$date2]);
      
        $get_wov = $get_amount->sum('amount') / $get_quantity->sum('quantity');

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["category"=>$data->category,
                 "supply_name"=>$data->supply_name['id'],
                 "quantity"=>$data->quantity,
                 "amount"=>$get_wov * $data->quantity,
                 "requesting_branch"=>$data->requesting_branch,
                 "outgoing_date"=> date('Y-m-d', strtotime($data->outgoing_date)),
                ]
            );
        } else {
            tbl_outgoingsupp::create($data->except(['supply_name','amount']) + ['supply_name'=>$data->supply_name['id'], 'amount' => $get_wov  * $data->quantity]);
        }
        return 0;
    }

    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0").
                 ($t->branch? " and requesting_branch=".$t->branch:"");
 
        $table = tbl_outgoingsupp::with(["category","supply_name","requesting_branch"])
        ->whereRaw($where)
        ->where("supply_name", "!=", null);

        if ($t->dateFrom && $t->dateUntil) {
            $table =  $table->whereBetween("outgoing_date", [date("Y-m-d H:i:s", strtotime($t->dateFrom . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->dateUntil . ' 11:59:59'))]);
        }
 
        if ($t->search) { // If has value
            $table  = $table->whereHas('supply_name', function ($q) use ($t) {
                $q->where('supply_name', 'like', "%".$t->search."%");
            });
        }
        
        $return = [];
        foreach ($table->get() as $key => $value) {
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id;
            $temp['status'] = $value->status;
            $temp['category'] = $value->category_details;
            $temp['outgoing_date'] = $value->outgoing_date;
            $temp['quantity'] = $value->quantity;
            $temp['requesting_branch'] = $value->requesting_branch_details;
            $temp['supply_name'] = $value->supply_name_details;
            $temp['outgoing_amount'] = number_format($value->with_vat_price * $value->quantity, 2);
            $temp['with_vat_price'] = number_format($value->with_vat_price, 2) ;
            $temp['without_vat_price'] = number_format($value->without_vat_price, 2) ;
            $temp['fluctiation'] = number_format($value->fluctiation, 2) ;
            array_push($return, $temp);
        }
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }

    public function suppName(Request $t)
    {
        return tbl_masterlistsupp::where("category", (integer)$t->category)->where("status", 1)->get();
    }

    public function branchName()
    {
        return tbl_branches::select(["branch_name","id"])->where("status", 1)->get();
    }

    public function validateQuantity(Request $request)
    {
        return tbl_incomingsupp::where('supply_name', $request->id)->sum('quantity') -  tbl_outgoingsupp::where('supply_name', $request->id)->sum('quantity') ;
    }
}
