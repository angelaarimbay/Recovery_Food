<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use Illuminate\Support\Facades\DB;

class tbl_incomingsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['quantity_difference','quantity_amount'];

    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }

    public function supply_name()
    {
        return $this->hasOne(tbl_masterlistsupp::class, 'id', 'supply_name');
    }

    public function getQuantityDifferenceAttribute()
    {
        $incoming =  DB::table("tbl_incomingsupps")->where("supply_name", $this->supply_name)->sum("quantity");
        $outgoing =  DB::table("tbl_outgoingsupps")->where("supply_name", $this->supply_name)->sum("quantity");

        return  ceil($incoming - $outgoing);
    }

    public function getQuantityAmountAttribute()
    {
        $incoming =  DB::table("tbl_incomingsupps")->where("supply_name", $this->supply_name)->sum("amount");
        $outgoing =   DB::table("tbl_masterlistsupps")->where("id", $this->supply_name)->first()->net_price * DB::table("tbl_outgoingsupps")->where("supply_name", $this->supply_name)->sum("quantity") ;

        return  ceil($incoming - $outgoing);
    }
}
