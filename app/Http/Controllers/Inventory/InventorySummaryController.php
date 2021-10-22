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
<<<<<<< Updated upstream
        $date1 = date("Y-m-d H:i:s", strtotime($request->from. ' 00:00:01')); // Get from date w/ first sec in time
           $date2 = date("Y-m-d h:i:s", strtotime($request->to. ' 24:59:59')); // Get to date w/ last sec in time
        // Set array for temporary table
        $return = [];
        foreach ($data as $key => $value) {
            $temp = [];
            // Get incoming based on from, to and per category, then sum amounts
            $temp['category'] = $value->supply_cat_name;
            $temp['incoming'] =   tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity");
            // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
            $temp['outgoing'] =   tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity");
            $temp['stocks'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")
                            - tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity");
            array_push($return, $temp);
=======
  
        $date11 =  date("Y-m-d H:i:s",   strtotime("-1 month", strtotime( $request->year."-".$request->month."-01". ' 00:00:00'))) ;
        $date22 = cal_days_in_month(CAL_GREGORIAN, ($request->month-1), $request->year);
        $date22 = date("Y-m-d H:i:s",   strtotime("-1 month", strtotime($request->year."-".$request->month."-".$date22.  ' 23:59:59')));


        $date1 =  date("Y-m-d H:i:s", strtotime( $request->year."-".$request->month."-01". ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
        $date2 = date("Y-m-d H:i:s", strtotime($request->year.'-'.$request->month.'-'.$date2.' 23:59:59'));
        
     
 




           // Set array for temporary table
        $return = [];
        foreach ($data as $key => $value) {
            $temp = []; 
            $temp['category'] = $value->supply_cat_name;

            //  begining based on from, to and per category, then sum amounts of last month
            $temp['begining'] =   number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("quantity"),2);
            // Get incoming based on from, to and per category, then sum amounts
            $temp['incoming'] =   number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"),2);
            // beg + in
            $temp['total'] =      number_format( tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"),2) ;
            // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
            $temp['outgoing'] =   number_format(tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"),2);
            // stocks = total - outgoing 
            $temp['stocks'] =   tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") - tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ;
            
            try {
                $temp['ending'] =   number_format(
                (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")),2);
            } catch (\Throwable $th) {
                $temp['ending'] =   number_format(0,2);
            }
            
            // ending - stocks
            try {
                $temp['variance'] =  $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['variance'] =   number_format(0,2);
            }
           
           
            try {
                $temp['ending'] =   number_format(
                (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")),2);
            } catch (\Throwable $th) {
                $temp['ending'] =   number_format(0,2);
            }
             
            try {
                $temp['fluctuation'] =  $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['fluctuation'] =   number_format(0,2);
            }
           
      
                   
       

         
          array_push($return, $temp);
>>>>>>> Stashed changes
        }

        return $return;
    }
}
