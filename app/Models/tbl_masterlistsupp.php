<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_suppcat;

class tbl_masterlistsupp extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    
    public function category()
    {
        return $this->hasOne(tbl_suppcat::class, 'id', 'category');
    }
}
