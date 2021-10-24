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

    
        $date11 =  date("Y-m-d H:i:s",   strtotime("-1 month", strtotime( date("Y")."-".date("m")."-01". ' 00:00:00'))) ;
        $date22 = cal_days_in_month(CAL_GREGORIAN, (date("m")-1), date("Y"));
        $date22 = date("Y-m-d H:i:s",   strtotime("-1 month", strtotime(date("Y")."-".date("m")."-".$date22.  ' 23:59:59')));
  

        $date1 =  date("Y-m-d H:i:s", strtotime( date("Y")."-".date("m")."-01". ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d H:i:s", strtotime(date("Y").'-'.date("m").'-'.$date2.' 23:59:59'));
        
       
        $return = [];
        $row = 1;
        foreach ($table as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  tbl_suppcat::where("id",$value->category)->first()->supply_cat_name ;
            $temp['supply_name'] =  $value->supply_name ;
            $temp['unit'] =  $value->unit ;
            $temp['net_price'] =  $value->net_price ;

            $incoming = tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date',[$date1,$date2]);
            $outgoing = tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date',[$date1,$date2]);

            $incoming_past = tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date',[$date11,$date22]);
            $outgoing_past = tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date',[$date11,$date22]);

            $incoming_and_past = tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date',[$date11,$date2]);
            $outgoing_and_past = tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date',[$date11,$date2]);

            //begining (total of last month)
            $a = clone $incoming_past; $temp['begining_q'] = $a->sum('quantity');
            $a = clone $incoming_past; $temp['begining_a'] = number_format($a->sum('amount'), 2);

            //incming (total of current month)
            $a = clone $incoming; $temp['incoming_q'] = $a->sum('quantity');
            $a = clone $incoming; $temp['incoming_a'] = number_format($a->sum('amount'), 2);

            //total (total of last month + current month)
            $a = clone $incoming_and_past; 
            $temp['total_q'] = $temp['begining_q'] + $temp['incoming_q'] ;
            $temp['total_a'] =  number_format( $a->sum('amount'),2) ;
 
            //outgoing (total of current month)
            $b = clone $outgoing; $temp['outgoing_q'] = $b->sum('quantity');
            $b = clone $outgoing; $temp['outgoing_a'] = number_format($b->sum('amount'), 2);
         
            //onhand (total of last month + current month) - outgoing 
            $c = clone $incoming_and_past; $d = clone $outgoing; $temp['onhand_q'] = $c->sum('quantity') - $d->sum('quantity') ;
            $c_a = clone $incoming_and_past; 
            $cc_a = clone $incoming_and_past;
            if($c_a->sum('quantity') > 0 ){ 
                $temp['onhand_a'] =     number_format(($c_a->sum('amount') / $cc_a->sum('quantity') * $temp['onhand_q'])   ,2);
            }else{
                $temp['onhand_a'] = 0;
            }
 

            //average (total of last month + current month / quantity of last month + current month) / (current month quantity / date today)
            $a = clone $outgoing;
            $temp['average_q'] =   number_format($a->sum('quantity') / date('d'),2);
            $c_a = clone $incoming_and_past; 
            $cc_a = clone $incoming_and_past; 
            if($c_a->sum('quantity') > 0 ){ 
                $temp['average_a'] =     number_format(($c_a->sum('amount') / $cc_a->sum('quantity') *  $temp['average_q'] )   ,2);
            }else{
                $temp['average_a'] = 0;
            }
 
            //order poin  (lead time of item * total quantity / day today) + outgoing quantity / day today
            $a = clone $outgoing;
            $temp['orderpoint'] =  number_format(($value->lead_time * ($a->sum('quantity') / date('d'))) + (($a->sum('quantity') / date('d')) * 2),2) ;

            //order point  (lead time of item * total quantity / day today) + outgoing quantity / day today 
            $a = clone $outgoing;
            $orderqty = $value->order_frequency * ($a->sum('quantity')/ date('d'));
            if ($orderqty < $value->maximum_order_quantity) {
                $temp['ordr'] = number_format($value->maximum_order_quantity, 2) ;
            } else {
                $temp['ordr'] = number_format($orderqty, 2);
            }

            //trigger point  (lead time of item * total quantity / day today) + outgoing quantity / day today  
            $a = clone $incoming_and_past; $b = clone $outgoing;
            if (($a->sum('quantity') - $b->sum('quantity')) <  $value->lead_time * ($b->sum('quantity') / date('d'))) {
                $temp['triggerpoint'] = "ORDER";
            }else{
                $temp['triggerpoint'] = "MANAGE";
            }
           

            $a = clone $incoming_and_past;  $b = clone $outgoing;
            $aa = clone $incoming; 
            $temp['ending_q'] =  ($a->sum('quantity') - $b->sum('quantity'));

            if($temp['begining_q'] > 0 ){ 
                $temp['ending_a'] =  number_format($temp['ending_q'] * ( $aa->sum('amount') / $aa->sum('quantity')),2);
            }else{
                $temp['ending_a'] = 0;
            }

        

            $a = clone $incoming_and_past;
            $temp['consumption_q'] =  $a->sum('quantity') - $temp['ending_q'];

            if($temp['begining_q'] > 0 ){ 
                $temp['consumption_a'] =  number_format($temp['consumption_q'] * ( $aa->sum('amount') / $aa->sum('quantity')),2);
            }else{
                $temp['consumption_a'] = 0;
            }
         

        
            $a = clone $incoming_and_past; $b = clone $outgoing;
            $temp['ideal_q'] =  $a->sum('quantity') - $b->sum('quantity')  ; 
            $aa = clone $incoming; 
            if($temp['ideal_q'] > 0 ){ 
                $temp['ideal_a'] =  number_format($temp['ideal_q'] * ( $aa->sum('amount') / $aa->sum('quantity')),2);
            }else{
                $temp['ideal_a'] = 0;
            }

 

            $temp['variance_q'] = $temp['ending_q'] -  $temp['ideal_q'];  
            $aa = clone $incoming; 
            if($temp['variance_q']  > 0 ){ 
                $temp['variance_a'] =  number_format($temp['ending_q'] - ($temp['ending_q'] * ( $aa->sum('amount') / $aa->sum('quantity'))) ,2);
            }else{
                $temp['variance_a'] = 0;
            } 
            array_push($return, $temp);
        }

        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(),$t->itemsPerPage, $t->page, []);
    }
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
}
