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

        $return = [];
        $row = 1;
        foreach ($table as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  tbl_suppcat::where("id",$value->category)->first()->supply_cat_name ;
            $temp['supply_name'] =  $value->supply_name ;
            $temp['unit'] =  $value->unit ;
            $temp['net_price'] =  $value->net_price ;  

            $temp['incoming_q'] =  tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity');
            $temp['incoming_a']    = number_format( tbl_incomingsupp::where('supply_name', $value->id)->sum('amount'),2);
            $temp['outgoing_q'] =  tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity');
            $temp['outgoing_a']    =   number_format(tbl_outgoingsupp::where('supply_name', $value->id)->sum('amount'),2);
         
            $temp['onhand_q'] =  tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity');
            $temp['onhand_a'] =  number_format((tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity') > 0 ? tbl_incomingsupp::where('supply_name', $value->id)->sum('amount') / tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity'):0),2);
         

            $temp['average_q'] =  tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d');
            $temp['average_a'] = number_format((tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity') > 0? (tbl_incomingsupp::where('supply_name', $value->id)->sum('amount') / tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity')) * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d')):0),2) ;

            $temp['orderpoint'] = number_format( ( $value->lead_time * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d')) + ((tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d')) * 2)),2);
            $orderqty = $value->order_frequency * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d'));
            if($orderqty < $value->maximum_order_quantity  ){
                $temp['ordr'] = number_format($value->maximum_order_quantity,2) ;
            }else{
                $temp['ordr'] = number_format($orderqty,2);
            }
            if(tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity') - tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') <  $value->lead_time * (tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity') / date('d'))){
                $temp['triggerpoint'] = "ORDER";
            }else{
                $temp['triggerpoint'] = "MANAGE";
            }
           


            $temp['variance_q'] =  tbl_incomingsupp::where('supply_name', $value->id)->sum('quantity') -   tbl_outgoingsupp::where('supply_name', $value->id)->sum('quantity');
            $temp['variance_a']    =  number_format(tbl_incomingsupp::where('supply_name', $value->id)->sum('amount') - tbl_outgoingsupp::where('supply_name', $value->id)->sum('amount'),2);
         
          



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
