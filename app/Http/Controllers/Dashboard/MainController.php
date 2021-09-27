<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_masterlistsupp;

class MainController extends Controller
{
   

    public function test(Request $request){
        $img = $request->file('file');         
        $newfilename  = $img->getClientOriginalName()."-".time().'.'.$img->getClientOriginalExtension();
        $input['imagename'] = $newfilename;  
        $img->storeAs('public/files/bulletin/',$newfilename);    
        return ['filename'=>$input['imagename'],'fakefilename'=> $img->getClientOriginalName()]; 

    }


    public function sample (){
       return tbl_masterlistsupp::where("status", 1)->get()->count("supply_name");

        // output nan total na
    }
  
}
