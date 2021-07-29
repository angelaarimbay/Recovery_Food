<?php

namespace App\Http\Controllers\Accumulation;

use App\Http\Controllers\Controller;
use App\Imports\AccumulationImport;
use App\Models\Accumulation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccumulationController extends Controller
{
    public function AccumulationList()
    {
        $getMaxdate = Accumulation::where("expiry",'!=',null)->orderby("expiry","desc")->first()->expiry; 
        $data =  Accumulation::selectRaw(" cresta_id, sum(our_si) as our_si  ")->groupby("cresta_id")->get(); 
        return ['data'=>$data,'date'=>$getMaxdate];
    }
    public function AccumulationPerCompany(Request $request)
    {
        $data = Accumulation::selectRaw("insured_code,  
                                        max(insured) as insured,
                                        max(gps_long)   as gps_long,
                                        max(gps_lat)  as gps_lat,
                                        location_of_risk,
                                        max(our_si) as our_si,
                                        policy_no,
                                         sum(our_si_or) as our_si_or,
                                        sum(our_si_tty) as our_si_tty,
                                         sum(our_si_fac) as our_si_fac")
                                        ->groupby(["insured_code",'location_of_risk',"policy_no"])
                                        ->where("cresta_id",$request->cresta)
                                        ->get();
        $data_gps = [];
        foreach ($data as $key => $value) {   
            if( $value->gps['lng']){
                $temp=[];
                $temp[0]=$value->gps;
                $temp[1]='<b>Company name:</b> '.$value->insured.'<br>'.
                         '<b>Location:</b> '.$value->location_of_risk.' <br>'.
                         '<b>Our SI: </b>'.$value->our_si ;
               array_push($data_gps,$temp);
            }
        }
        return  ['data'=>$data, 'gps'=>$data_gps] ;
    }
    public function AccumulationUploadExcel(Request $request)
    {
      return  Excel::import( new AccumulationImport, $request->file('file')); 
        // $img = $request->file('file');  
        // $newfilename  = $img->getClientOriginalName() . "-" . time() . '.' . $img->getClientOriginalExtension();
        // $input['imagename'] = $newfilename;
        // $img->storeAs('public/files/excel/', $newfilename);
        // return ['filename' => $input['imagename']];
    }
    public function AccumulationToplist()
    {
        $data =  Accumulation::selectRaw("insured, 
                                          sum(our_si)  as our_si,
                                          sum(our_si)  as f_our_si")
                                          ->groupby("insured")
                                          ->orderby("our_si",'desc') 
                                          ->take(10)
                                          ->get(); 
        return $data;
    }
    public function AccumulationCrestaZone(){
        $data = Accumulation::SelectRAW("eq_zone, 
                                    sum(our_si) as our_si, 
                                     sum(our_si)  as f_our_si")
                                    ->groupby("eq_zone")
                                    ->orderby("eq_zone","asc")
                                    ->get();
        $zone=[];
        $amount=[];
        foreach ($data as $key => $value) {
            array_push($zone,$value->eq_zone);
            $temp=[];
            $temp['a']=$value->our_si;
            $temp['b']=$value->f_our_si;
            
            array_push($amount,$value->our_si);
        }

        return ['zone'=>$zone,'amount'=>$amount] ;
                             
    }
}
