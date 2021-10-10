<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_branches;
use App\Models\tbl_masterlistprod;
use App\User;


class tbl_pos extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];  
    public $appends = ['total_amount','branch_name_details'];
  
    public function branch()
    {
        return $this->hasOne(tbl_branches::class, 'id', 'branch');
    }
 
    public function product_name()
    {
        return $this->hasOne(tbl_masterlistprod::class, 'id', 'product_name');
    }
 
    public function cashier(){
        return $this->hasOne(User::class, 'id', 'cashier');
    }

    public function getTotalAmountAttribute() {
        return number_format($this->sub_total_discounted, 2, ".", ",");
    }

    public function getBranchNameDetailsAttribute()
    {
        return tbl_branches::where("id", $this->branch)->first();
    }
}
