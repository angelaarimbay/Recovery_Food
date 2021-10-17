<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_supplist;
use App\Models\tbl_masterlistsupp; 
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class IncomingSuppliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
       
        $table = tbl_incomingsupp::where("supply_name", "!=", null);

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["category"=>$data->category,
                "supply_name"=>$data->supply_name,
                "quantity"=>$data->quantity,
                "amount"=>$data->amount,
                "incoming_date"=>$data->incoming_date,
                ]
            );
        } else { 
            tbl_incomingsupp::create($data->all());
        }
        return 0;
    }
    
    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0");
      
      
        $table = tbl_incomingsupp::with(["category","supply_name",'supplier'])->whereRaw($where) ;
      
        if($t->dateFrom && $t->dateUntil){
           $table = $table->whereBetween("incoming_date",[date("Y-m-d",strtotime($t->dateFrom)), date("Y-m-d",strtotime($t->dateUntil))]);
        } 
        
        if ($t->search) { // If has value 
           $table =  $table->whereHas('supply_name', function ($q) use ($t) {
                $q->where('supply_name', 'like', "%".$t->search."%");
            }) ->paginate($t->itemsPerPage, "*", "page", 1);
        }

        $return = [];
        foreach ($table->get() as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id; 
            $temp['status'] = $value->status;  
            $temp['amount'] = $value->amount;  
            $temp['category'] = $value->category_details;   
            $temp['format_amount'] = $value->format_amount;  
            $temp['incoming_date'] = $value->incoming_date;  
            $temp['quantity'] = $value->quantity;  
            $temp['quantity_amount'] = $value->quantity_amount;  
            $temp['quantity_difference'] = $value->quantity_difference;  
            $temp['supply_name'] = $value->supply_name_details;  
            $temp['supplier'] = $value->supplier_details;  
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
        return tbl_masterlistsupp::query()
        ->where("supplier", $t->supplier)
        ->where("category", $t->category)
        ->where("status", 1)->get();
    }


    public function suppliers()
    { 
        return tbl_supplist::get();
    }






    public function getTotalCurrentMonth(Request $t){ 
        $date1 =  date("Y-m-d h:i:s",strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s",strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 11:59:59'));
        
        try {
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name",$t->item)->whereBetween("incoming_date",[$date1,$date2])->sum('amount');
            $get_specific_item_quantity =tbl_incomingsupp::where("supply_name",$t->item)->whereBetween("incoming_date",[$date1,$date2])->sum('quantity');
           return  $get_specific_item_amount . ' '. $get_specific_item_quantity;
        } catch (\Throwable $th) {
            return false;
        }
       
    }
}
