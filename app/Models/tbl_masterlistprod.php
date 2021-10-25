<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_masterlistprod extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['diff_quantity','format_price','with_vat','format_with_vat','format_unit_price','category_details','sub_category_details'];
 
    public function getFormatUnitPriceAttribute()
    {
        return number_format($this->price, 2, ".", ",");
    }

    public function category()
    {
        return $this->hasOne(tbl_prodcat::class, 'id', 'category');
    }

    public function sub_category()
    {
        return $this->hasOne(tbl_prodsubcat::class, 'id', 'sub_category');
    }

    public function getDiffQuantityAttribute()
    {
        return tbl_incomingprod::where("product_name", $this->id)->get()->sum("quantity")  - tbl_outgoingprod::where("product_name", $this->id)->get()->sum("quantity") ;
    }

    public function getFormatPriceAttribute()
    {
        return number_format($this->price, 2, ".", ",");
    }

    public function getCategoryDetailsAttribute()
    {
        return tbl_prodcat::where("id", $this->category)->first();
    }

    public function getSubCategoryDetailsAttribute()
    {
        return tbl_prodsubcat::where("id", $this->sub_category)->first();
    }

    public function getWithVatAttribute()
    {
        $with_vat = $this->price?$this->price / $this->vat:0;
        return $with_vat;
    }

    public function getFormatWithVatAttribute()
    {
        return number_format($this->with_vat, 2, ".", ",");
    }
}
