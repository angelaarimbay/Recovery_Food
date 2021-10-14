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
    public $appends = ['with_vat','without_vat','format_net_price','format_with_vat','format_without_vat','category_name'];

    
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
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('amount');
            $get_specific_item_quantity = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('quantity');
    
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
            $get_specific_item_amount = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('amount');
            $get_specific_item_quantity = tbl_incomingsupp::where("supply_name", $this->id)->whereBetween("incoming_date", [$date1,$date2])->sum('quantity');
    
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

    public function getFormatWithoutVatAttribute()
    {
        return number_format($this->without_vat, 2, ".", ",");
    }

    public function getCategoryNameAttribute() {
        return $this->hasOne(tbl_suppcat::class, "id", "category")->first()->supply_cat_name;
    }
}
