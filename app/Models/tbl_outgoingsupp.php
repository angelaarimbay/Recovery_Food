<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_branches;
use App\Models\tbl_incomingsupp;

class tbl_outgoingsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = [ 'outgoing_amount_original','category_details','supply_name_details','requesting_branch_details','with_vat_price','fluctiation'];
    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }

    public function supply_name()
    {
        //kinukuha lang natin ung presyo e
        return $this->hasOne(tbl_masterlistsupp::class, 'id', 'supply_name');
    }

    public function getCategoryDetailsAttribute()
    {
        return tbl_suppcat::where("id", $this->category)->first();
    }
    
    public function getSupplyNameDetailsAttribute()
    {
        return tbl_masterlistsupp::where("id", $this->supply_name)->first();
    }

    public function getRequestingBranchDetailsAttribute()
    {
        return tbl_branches::where('id', $this->requesting_branch)->First();
    }

    public function requesting_branch()
    {
        return $this->hasOne(tbl_branches::class, 'id', 'requesting_branch');
    }
 
    public function getOutgoingAmountOriginalAttribute()
    {
        //used for inventory summary page / report
        return tbl_masterlistsupp::where("id", $this->supply_name)->first()->with_vat * $this->quantity ;
    }

    public function getWithVatPriceAttribute()
    {
        $date1 = date("Y-m-d 00:00:00", strtotime(date("m")."-01-".date("Y"))); 
        $date2 = date("Y-m-t 23:59:59", strtotime(date("m").'/'.date('t').'/'.date("Y")));

        //get the amount from incoming
        $get_amount = tbl_incomingsupp::where("supply_name", $this->supply_name)
        ->whereBetween('incoming_date', [$date1,$date2]);
        $get_quantity = $get_amount = tbl_incomingsupp::where("supply_name", $this->supply_name)
        ->whereBetween('incoming_date', [$date1,$date2]);
        //get average amount
        if ($get_quantity->sum('quantity') > 0) {
            $get_wov = $get_amount->sum('amount') / $get_quantity->sum('quantity');
        } else {
            $get_wov = tbl_masterlistsupp::where('id', $this->supply_name)->first()->net_price;
        }
        return $get_wov;
    }

    public function getNetPriceAttribute()
    {
        return tbl_masterlistsupp::where("id", $this->supply_name)->first();
    }

    public function getFluctiationAttribute()
    {
        //for list with vat column
        $date1 = date("Y-m-d 00:00:00", strtotime(date("m")."-01-".date("Y"))); 
        $date2 = date("Y-m-t 23:59:59", strtotime(date("m").'/'.date('t').'/'.date("Y")));

        //get the amount from incoming
        $get_amount = tbl_outgoingsupp::where("supply_name", $this->supply_name)
        ->whereBetween('outgoing_date', [$date1,$date2]);

        $get_quantity = $get_amount = tbl_outgoingsupp::where("supply_name", $this->supply_name)
        ->whereBetween('outgoing_date', [$date1,$date2]);
        //get average amount
        if ($get_quantity->sum('amount') < 1) {
            $get_wov = 0;
        } else {
            $get_wov = $get_quantity->sum('quantity') * (($get_amount->sum('amount') / $get_quantity->sum('quantity'))  -   tbl_masterlistsupp::where("id", $this->supply_name)->first()->net_price);
        }
        return $get_wov;
    }
}
