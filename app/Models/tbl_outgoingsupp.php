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

    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }

    public function suppname()
    {
        return $this->hasOne(tbl_masterlistsupp::class, 'id', 'supply_name');
    }

    public function branchname()
    {
        return $this->hasOne(tbl_branches::class, 'id', 'branch_name');
    }
}
