<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_outgoingsupp;
use App\Models\tbl_purchaseord;
use App\Models\tbl_pos;
use App\Models\tbl_supplist;
use App\Models\tbl_branches;
use App\Models\tbl_vat;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;
use App\Exports\InventoryExport2;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    // Masterlist Supplies Report - OK
    public function MasterlistSuppliesReport(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_masterlistsupp::with("category")
                                ->where("category", $t->category)
                                ->selectRaw("*, @row:=@row+1 as row ")->get();

 
    
        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.masterlistsupplies', $content, [], [
                'format' => 'A4-L'
            ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','WITH VAT','VAT','WITHOUT VAT','EXPIRATION DATE'];
            //data
                $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                $temp['supply_name'] = $value->supply_name . " " . $value->description;
                $temp['unit'] = $value->unit;
                $temp['format_net_price'] = $value->net_price;
                $temp['format_with_vat'] = $value->with_vat;
                $temp['vat'] = $value->vat;
                $temp['format_without_vat'] = $value->without_vat;
                $temp['exp_date'] = ($value->exp_date? date("Y-m-d", strtotime($value->exp_date)):null);
                array_push($dataitems, $temp);
            }
            return Excel::download(new InventoryExport($dataitems, $columns), "Masterlist Supplies Report.xlsx");
        break;
        case 'print':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.masterlistsupplies', $content, [], [
                'format' => 'A4-L'
            ]);
            return $pdf->stream();
        break;
        default:
        # code...
        break;
        }
    }

    // Incoming Supplies Report - OK
    public function IncomingSuppliesReport(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_incomingsupp::where("category", $t->category)
                                    ->whereBetween("incoming_date", [$t->from,  $t->to])
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.incomingsupplies', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','WITH VAT','QTY','TOTAL AMT','DATE'];
            //data
                $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                $temp['supply_name'] = $value->supply_name_details['supply_name'] . " " . $value->supply_name_details['description'];
                $temp['unit'] = $value->supply_name_details['unit'];
                $temp['net_price'] = $value->supply_name_details['net_price'];
                $temp['with_vat'] = $value->supply_name_details['with_vat'];
                $temp['quantity'] = $value->quantity;
                $temp['total_amount'] = $value->amount;
                $temp['incoming_date'] = ($value->incoming_date?  date("Y-m-d", strtotime($value->incoming_date)):null);
                array_push($dataitems, $temp);
            }
            return Excel::download(new InventoryExport($dataitems, $columns), "Incoming Supplies Report.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }

    // Outgoing Supplies Report - OK
    public function OutgoingSuppliesReport(Request $t)
    {
        $content = [];
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_outgoingsupp::where("requesting_branch", $t->branch)
                                    ->where("category", $t->category)
                                    ->whereBetween("outgoing_date", [ $t->from, $t->to ])
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.outgoingsupplies', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','WITH VAT','QTY','TOTAL AMT','DATE'];
            //data
            $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                $temp['supply_name'] = $value->supply_name_details['supply_name'] . " " . $value->supply_name_details['description'];
                $temp['unit'] = $value->supply_name_details['unit'];
                $temp['net_price'] = $value->supply_name_details['net_price'];
                $temp['with_vat'] = $value->supply_name_details['with_vat'];
                $temp['quantity'] = $value->quantity;
                $temp['amount'] =  number_format($value->with_vat_price * $value->quantity, 2) ;
                $temp['outgoing_date'] = ($value->outgoing_date?  date("Y-m-d", strtotime($value->outgoing_date)):null);
                array_push($dataitems, $temp);
            }
            return Excel::download(new InventoryExport($dataitems, $columns), "Outgoing Supplies Report.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }

    // Main Inventory Report - OK
    public function MainInventoryReport(Request $t)
    {
        $data = tbl_masterlistsupp::where("category", $t->category)->get();

        $date11 =  date("Y-m-d H:i:s", strtotime("-1 month", strtotime(date("Y")."-".date("m")."-01". ' 00:00:00'))) ;
        $date22 = cal_days_in_month(CAL_GREGORIAN, (date("m")-1), date("Y"));
        $date22 = date("Y-m-d H:i:s", strtotime("-1 month", strtotime(date("Y")."-".date("m")."-".$date22.  ' 23:59:59')));
    

        $date1 =  date("Y-m-d H:i:s", strtotime(date("Y")."-".date("m")."-01". ' 00:00:00'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $date2 = date("Y-m-d H:i:s", strtotime(date("Y").'-'.date("m").'-'.$date2.' 23:59:59'));
        
        
        $return = [];
        $row = 1;
        foreach ($data as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  tbl_suppcat::where("id", $value->category)->first()->supply_cat_name ;
            $temp['supply_name'] =  $value->supply_name ;
            $temp['description'] =  $value->description ;
            $temp['unit'] =  $value->unit ;
            $temp['net_price'] =  $value->net_price ;
            $temp['lead_time'] =  $value->lead_time;
            $temp['minimum_order_quantity'] =  $value->minimum_order_quantity ;
            $temp['order_frequency'] =  $value->order_frequency ;
            
            $incoming = tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date', [$date1,$date2]);
            $outgoing = tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date', [$date1,$date2]);

            $incoming_past = tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date', [$date11,$date22]);
            $outgoing_past = tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date', [$date11,$date22]);

            $incoming_and_past = tbl_incomingsupp::where('supply_name', $value->id) ->whereBetween('incoming_date', [$date11,$date2]);
            $outgoing_and_past = tbl_outgoingsupp::where('supply_name', $value->id) ->whereBetween('outgoing_date', [$date11,$date2]);

            //begining (total of last month)
            $a = clone $incoming_past;
            $temp['begining_q'] = $a->sum('quantity');
            $a = clone $incoming_past;
            $temp['begining_a'] = number_format($a->sum('amount'), 2);

            //incming (total of current month)
            $a = clone $incoming;
            $temp['incoming_q'] = $a->sum('quantity');
            $a = clone $incoming;
            $temp['incoming_a'] = number_format($a->sum('amount'), 2);

            //total (total of last month + current month)
            $a = clone $incoming_and_past;
            $temp['total_q'] = $temp['begining_q'] + $temp['incoming_q'] ;
            $temp['total_a'] =  number_format($a->sum('amount'), 2) ;
    
            //outgoing (total of current month)
            $b = clone $outgoing;
            $temp['outgoing_q'] = $b->sum('quantity');
            $b = clone $outgoing;
            $temp['outgoing_a'] = number_format($b->sum('amount'), 2);
            
            //onhand (total of last month + current month) - outgoing
            $c = clone $incoming_and_past;
            $d = clone $outgoing;
            $temp['onhand_q'] = $c->sum('quantity') - $d->sum('quantity') ;
            $c_a = clone $incoming_and_past;
            $cc_a = clone $incoming_and_past;
            if ($c_a->sum('quantity') > 0) {
                $temp['onhand_a'] =     number_format(($c_a->sum('amount') / $cc_a->sum('quantity') * $temp['onhand_q']), 2);
            } else {
                $temp['onhand_a'] = 0;
            }
    
            //average (total of last month + current month / quantity of last month + current month) / (current month quantity / date today)
            $a = clone $outgoing;
            $temp['average_q'] =   number_format($a->sum('quantity') / date('d'), 2);
            $c_a = clone $incoming_and_past;
            $cc_a = clone $incoming_and_past;
            if ($c_a->sum('quantity') > 0) {
                $temp['average_a'] =     number_format(($c_a->sum('amount') / $cc_a->sum('quantity') *  $temp['average_q']), 2);
            } else {
                $temp['average_a'] = 0;
            }
    
            //order poin  (lead time of item * total quantity / day today) + outgoing quantity / day today
            $a = clone $outgoing;
            $temp['orderpoint'] =  number_format(($value->lead_time * ($a->sum('quantity') / date('d'))) + (($a->sum('quantity') / date('d')) * 2), 2) ;

            //order point  (lead time of item * total quantity / day today) + outgoing quantity / day today
            $a = clone $outgoing;
            $orderqty = $value->order_frequency * ($a->sum('quantity')/ date('d'));
            if ($orderqty < $value->minimum_order_quantity) {
                $temp['ordr'] = number_format($value->minimum_order_quantity, 2) ;
            } else {
                $temp['ordr'] = number_format($orderqty, 2);
            }

            //trigger point  (lead time of item * total quantity / day today) + outgoing quantity / day today
            $a = clone $incoming_and_past;
            $b = clone $outgoing;
            if (($a->sum('quantity') - $b->sum('quantity')) <  $value->lead_time * ($b->sum('quantity') / date('d'))) {
                $temp['triggerpoint'] = "Order";
            } else {
                $temp['triggerpoint'] = "Manage";
            }
            
            $a = clone $incoming_and_past;
            $b = clone $outgoing;
            $aa = clone $incoming;
            $temp['ending_q'] =  ($a->sum('quantity') - $b->sum('quantity'));

            if ($temp['begining_q'] > 0) {
                $temp['ending_a'] =  number_format($temp['ending_q'] * ($aa->sum('amount') / $aa->sum('quantity')), 2);
            } else {
                $temp['ending_a'] = 0;
            }

            $a = clone $incoming_and_past;
            $temp['consumption_q'] =  $a->sum('quantity') - $temp['ending_q'];

            if ($temp['begining_q'] > 0) {
                $temp['consumption_a'] =  number_format($temp['consumption_q'] * ($aa->sum('amount') / $aa->sum('quantity')), 2);
            } else {
                $temp['consumption_a'] = 0;
            }
        
            $a = clone $incoming_and_past;
            $b = clone $outgoing;
            $temp['ideal_q'] =  $a->sum('quantity') - $b->sum('quantity')  ;
            $aa = clone $incoming;
            if ($temp['ideal_q'] > 0) {
                $temp['ideal_a'] =  number_format($temp['ideal_q'] * ($aa->sum('amount') / $aa->sum('quantity')), 2);
            } else {
                $temp['ideal_a'] = 0;
            }

            $temp['variance_q'] = $temp['ending_q'] -  $temp['ideal_q'];
            $aa = clone $incoming;
            if ($temp['variance_q']  > 0) {
                $temp['variance_a'] =  number_format($temp['ending_q'] - ($temp['ending_q'] * ($aa->sum('amount') / $aa->sum('quantity'))), 2);
            } else {
                $temp['variance_a'] = 0;
            }
            array_push($return, $temp);
        }
        switch ($t->type) {

        case 'pdf':
        $content['data'] = $return;
                    $pdf = PDF::loadView('reports.maininventory', $content, [], [
                        'format' => 'A4-L'
              ]);
        return $pdf->stream();
        break;
        case 'excel':
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','BEGINNING INVENTORY','',
                        'INCOMING SUPPLIES','','TOTAL STOCKS','','OUTGOING SUPPLIES','',
                        'STOCKS ON HAND','','AVERAGE DAILY USAGE','','LEAD TIME','ORDER POINT',
                        'MINIMUM ORDER QTY','ORDER QTY','TRIGGER POINT','ENDING INVENTORY','',
                        'CONSUMPTION','','IDEAL INVENTORY','','VARIANCE',''];
       
            $dataitems = [["","","","","QTY","VALUE","QTY","VALUE","QTY","VALUE","QTY","VALUE",
                           "QTY","VALUE","QTY","VALUE","","","","","","QTY","VALUE","QTY","VALUE",
                           "QTY","VALUE","QTY","VALUE"]];
            foreach ($return as $key => $value) {
                $temp = [];
                $temp['category'] = $value['category'] ;
                $temp['supply_name'] = $value['supply_name'] . " " . $value['description'];
                $temp['unit'] = $value['unit'];
                $temp['net_price'] =  $value['net_price']??0;
                $temp['begining_q'] = $value['begining_q']??0;
                $temp['begining_a'] =  $value['begining_a']??0;
                $temp['incoming_q'] = $value['incoming_q']??0;
                $temp['incoming_a'] =  $value['incoming_a']??0;
                $temp['total_q'] = $value['total_q']??0;
                $temp['total_a'] =  $value['total_a']??0;
                $temp['outgoing_q'] =  $value['outgoing_q']??0;
                $temp['outgoing_a'] =  $value['outgoing_a']??0;
                $temp['onhand_q'] =  $value['onhand_q']??0;
                $temp['onhand_a'] =  $value['onhand_a']??0;
                $temp['average_q'] =  $value['average_q']??0;
                $temp['average_a'] =  $value['average_a']??0;
                $temp['lead_time'] =  $value['lead_time']??0;
                $temp['orderpoint'] =  $value['orderpoint']??0;
                $temp['minimum_order_quantity'] =  $value['minimum_order_quantity']??0;
                $temp['ordr'] =  $value['ordr']??0;
                $temp['triggerpoint'] =  $value['triggerpoint']??0;
                $temp['ending_q'] =  $value['ending_q']??0;
                $temp['ending_a'] =  $value['ending_a']??0;
                $temp['consumption_q'] =  $value['consumption_q']??0;
                $temp['consumption_a'] =  $value['consumption_a']??0;
                $temp['ideal_q'] =  $value['ideal_q']??0;
                $temp['ideal_a'] =  $value['ideal_a']??0;
                $temp['variance_q'] =  $value['variance_q']??0;
                $temp['variance_a'] =  $value['variance_a']??0;
                array_push($dataitems, $temp);
            }
           return Excel::download(new InventoryExport2($dataitems, $columns), "Main Inventory Report.xlsx");
        break;
        case 'print':
        break;
        default:
        # code...
        break;
        }
    }

    // Inventory Summary Report - OK
    public function InventorySummaryReport(Request $t)
    {
        $data_temp = tbl_suppcat::all();
        // Laravel default format of date and time, use other format will handle exemptions
  
        $date11 = date("Y-m-d H:i:s", strtotime("-1 month", strtotime($t->year."-".$t->month."-01". ' 00:00:01'))) ;
        $date22 = cal_days_in_month(CAL_GREGORIAN, ($t->month-1), $t->year);
        $date22 = date("Y-m-d H:i:s", strtotime("-1 month", strtotime($t->year."-".$t->month."-".$date22.  ' 23:59:59')));


        $date1 = date("Y-m-d H:i:s", strtotime($t->year."-".$t->month."-01". ' 00:00:01'));
        $date2 = cal_days_in_month(CAL_GREGORIAN, $t->month, $t->year);
        $date2 = date("Y-m-d H:i:s", strtotime($t->year.'-'.$t->month.'-'.$date2.' 23:59:59'));
         
        $data = [];
        foreach ($data_temp as $key => $value) {
            $temp = [];
            $temp['category'] = $value->supply_cat_name;

            $temp['begining_orig'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") ;
            $temp['begining'] = number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount"), 2);
            // Get incoming based on from, to and per category, then sum amounts
            $temp['incoming_orig'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") ;
            $temp['incoming'] = number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"), 2);
            // beg + in
            $temp['total_orig'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")  ;
            $temp['total'] =  number_format(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount"), 2) ;
            // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
            $temp['outgoing_orig'] = tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount");
            $temp['outgoing'] = number_format(tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"), 2);
            // stocks = total - outgoing
            $temp['stocks_orig'] =   (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")) -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount") ;
            $temp['stocks'] = number_format((tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount")) -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"), 2);
            try {
                $temp['ending'] = number_format(
                    (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date2])->get()->sum("quantity") -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity")) *
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")),
                    2
                );
            } catch (\Throwable $th) {
                $temp['ending'] = number_format(0, 2);
            }
            try {
                $temp['ending_orig'] =
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11,$date2])->get()->sum("quantity") -tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity")) *
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity")) ;
            } catch (\Throwable $th) {
                $temp['ending_orig'] =  0 ;
            }
            try {
                $temp['variance'] = number_format($temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity")) *
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount")), 2);
            } catch (\Throwable $th) {
                $temp['variance'] = number_format(0, 2);
            }
            try {
                $temp['variance_orig'] =  $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity")) *
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['variance_orig'] = 0 ;
            }
            try {
                $temp['fluctuation'] = number_format($temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity")) *
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount")), 2);
            } catch (\Throwable $th) {
                $temp['fluctuation'] = number_format(0, 2);
            }
            try {
                $temp['fluctuation_orig'] = $temp['ending'] -    (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("quantity") -tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("quantity")) *
                (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date2])->get()->sum("quantity"))(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1,$date22])->get()->sum("amount")
                -  tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1,$date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['fluctuation_orig'] = 0 ;
            }
      
            array_push($data, $temp);
        }
        switch ($t->type) {
        case 'pdf':
           
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.inventorysummary', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['SUPPLIES CATEGORY','INCOMING SUPPLIES','OUTGOING SUPPLIES','STOCKS ON HAND'];
            return Excel::download(new InventoryExport($data, $columns), "Inventory Summary Report.xlsx");
        break;
        case 'print':
        break;
        default:
        # code...
        break;
        }
    }

    // Sales Report - OK
    public function SalesReport(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
       
        $data = tbl_pos::where("branch", $t->branch)
            ->whereBetween("created_at", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])
            ->selectRaw(" sum(quantity) as quantity, sum(sub_total_discounted) as sub_total_discounted, branch ,created_at, reference_no  ")
            ->groupby(["branch","created_at","reference_no"])
            ->get();
              
        switch ($t->type) {
            case 'pdf':
                $content['data'] = $data;
                $pdf = PDF::loadView('reports.sales', $content, [], [
                    'format' => 'A4-L'
                  ]);
                return $pdf->stream();
            break;
            case 'excel':
                //columns
                $columns = ['BRANCH','DATE','REFERENCE NO','SALES AMOUNT'];
                //data
                $dataitems = [];
                foreach ($data as $key => $value) {
                    $temp = [];
                    $temp['branch_name'] = $value->branch_name_details['branch_name'];
                    $temp['created_at'] = date("Y-m-d", strtotime($value->created_at));
                    $temp['reference_no'] = $value->reference_no;
                    $temp['sub_total_discounted'] = $value->sub_total_discounted;
                    array_push($dataitems, $temp);
                }
                return Excel::download(new InventoryExport($dataitems, $columns), "Sales Report.xlsx");
            break;
            case 'print':
    
            break;
            default:
            # code...
            break;
            }
    }

    // Transaction Report - OK
    public function TransactionReport(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_pos::whereBetween("created_at", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])
                       ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.transaction', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['BRANCH','DATE ','REFERENCE NO','TOTAL PRODUCT(S)','TOTAL AMT'];
            //data
                $dataitems = [];
             foreach ($data as $key => $value) {
                 $temp = [];
                 $temp['branch_name'] = $value->branch_name_details['branch_name'];
                 $temp['created_at'] = date("Y-m-d", strtotime($value->created_at));
                 $temp['reference_no'] = $value->reference_no;
                 $temp['quantity'] = $value->quantity;
                 $temp['total_amount'] = $value->total_amount;
                 array_push($dataitems, $temp);
             }
            return Excel::download(new InventoryExport($dataitems, $columns), "Transaction Report.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }

    // Purchase ORder Report - OK
    public function PurchaseOrderReport(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_purchaseord::whereBetween('incoming_date', [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])
                                        ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.purchaseorder', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            // Columns
            $columns = ['SUPPLIER NAME','INVOICE NUMBER','AMT','DATE'];
            // Data
            $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['supplier_name'] = tbl_supplist::where("id", $value->supplier_name)->first()->supplier_name;
                $temp['invoice_number'] = $value->invoice_number;
                $temp['format_amount'] = $value->format_amount;
                $temp['incoming_date'] = date("Y-m-d", strtotime($value->incoming_date));
                array_push($dataitems, $temp);
            }
            return Excel::download(new InventoryExport($dataitems, $columns), "Purchase Order Report.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }

    public function ListSP(Request $t)
    {
        if (auth()->user()->can('Access POS')) {
            $table = tbl_pos::with(["branch"])
            ->where('branch', auth()->user()->branch)
            ->where('cashier', auth()->user()->id)
            ->selectRaw(" sum(quantity) as quantity, sum(sub_total_discounted) as sub_total_discounted, branch ,created_at, reference_no  ")
            ->orderBy('created_at', "desc") ->groupby(["branch","created_at","reference_no"])
             ;
        } else {
            $table = tbl_pos::with(["branch"])
            ->selectRaw(" sum(quantity) as quantity, sum(sub_total_discounted) as sub_total_discounted, branch ,created_at, reference_no  ")
            ->groupby(["branch","created_at","reference_no"])
             ;
        }

        if ($t->branch) {
            $table->where("branch", $t->branch);
        }
     
        if ($t->search) {
            $table->where("reference_no", "like", "%".$t->search."%");
        }
        if ($t->dateFromSP && $t->dateUntilSP) {
            $table->whereBetween("created_at", [date("Y-m-d H:i:s", strtotime($t->dateFromSP . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->dateUntilSP . ' 11:59:59'))]);
        }

        $return = [];
        $row = 1;
        foreach ($table->get() as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['quantity'] =  $value->quantity;
            $temp['sub_total_discounted'] =  number_format($value->sub_total_discounted, 2, ".", ",") ;
            $temp['branch'] =   $value->branch ;
            $temp['branch_name'] = tbl_branches::where("id", $value->branch)->first()->branch_name;
            $temp['created_at'] =  date("Y-m-d", strtotime($value->created_at)) ;
            $temp['reference_no'] =  $value->reference_no;
            array_push($return, $temp);
        }
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page);
    }

    public function getSPInfo(Request $t)
    {
        return  tbl_pos::with(["branch",'product_name','cashier'])->where("reference_no", $t->reference_no)->get();
    }

    public function Receipt(Request $t)
    {
        if ($t->reference_no) {
            $data = tbl_pos::where("reference_no", $t->reference_no)->get();
               
            $temp = [];
            $temp['data'] = $data;
            $temp['branch'] = $data[0]->branch_name_details->branch_name  ;
            $temp['branch_location'] = $data[0]->branch_name_details->location;
            $temp['branch_number'] = $data[0]->branch_name_details->phone_number;
            $temp['reference_no'] = $data[0]->reference_no;
            $temp['created_at'] = $data[0]->created_at;
            $temp['mode'] = $data[0]->mode;
            $temp['change'] = $data[0]->change;
            $temp['discount'] = $data[0]->discount;
            $temp['payment'] = $data[0]->payment;


            $data_cloned = clone $data;
            $temp['sub_total'] = $data_cloned->sum('sub_total')  ;
            $data_cloned = clone $data;
            $temp['sub_total_discounted'] = $data_cloned->sum('sub_total_discounted');
            $temp['cashier_name_details'] = User::where("id", $data[0]->cashier)->first()->name;
            $temp['vatable_sales'] = $data_cloned->sum('sub_total') / tbl_vat::where("type", "p")->first()->vat;
            $temp['vat_amount'] = $data_cloned->sum('sub_total') -  ($data_cloned->sum('sub_total') / tbl_vat::where("type", "p")->first()->vat);
        
          
            $data_cloned = clone $data;
            $pdf = PDF::loadView(
                'receipt.receipt',
                $temp,
                [],
                ['format' => ['57', 76 + (27 * $data_cloned->count())],
                'margin_left' => 3,
                'margin_right' => 3,
                'margin_top' => 5,
                'margin_bottom' => 5,
              ]
            );
            return $pdf->stream();
        }
    }
}
