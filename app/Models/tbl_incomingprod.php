<?php

namespace App\Models;

use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_masterlistprod;
use Illuminate\Database\Eloquent\Model;

class tbl_incomingprod extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['format_amount','product_name_details','category_details','sub_category_details' ];

    public function category()
    {
        return $this->hasOne(tbl_prodcat::class, 'id', 'category');
    }

    public function sub_category()
    {
        return $this->hasOne(tbl_prodsubcat::class, 'id', 'sub_category');
    }

    public function product_name()
    {
        return $this->hasOne(tbl_masterlistprod::class, 'id', 'product_name');
    }

    public function getFormatAmountAttribute()
    {
        return number_format($this->amount, 2, ".", ",");
    }

    public function getProductNameDetailsAttribute()
    {
        return tbl_masterlistprod::where("id", $this->product_name)->first();
    }  

    public function getCategoryDetailsAttribute()
    {
        return tbl_prodcat::where("id", $this->category)->first();
    }  
    public function getSubCategoryDetailsAttribute()
    {
        return tbl_prodsubcat::where("id", $this->sub_category)->first();
    }  

  
}
