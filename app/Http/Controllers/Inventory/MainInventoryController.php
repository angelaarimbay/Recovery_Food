<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_outgoingsupp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MainInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0");
        $table = tbl_masterlistsupp::whereRaw($where)->get();

    
        $date1 =  date("Y-m-d H:i:s",   strtotime("-1 month", strtotime( date("Y")."-".date("m")."-01". ' 00:00:00'))) ;
        $date2 = cal_days_in_month(CAL_GREGORIAN, (date("m")-1), date("Y"));
        $date2 = date("Y-m-d H:i:s",   strtotime("-1 month", strtotime(date("Y")."-".date("m")."-".$date2.  ' 11:59:59')));
  

        $date11 =  date("Y-m-d H:i:s", strtotime( date("Y")."-".date("m")."-01". ' 00:00:00'));
        $date22 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date22 = date("Y-m-d H:i:s", strtotime(date("Y").'-'.date("m").'-'.$date22.' 11:59:59'));
       
       
       
        $return = [];
        $row = 1;
        foreach ($table as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  tbl_suppcat::where("id", $value->category)->first()->supply_cat_name ;
            $temp['supply_name'] =  $value->supply_name ;
            $temp['unit'] =  $value->unit ;
            $temp['net_price'] =  $value->net_price ;
         
            
          
            $temp['begining_q'] =  tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('quantity');

            $temp['begining_a']    = number_format(tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('amount'), 2);
 

            $temp['incoming_q'] =  tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('quantity');

            $temp['incoming_a']    = number_format(tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('amount'), 2);

            $temp['outgoing_q'] =  tbl_outgoingsupp::where('supply_name', $value->id)
            ->whereBetween('outgoing_date',[$date1,$date22])
            ->sum('quantity');
            $temp['outgoing_a']    =   number_format(tbl_outgoingsupp::where('supply_name', $value->id)
            ->whereBetween('outgoing_date',[$date1,$date22])
            ->sum('amount'), 2);
         
            $temp['onhand_q'] =  tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1, $date22])->sum('quantity') - 
            tbl_outgoingsupp::where('supply_name', $value->id) 
            ->whereBetween('outgoing_date',[$date1, $date22])->sum('quantity');
            $temp['onhand_a'] =  number_format((tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1, $date22])
            ->sum('quantity') > 0 ? tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1, $date22])->sum('amount') / tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1, $date22])->sum('quantity'):0), 2);
         

            $temp['average_q'] =  tbl_outgoingsupp::where('supply_name', $value->id)
            ->whereBetween('outgoing_date',[$date1, $date22])->sum('quantity') / date('d');

            $temp['average_a'] = number_format((tbl_incomingsupp::where('supply_name', $value->id) 
            ->whereBetween('incoming_date',[$date1, $date22])
            ->sum('quantity') > 0? (tbl_incomingsupp::where('supply_name', $value->id) 
            ->whereBetween('incoming_date',[$date1, $date22])
            ->sum('amount') / tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date',[$date1, $date22])
            ->sum('quantity')) * (tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date',[$date1, $date22])->sum('quantity') / date('d')):0), 2) ;

            $temp['orderpoint'] = number_format(($value->lead_time * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d')) + ((tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d')) * 2)), 2);
            $orderqty = $value->order_frequency * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d'));
            if ($orderqty < $value->maximum_order_quantity) {
                $temp['ordr'] = number_format($value->maximum_order_quantity, 2) ;
            } else {
                $temp['ordr'] = number_format($orderqty, 2);
            }
            if (tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') <  $value->lead_time * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d'))) {
                $temp['triggerpoint'] = "ORDER";
            } else {
                $temp['triggerpoint'] = "MANAGE";
            }


            $temp['ending_q'] = 0;
            $temp['ending_a'] = 0 * tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('amount');

        


            $temp['consumption_q'] =  tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity') - 0;

            $temp['consumption_a'] = number_format((tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity') - 0) * (tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity')> 0?(tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('amount') /  tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity')):0),2);

        
            $temp['ideal_q'] =  tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id) 
            ->sum('quantity');

            $temp['ideal_a'] =  number_format((tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id) 
            ->sum('quantity')) * (tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('quantity') > 0? (tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('amount') /  tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('quantity')):0),2);


 

            $temp['variance_q'] =  0 -  (tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id) 
            ->sum('quantity'));
           

            $temp['variance_a']    = number_format( ( 0 -  (tbl_incomingsupp::where('supply_name', $value->id) 
            ->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id) 
            ->sum('quantity'))) * (tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('quantity')>0? (tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('amount') /  tbl_incomingsupp::where('supply_name', $value->id)
            ->whereBetween('incoming_date',[$date1,$date2])
            ->sum('quantity')):0),2);

            array_push($return, $temp);
        }

        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
}
