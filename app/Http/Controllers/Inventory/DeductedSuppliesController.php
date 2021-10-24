<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\tbl_suppliesinventory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DeductedSuppliesController extends Controller
{
   public function get(Request $t){
     
       $where = ($t->category? "category !=0  and category=".$t->category:"category != 0").
       ($t->search?" and supply_name like '%".$t->search."%'":'');
 
       
          $table = tbl_suppliesinventory:: whereRaw($where)
        ->selectRaw("*, @row:=@row+1 as row ")
        ->get();

            $return = [];
            foreach ($table as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id;   
             $temp['category'] = $value->category_details;   
            $temp['supply_name'] = $value->supply_name_details;  
            $temp['unit'] = $value->supply_name_details['unit'];  
            $temp['net_price'] = $value->supply_name_details['net_price'];  
            $temp['with_vat_price'] = $value->supply_name_details['with_vat_price'];  
            $temp['quantity'] = $value->quantity;   
            $temp['amount'] = $value->quantity * $value->supply_name_details['net_price'] ;   
            $temp['outgoing_date'] = $value->outgoing_date;   
                array_push($return,$temp);
            }   

            $items =   Collection::make($return);
            return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);



   }
}
