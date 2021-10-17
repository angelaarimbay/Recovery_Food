<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_branches;

class tbl_outgoingsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['outgoing_amount','category_details','supply_name_details','requesting_branch_details'];
    

    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }

    public function supply_name()
    {
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

    public function getOutgoingAmountAttribute()
    {
        return number_format(tbl_masterlistsupp::where("id", $this->supply_name)->first()->with_vat * $this->quantity, 2, ".", ",");
    }
}
