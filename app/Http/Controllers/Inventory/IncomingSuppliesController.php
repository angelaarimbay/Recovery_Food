<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use Illuminate\Support\Facades\DB;

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
        DB::statement(DB::raw("set @row:=0")); 
        $table = tbl_incomingsupp::with(["category","supply_name"])->selectRaw("*, @row:=@row+1 as row ")->whereRaw($where);
      
        if ($t->search) { // If has value
            $table_clone = clone $table;   // Get all items from incomingsupp  
            if($t->dateFrom && $t->dateUntil){
                $table_clone->whereBetween("incoming_date",[date("Y-m-d",strtotime($t->dateFrom)), date("Y-m-d",strtotime($t->dateUntil))]);
            } 
            return $table_clone->whereHas('supply_name', function ($q) use ($t) {
                $q->where('supply_name', 'like', "%".$t->search."%");
            }) ->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else 
        if($t->dateFrom && $t->dateUntil){
            $table->whereBetween("incoming_date",[date("Y-m-d",strtotime($t->dateFrom)), date("Y-m-d",strtotime($t->dateUntil))]);
        } 
        return  $table->paginate($t->itemsPerPage, "*", "page", $t->page);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }

    public function suppName(Request $t)
    { 
        return tbl_masterlistsupp::where("category", $t->category)->where("status", 1)->get();
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
