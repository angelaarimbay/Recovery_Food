<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;
use App\Models\tbl_supplist;
use App\Models\tbl_incomingsupp;

class tbl_masterlistsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['with_vat','without_vat','format_net_price','category_name','category_details','supplier_name_details','without_vat_price','with_vat_price'];

    
    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }
    public function supplier()
    {
        return $this->hasOne(tbl_supplist::class, 'id', 'supplier');
    }
    public function getWithVatAttribute()
    {
        $date1 =  date("Y-m-d h:i:s", strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s", strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 11:59:59'));
        $incoming = 0;

        try {
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($date1 . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($date2 . ' 11:59:59'))]);
            $get_specific_item_quantity = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($date1 . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($date2 . ' 11:59:59'))]);
    
            $incoming =  number_format($get_specific_item_amount / $get_specific_item_quantity, 6, ".", ",");
            ;
        } catch (\Throwable $th) {
            $incoming = $this->net_price;
        }
        return $this->vatable == 0 ?  number_format($incoming, 6, ".", ","):  number_format($this->net_price, 6, ".", ",");
    }

    public function getWithoutVatAttribute()
    {
        $date1 =  date("Y-m-d h:i:s", strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s", strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 11:59:59'));
        $incoming = 0;
        try {
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($date1 . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($date2 . ' 11:59:59'))]);
            $get_specific_item_quantity = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("created_at", [date("Y-m-d H:i:s", strtotime($date1 . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($date2 . ' 11:59:59'))]);
    
            $incoming =  number_format($get_specific_item_amount / $get_specific_item_quantity, 2, ".", ",");
        } catch (\Throwable $th) {
            $incoming = $this->net_price;
        }
        return $this->vatable == 0 ?  number_format($incoming, 2, ".", ","):  number_format($this->net_price / $this->vat, 2, ".", ",");
    }

    public function getFormatNetPriceAttribute()
    {
        return number_format($this->net_price, 2, ".", ",");
    }

    public function getFormatWithVatAttribute()
    {
        return number_format($this->with_vat, 2, ".", ",");
    }
    
   

    public function getCategoryNameAttribute()
    {
        return $this->hasOne(tbl_suppcat::class, "id", "category")->first()->supply_cat_name;
    }
    
    public function getCategoryDetailsAttribute()
    {
        return tbl_suppcat::where("id", $this->category)->first();
    }
   
    public function getSupplierNameDetailsAttribute()
    {
        return tbl_supplist::where("id", $this->supplier)->first();
    }

    public function getWithoutVatPriceAttribute()
    {
        $date1 =  date("Y-m-d h:i:s",strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s",strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 23:59:59'));

        //get the amount from incoming
        $get_amount = tbl_incomingsupp::where("supply_name",$this->id)
        ->whereBetween('incoming_date',[$date1,$date2]);  
        $get_quantity = $get_amount = tbl_incomingsupp::where("supply_name",$this->id)
        ->whereBetween('incoming_date',[$date1,$date2]);
        //get average amount
        if($get_quantity->sum('quantity') > 0){
            $get_wov = $get_amount->sum('amount') / $get_quantity->sum('quantity'); 
        }else{  
            $get_wov = 0;
        }
        //get vat
        if($this->vatable == 1){
            if($get_wov > 0){
                $get_wov = $get_wov / $this->vat; 
            }else{
                $get_wov =$this->net_price / $this->vat;
            }
        }

        return $get_wov;
    } 
    public function getWithVatPriceAttribute()
    {
        $date1 =  date("Y-m-d h:i:s",strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s",strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 23:59:59'));

        //get the amount from incoming
        $get_amount = tbl_incomingsupp::where("supply_name",$this->id)
        ->whereBetween('incoming_date',[$date1,$date2]);  
        $get_quantity = $get_amount = tbl_incomingsupp::where("supply_name",$this->id)
        ->whereBetween('incoming_date',[$date1,$date2]);
        //get average amount
        if($get_quantity->sum('quantity') > 0){
            $get_wov = $get_amount->sum('amount') / $get_quantity->sum('quantity'); 
        }else{  
            $get_wov = $this->net_price ;
        } 
        return $get_wov;
    }
   

}
