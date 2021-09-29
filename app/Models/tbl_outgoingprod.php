<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_masterlistprod;
use App\Models\tbl_branches;

class tbl_outgoingprod extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['outgoing_amount'];
   

  
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

    
    public function requesting_branch()
    {
        return $this->hasOne(tbl_branches::class, 'id', 'requesting_branch');
    }

    public function getOutgoingAmountAttribute()
    {
        return number_format(tbl_masterlistprod::where("id", $this->product_name)->first()->price * $this->quantity,2, ".", ",");
    }
}
