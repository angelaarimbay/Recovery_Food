<?php

namespace App\Models;

use App\Models\tbl_masterlistprod;
use App\User;
use Illuminate\Database\Eloquent\Model;

class tbl_requestprod extends Model
{
    //Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['product_name_details', 'user_details', 'quantity_available'];

    //For product name info
    public function getProductNameDetailsAttribute()
    {
        return tbl_masterlistprod::where("id", $this->product_name)->first();
    }

    //For user info
    public function getUserDetailsAttribute()
    {
        return $this->hasOne(User::class, 'id', 'user')->first();
    }

    //For computing available quantity
    public function getQuantityAvailableAttribute()
    {
        $date1 = date("Y-m-d 00:00:00", strtotime(date("m") . "-01-" . date("Y")));
        $date2 = date("Y-m-t 23:59:59", strtotime(date("m") . '/' . date("t") . '/' . date("Y")));
        return tbl_incomingprod::where("product_name", $this->product_name)->whereBetween("incoming_date", [$date1, $date2])->sum('quantity')
         - tbl_outgoingprod::where("product_name", $this->product_name)->whereBetween("outgoing_date", [$date1, $date2])->sum('quantity');
    }
}
