<?php

namespace App\Models;
use App\Models\tbl_useracc;
use Illuminate\Database\Eloquent\Model;

class tbl_useracc extends Model
{
    // Always include this code for every model/table created
    protected $guarded = ['id'];
    public $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
