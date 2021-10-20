<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_suppcat;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_outgoingsupp;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat\NumberFormatter; 


class InventorySummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function get(Request $request)
    {
        // 1st Get all the category
        $data = tbl_suppcat::all();
        // Laravel default format of date and time, use other format will handle exemptions
        $date1 =  date("Y-m-d h:i:s",strtotime($request->month."-01-".$request->year. ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
        $date2 = date("Y-m-d h:i:s",strtotime($request->month.'/'.$date2.'/'.$request->year. ' 11:59:59'));
         
        $date11 =  date("Y-m-d H:i:s",   strtotime("-1 month", strtotime( $request->year."-".$request->month."-01". ' 00:00:01'))) ;
           $date22 = cal_days_in_month(CAL_GREGORIAN, $request->month , $request->year);
            $date22 = date("Y-m-d h:i:s",   strtotime("-1 month", strtotime($request->month."/".$date22."/".$request->year.  ' 11:59:59')));
    
      
           // Set array for temporary table
        $return = [];
        foreach ($data as $key => $value) {
            $temp = [];



            
            $temp['category'] = $value->supply_cat_name;

            // Get incoming based on from, to and per category, then sum amounts
            $temp['incoming'] =   tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount");
            //  begining based on from, to and per category, then sum amounts of last month
            $temp['begining'] =   tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount");
            //  in + beg 
            $temp['total'] =   tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount");
            // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
            $temp['outgoing'] =   tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount");
            // stocks = total - outgoing 
            $temp['stocks'] =  tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                            -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount");
            $temp['ending'] =   0;
            // ending - stocks
            $temp['variance'] =  0-  tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
            -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount");
            //fluctuation of incoming
            $temp['fluctuation'] =   tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("fluctuation");
             
     
     
      
                   
       

         
          array_push($return, $temp);
        }

        return $return;
    }
}
