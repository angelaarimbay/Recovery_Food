<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;

class tbl_prodlist extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];

    public function category()
    {
        return $this->hasOne(tbl_prodcat::class, 'id', 'category');
    }

    public function sub_category()
    {
        return $this->hasOne(tbl_prodsubcat::class, 'id', 'sub_category');
    }
}
