<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_masterlistprod;
use App\User;

class tbl_requestprod extends Model
{
    protected $guarded = ['id'];
    public $appends = ['product_name_details', 'user_details', 'quantity_available'];

    public function getProductNameDetailsAttribute()
    {
        return tbl_masterlistprod::where("id", $this->product_name)->first();
    }
    public function getUserDetailsAttribute()
    {
        return $this->hasOne(User::class, 'id', 'user')->first();
    }

    public function getQuantityAvailableAttribute()
    {
        $date1 = date("Y-m-d 00:00:00", strtotime(date("m") . "-01-" . date("Y")));
        $date2 = date("Y-m-t 23:59:59", strtotime(date("m") . '/' . date("t") . '/' . date("Y")));
        return tbl_incomingprod::where("product_name", $this->product_name)->whereBetween("incoming_date", [$date1, $date2])->sum('quantity')
         - tbl_outgoingprod::where("product_name", $this->product_name)->whereBetween("outgoing_date", [$date1, $date2])->sum('quantity');
    }
}
