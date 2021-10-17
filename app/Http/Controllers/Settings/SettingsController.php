<?php

namespace App\Http\Controllers\Settings;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_company;
use App\Models\tbl_vat;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SettingsController extends Controller
{
// dont add auth
// dont add auth
// dont add auth

    public function uploadLogo(Request $t){ 
        $img = $t->file('file');
        $newfilename  = $img->getClientOriginalName() . "~" . time() . '.' . $img->getClientOriginalExtension();
        $input['imagename'] = $newfilename;
        $img->storeAs('public/logo/', $input['imagename']); 
        return ['filename'=> $img->getClientOriginalName(), 'tempfile'=>$newfilename, 'path' => url('/storage/logo/'. $input['imagename'])]  ; 
    }

    public function storeLogo(Request $t){ 
        tbl_company::create(['logo'=>$t->attachment]); 
    }
    public function deleteLogo(){ 
        tbl_company::where('active','!=',0)->update(['active'=>0]); 
    }
    

    public function getLogo(){ 
        if(  tbl_company::where("active",1)->orderBy('id','desc')->get()->count() > 0){ 
            $logo = url('/storage/logo/'. tbl_company::where("active",1)->orderBy('id','desc')->first()->logo);
            $filename =  tbl_company::where("active",1)->orderBy('id','desc')->first()->logo;
            $temp = explode('~',tbl_company::where("active",1)->orderBy('id','desc')->first()->logo)[0] ;
        }else{
            $logo = null;
            $filename = null;
            $temp = null;
        } 
        return ['path' => $logo, 'tempfile'=> $filename, 'filename' =>  $temp ] ; 
    }
    public function storeVat(Request $t){ 

        if(tbl_vat::where(["type"=>$t->type])->get()->count() > 0){
            tbl_vat::where(["type"=>$t->type])
            ->update(['vat'=>$t->vat,
            'type'=>$t->type,
            'cashier'=>auth()->user()->id]) ; 

        }else{
            tbl_vat::create(['vat'=>$t->vat,
            'type'=>$t->type,
            'cashier'=>auth()->user()->id]) ; 
        }

     
    }

    public function getVat(Request $t){ 
        return tbl_vat::where("type", $t->type)->orderby("created_at",'desc')->first();
    }


}