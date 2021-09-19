<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;
use App\Models\tbl_incomingsupp;

class tbl_masterlistsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['with_vat','without_vat'];

    
    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }

    public function getWithVatAttribute()
    {
        $date1 =  date("Y-m-d h:i:s", strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s", strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 11:59:59'));
        $incoming = 0;

        //sice we check incoming via total, so if vatable = 0  kukunin nya un, else netprice
        // tama to. kasi in total for the month ung kinukuha natin from incoming..
        try {
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('amount');
            $get_specific_item_quantity = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('quantity');
    
            $incoming =  number_format($get_specific_item_amount / $get_specific_item_quantity, 6, ".", ",");
            ;
        } catch (\Throwable $th) {
            $incoming = $this->net_price;
        }
        return $this->vatable == 0 ?  number_format( $incoming , 6, ".", ","):  number_format($this->net_price, 6, ".", ",");
    }

    public function getWithoutVatAttribute()
    {
        $date1 =  date("Y-m-d h:i:s", strtotime(date("m")."-01-".date("Y"). ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d h:i:s", strtotime(date("m").'/'.$date2.'/'.date("Y"). ' 11:59:59'));
        $incoming = 0;
        try {
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('amount');
            $get_specific_item_quantity = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('quantity');
    
            $incoming =  number_format($get_specific_item_amount / $get_specific_item_quantity, 2, ".", ",");
        } catch (\Throwable $th) {
            $incoming = $this->net_price;
        }
        return $this->vatable == 0 ?  number_format($incoming, 2, ".", ","):  number_format($this->net_price / $this->vat, 2, ".", ",");
    }
}
