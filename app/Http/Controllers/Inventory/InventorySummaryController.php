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
        $date1 = date("Y-m-d h:i:s", strtotime($request->from. ' 00:00:01')); // Get from date w/ first sec in time
        $date2 = date("Y-m-d h:i:s", strtotime($request->to. ' 11:59:59')); // Get to date w/ last sec in time
        // Set array for temporary table
        $return = [];
        foreach ($data as $key => $value) {
            $temp = [];
            // Get incoming based on from, to and per category, then sum amounts

            
            $temp['category'] = $value->supply_cat_name;
            $temp['incoming'] =  number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"), 2, ".", ",");
             
            // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
            $temp['outgoing'] =  number_format(tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("outgoing_amount"), 2, ".", ",");
               
 
            $temp['stocks'] = number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")
                                  - tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("outgoing_amount"), 2, ".", ",");
            array_push($return, $temp);
        }

        return $return;
    }
}
