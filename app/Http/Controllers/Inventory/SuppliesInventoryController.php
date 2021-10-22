<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_suppliesinventory; 
use App\Models\tbl_outgoingsupp;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SuppliesInventoryController extends Controller
{
    //

    public function store(Request $request){
        tbl_suppliesinventory::create(
            ['ref'=>$request->ref,
             'category'=> $request->category,
             'supply_name'=>$request->supply_name,
             'quantity'=>$request->quantity,
             'outgoing_date'=>date("Y-m-d h:i:s"),
             'branch'=>auth()->user()->branch,
             'user'=>auth()->user()->id,
        ]); 
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
            $temp['quantity'] =$value->quantity -  tbl_suppliesinventory::where(["user"=>auth()->user()->id, 'branch'=>auth()->user()->branch, 'ref'=>$value->id ])->sum('quantity') ;  
            $temp['requesting_branch'] = $value->requesting_branch_details;  
            $temp['supply_name'] = $value->supply_name_details;  
            $temp['outgoing_amount'] = number_format($value->with_vat_price * $value->quantity,2) ;  
            $temp['with_vat_price'] = number_format($value->with_vat_price,2) ;  
            $temp['without_vat_price'] = number_format($value->without_vat_price,2) ;  
            $temp['fluctiation'] = number_format($value->fluctiation,2) ;  
           array_push($return,$temp);
        }   
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }

}
