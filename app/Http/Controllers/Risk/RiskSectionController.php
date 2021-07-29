<?php

namespace App\Http\Controllers\Risk;

use App\Http\Controllers\Controller;
use App\Models\RiskIres;
use App\Models\RiskSurvey;
use Illuminate\Http\Request;

class RiskSectionController extends Controller
{
    public function storeSurvey(Request $request)
    {
        // return $request->all();
        $data = $request;
        if(!$data->id){
            $return = RiskSurvey::create($request->all());
            return $return;
        }else{
            $return = RiskSurvey::where("id",$data->id)->update($request->all());
            return $return;
        } 
    }
    public function getSurveyList()
    { 
        return RiskSurvey::where("active", 1)->get();
    }
    public function uploadSurvey(Request $request)
    { 
       
     
        $img = $request->file('file');
        return $img->getClientOriginalName();
        $newfilename  = $img->getClientOriginalName() . "-" . time() . '.' . $img->getClientOriginalExtension();
        $input['imagename'] = $newfilename;
        $img->storeAs('public/files/survey/', $input['imagename']);
        return  $input['imagename'];
    }
 
}
