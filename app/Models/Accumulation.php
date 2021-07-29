<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accumulation extends Model
{
    protected $guarded = ['id']; 
    public $appends = ['gps'];


    public function survey()
    {
        return $this->hasMany(RiskSurvey::class, "policy_no", 'policy_no');
    }
    public function getGpsAttribute()
    {
        $array = [];
        $array['lng'] =  (float)$this->gps_long ;
        $array['lat'] =   (float)$this->gps_lat ; 
        return   $array ;
    }
 

}
