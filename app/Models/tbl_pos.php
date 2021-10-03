<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_branches;
use App\Models\tbl_masterlistprod;


class tbl_pos extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id']; 

  
    public function  branch()
    {
        return $this->hasOne(tbl_branches::class, 'id', 'branch');
    }

    public function product_name()
    {
        return $this->hasOne(tbl_masterlistprod::class, 'id', 'product_name');
    }
 
}
