<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_supplist;

class tbl_purchaseord extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['format_amount','supplier_name_details'];

    public function supplier_name()
    {
        return $this->hasOne(tbl_supplist::class, 'id', 'supplier_name');
    }   
 
    public function getFormatAmountAttribute()
    {
        return number_format($this->amount, 2, ".", ",");
    }
      
    public function getSupplierNameDetailsAttribute()
    {
        return tbl_supplist::where("id", $this->supplier_name)->first();
    }
}
