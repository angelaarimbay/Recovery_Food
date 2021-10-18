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

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["category"=>$data->category,
                 "supply_name"=>$data->supply_name,
                 "quantity"=>$data->quantity,
                 "requesting_branch"=>$data->requesting_branch,
                ]
            );
        } else {
            tbl_outgoingsupp::create($data->all());
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
            $temp['outgoing_amount'] = $value->outgoing_amount;  
            $temp['outgoing_date'] = $value->outgoing_date;  
            $temp['quantity'] = $value->quantity;  
            $temp['requesting_branch'] = $value->requesting_branch_details;  
            $temp['supply_name'] = $value->supply_name_details;  
           array_push($return,$temp);
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
        return tbl_masterlistsupp::where("category",(integer)$t->category)->where("status", 1)->get();
    }

    public function branchName()
    {
        return tbl_branches::select(["branch_name","id"])->where("status", 1)->get();
    }

    public function validateQuantity(Request $request)
    {
        return $request->id;
        $get_group = tbl_masterlistsupp::where("id",$request->id)->first()->group; 
        $get_group = tbl_masterlistsupp::where("group",$get_group)->pluck('id'); 
        return tbl_incomingsupp::wherein('supply_name',$get_group )->sum('quantity');
    }



}
