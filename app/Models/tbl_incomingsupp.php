<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;
use App\Models\tbl_supplist;
use App\Models\tbl_masterlistsupp;
use Illuminate\Support\Facades\DB;

class tbl_incomingsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['quantity_difference','quantity_amount','category_details','supply_name_details','supplier_details',  'fluctiation'];

    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }

    public function supply_name()
    {
        return $this->hasOne(tbl_masterlistsupp::class, 'id', 'supply_name');
    }
    public function supplier()
    {
        return $this->hasOne(tbl_supplist::class, 'id', 'supplier');
    }
    public function getQuantityDifferenceAttribute()
    {
        $incoming =  DB::table("tbl_incomingsupps")->where("supply_name", $this->supply_name)->sum("quantity");
        $outgoing =  DB::table("tbl_outgoingsupps")->where("supply_name", $this->supply_name)->sum("quantity");

        return ceil($incoming - $outgoing);
    }

    public function getCategoryDetailsAttribute()
    {
        return tbl_suppcat::where("id", $this->category)->first();
    }
    
    public function getSupplyNameDetailsAttribute()
    {
        return tbl_masterlistsupp::where("id", $this->supply_name)->first();
    }  
    public function getSupplierDetailsAttribute()
    {
        return tbl_supplist::where("id", $this->supplier)->first();
    }

    // For Main Inventory
    public function getQuantityAmountAttribute()
    {
        try {
        $incoming = DB::table("tbl_incomingsupps")->where("supply_name", $this->supply_name)->sum("amount");
        $outgoing = DB::table("tbl_masterlistsupps")->where("id", $this->supply_name)->first()->net_price  * DB::table("tbl_outgoingsupps")->where("supply_name", $this->supply_name)->sum("quantity");
        return ceil($incoming - $outgoing);
            } catch (\Throwable $th) {
               return 0;
            }
    
    }
    public function getNetPriceAttribute()
    {
        return tbl_masterlistsupp::where("id", $this->supply_name)->first()->net_price;
    }  

    public function getFluctiationAttribute()
    { //for list with vat column
        
        $date1 =  date("Y-m-d h:i:s",strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s",strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 23:59:59'));

        //get the amount from incoming
        $get_amount = tbl_incomingsupp::where("supply_name",$this->supply_name)
        ->whereBetween('incoming_date',[$date1,$date2]);  

        $get_quantity = $get_amount = tbl_incomingsupp::where("supply_name",$this->supply_name)
        ->whereBetween('incoming_date',[$date1,$date2]);
        //get average amount
        if($get_quantity->sum('amount') < 1){
            $get_wov = 0;
        }else{  
            $get_wov = $get_quantity->sum('quantity') * ( ( $get_amount->sum('amount') / $get_quantity->sum('quantity')  )  -   tbl_masterlistsupp::where("id",$this->supply_name)->first()->net_price  ); 
        } 
        return $get_wov;
    }
 
}
