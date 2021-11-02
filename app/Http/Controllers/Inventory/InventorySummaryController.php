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
  
        //last month
        $date11 =  date("Y-m-d 00:00:00",   strtotime("-1 month", strtotime( $request->year."-".$request->month."-01"))) ; 
        $date22 = date("Y-m-t 23:59:59",   strtotime("-1 month", strtotime($request->year."-".$request->month."-".date("t") )));
        // this month
        $date1 =  date("Y-m-d 00:00:00", strtotime( $request->year."-".$request->month."-01")); 
        $date2 = date("Y-m-t 23:59:59", strtotime($request->year.'-'.$request->month.'-'.date("t").' '));
        
      

           // Set array for temporary table
        $return = [];
        foreach ($data as $key => $value) {
            $temp = []; 
            $temp['category'] = $value->supply_cat_name;

            //  begining based on from, to and per category, then sum amounts of last month
            $temp['begining_orig'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") ;
            $temp['begining'] =   number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount"),2);
            // Get incoming based on from, to and per category, then sum amounts
            $temp['incoming_orig'] =    tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") ;
            $temp['incoming'] =   number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"),2);
            // beg + in
            $temp['total_orig'] =  tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")  ;
            $temp['total'] =      number_format( tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"),2) ;
            // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
            $temp['outgoing_orig'] =  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount");
            $temp['outgoing'] =   number_format(tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"),2);
            // stocks = total - outgoing 
            $temp['stocks_orig'] =   (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")) -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount") ;
            $temp['stocks'] =    number_format(  (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")) -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount") ,2);
            
            try {
                $temp['ending'] =   number_format(
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date2])->get()->sum("quantity") -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity")  ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")),2);
            } catch (\Throwable $th) {
                $temp['ending'] =   number_format(0,2);
            }
            
            try {
                $temp['ending_orig'] =    
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date2])->get()->sum("quantity") -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity")  ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")) ;
            } catch (\Throwable $th) {
                $temp['ending_orig'] =  0 ;
            }
            
            // ending - stocks
            try {
                $temp['variance'] = number_format( $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount")),2);
            } catch (\Throwable $th) {
                $temp['variance'] =   number_format(0,2);
            }
            try {
                $temp['variance_orig'] =  $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['variance_orig'] =    0 ;
            } 
            try {
                $temp['fluctuation'] =  number_format($temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount")),2);
            } catch (\Throwable $th) {
                $temp['fluctuation'] =   number_format(0,2);
            }
            try {
                $temp['fluctuation_orig'] =  $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity") ) *  
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['fluctuation_orig'] =    0 ;
            }  
          array_push($return, $temp);
        } 
        return $return;
    }
}
