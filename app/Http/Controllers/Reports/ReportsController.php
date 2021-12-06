<?php

namespace App\Http\Controllers\Reports;

use App\Exports\InventoryExport2;
use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use App\Models\tbl_branches;
use App\Models\tbl_company;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_outgoingsupp;
use App\Models\tbl_pos;
use App\Models\tbl_purchaseord;
use App\Models\tbl_suppcat;
use App\Models\tbl_supplist;
use App\Models\tbl_vat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReportsController extends Controller
{
    //Middleware
    public function __construct()
    {
        $this->middleware("auth");
    }

    //For masterlist supplies report
    public function MasterlistSuppliesReport(Request $t)
    {
        //Filter if all or specific
        $where = ($t->category == 'All' ? "   category != -1 " : ' category =' . $t->category);
        $data = []; //Main array

        //Get all the category then loop
        foreach (tbl_masterlistsupp::whereRaw($where)->groupBy('category')->pluck('category') as $key => $value) {
            $group = []; //Inner Array
            $net_p = 0; //Sub-Total
            $wvat_p = 0; //Sub-Total
            $wovat_p = 0; //Sub-Total

            //Each category add to inner array
            foreach (tbl_masterlistsupp::with("category")->where("category", $value)->orderBy("exp_date", "desc")->get() as $key1 => $value1) {
                $net_p += $value1->net_price;
                $wvat_p += $value1->with_vat;
                $wovat_p += $value1->without_vat;

                $ar = [
                    'category_details' => $value1->category_details['supply_cat_name'],
                    'supply_name' => $value1->supply_name,
                    'description' => $value1->description,
                    'unit' => $value1->unit,
                    'net_price' => $value1->net_price,
                    'with_vat' => $value1->with_vat,
                    'vat' => $value1->vat,
                    'without_vat' => $value1->without_vat,
                    'exp_date' => $value1->exp_date,
                ];
                array_push($group, $ar);
            }

            //Add inner array to main array (Nested array)
            $ar = [
                'category_details' => '',
                'supply_name' => ($t->type == 'excel' ? 'GRAND TOTAL' : '<b>GRAND TOTAL</b>'),
                'description' => '',
                'unit' => '',
                'net_price' => $net_p,
                'with_vat' => $wvat_p,
                'vat' => '',
                'without_vat' => $wovat_p,
                'exp_date' => '',
            ];
            array_push($group, $ar);
            array_push($data, $group);
        }

        $content = [];
        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    //Total amounts below the report
                    $content['net_price'] = tbl_masterlistsupp::get()->sum("net_price");
                    $content['with_vat'] = tbl_masterlistsupp::get()->sum("with_vat");
                    $content['without_vat'] = tbl_masterlistsupp::get()->sum("without_vat");
                    $content['process_by'] = auth()->user()->name;
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.masterlistsupplies', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = ['CATEGORY', 'SUPPLY NAME', 'UNIT', 'NET PRICE', 'WITH VAT', 'VAT', 'WITHOUT VAT', 'EXPIRATION DATE'];
                //Data
                $dataitems = [];

                foreach ($data as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $temp = [];
                        $temp['category'] = $value1['category_details'];
                        $temp['supply_name'] = $value1['supply_name'] . " " . $value1['description'];
                        $temp['unit'] = $value1['unit'];
                        $temp['format_net_price'] = $value1['net_price'];
                        $temp['format_with_vat'] = $value1['with_vat'];
                        $temp['vat'] = $value1['vat'];
                        $temp['format_without_vat'] = $value1['without_vat'];
                        $temp['exp_date'] = ($value1['exp_date'] ? date("Y-m-d", strtotime($value1['exp_date'])) : null);
                        array_push($dataitems, $temp);
                    }
                }
                return Excel::download(new InventoryExport($dataitems, $columns), "Masterlist Supplies Report.xlsx");
                break;
            default:
                break;
        }
    }

    //For incoming supplies report
    public function IncomingSuppliesReport(Request $t)
    {

 

        //Filter if all or specific
        $where = ($t->category == 'All' ? "   category != -1 " : ' category =' . $t->category);
        $data = []; //Main array
        //Get all the category then loop
        $g_net_p = 0; //Grand Total
        $g_wvat_p = 0; //Grand Total
        $g_total_p = 0; //Grand Total

        foreach (tbl_incomingsupp::whereRaw($where)
            ->whereBetween("incoming_date", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
            ->groupBy('category')->pluck('category') as $key => $value) {
            $group = []; //Inner Array
       
           
            $net_p = 0; //Sub-Total
            $wvat_p = 0; //Sub-Total
            $total_p = 0; //Sub-Total
            //Each category add to inner array
            foreach ( tbl_incomingsupp::with("category")
            ->whereBetween("incoming_date", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
            ->join('tbl_masterlistsupps', 'tbl_masterlistsupps.id', '=', 'tbl_incomingsupps.supply_name')
            ->orderBy('tbl_masterlistsupps.supply_name', 'ASC')
            ->groupBy('tbl_incomingsupps.supply_name')
            ->pluck('tbl_incomingsupps.supply_name') as $key2 => $value2) {
            $group2 = [];
            $ar2 = [];

            $s_total_a = 0;
            $s_qty = 0; //Sub-Total
            $s_flc = 0;
       
            
                foreach (tbl_incomingsupp::with("category")->where("category", $value)->where("supply_name",$value2)
                    ->whereBetween("incoming_date", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
                    ->get() as $key1 => $value1) {

                    $net_p += $value1->supply_name_details['net_price'];
                    $wvat_p += $value1->with_vat;
                    $total_p += $value1->quantity_amount;

                    $s_total_a += $value1->quantity_amount;
                    $s_qty +=  $value1->quantity;

                    $s_flc =  number_format($value1->fluctuation,2); //condition mo nlang. 
 
                    $g_net_p += $value1->supply_name_details['net_price'];
                    $g_wvat_p += $value1->with_vat;
                    $g_total_p += $value1->quantity_amount;

            
                    $ar = [
                        'category_details' => $value1->category_details['supply_cat_name'],
                        'supply_name' => $value1->supply_name_details['supply_name'],
                        'description' => $value1->supply_name_details['description'],
                        'unit' => $value1->supply_name_details['unit'],
                        'net_price' => $value1->supply_name_details['net_price'],
                        'with_vat' => $value1->with_vat,
                        'quantity' => $value1->quantity,
                        'quantity_amount' => $value1->quantity_amount,
                        'incoming_date' => $value1->incoming_date,
                    ]; 
                    array_push($group2, $ar);
                }
                if(tbl_incomingsupp::with("category")->where("category", $value)->where("supply_name",$value2)
                ->whereBetween("incoming_date", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
                ->count() > 0){
                    $ar2 = [ 
                        'category_details' =>'',
                        'supply_name' => 'Total Amount: '.$s_total_a. '<br> Total Quantity: '.$s_qty. ' <br> Fluctuation: '.$s_flc,
                        'description' => '',
                        'unit' =>'',
                        'net_price' => '',
                        'with_vat' => '',
                        'quantity' => '',
                        'quantity_amount' =>'',
                        'incoming_date' =>'',
                    ];
    
                    array_push($group2, $ar2);  //Add inner array to main array (Nested array)
                }
                

                array_push($group, $group2);
              
            }
         
            $ar = [
                'category_details' => '',
                'supply_name' => ($t->type == 'excel' ? 'GRAND TOTAL' : '<b>GRAND TOTAL</b>'),
                'description' => '',
                'unit' => '',
                'net_price' => $net_p,
                'with_vat' => $wvat_p,
                'quantity' => '',
                'quantity_amount' => $total_p,
                'incoming_date' => '',
            ];
            array_push($group2,$ar);
            array_push($group, $group2);
            array_push($data, $group);
        }

        $content = [];
        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    $content['net_price'] = $g_net_p;
                    $content['with_vat'] = $g_wvat_p;
                    $content['quantity_amount'] = $g_total_p;
                    $content['process_by'] = auth()->user()->name;
                    $content['param'] = ['from' => $t->from, 'to' => $t->to];
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.incomingsupplies', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = ['CATEGORY', 'SUPPLY NAME', 'UNIT', 'NET PRICE', 'WITH VAT', 'QTY', 'TOTAL AMT', 'INCOMING DATE'];
                //Data
                $dataitems = [];

                foreach ($data as $key => $value) {
                    foreach ($value as $key2=> $value2) {
                        foreach ($value2 as $key1 => $value1) {
                             
                                $temp = [];
                                $temp['category'] = $value1['category_details'];
                                $temp['supply_name'] = $value1['supply_name'] . " " . $value1['description'];
                                $temp['unit'] = $value1['unit'];
                                $temp['net_price'] = $value1['net_price'];
                                $temp['with_vat'] = $value1['with_vat'];
                                $temp['quantity'] = $value1['quantity'];
                                $temp['total_amount'] = $value1['quantity_amount'];
                                $temp['incoming_date'] = ($value1['incoming_date'] ? date("Y-m-d", strtotime($value1['incoming_date'])) : null);
                                array_push($dataitems, $temp);
                           
                        }
                    }
                }
                return Excel::download(new InventoryExport($dataitems, $columns), "Incoming Supplies Report.xlsx");
                break;
            default:
                break;
        }
    }

    //For outgoing supplies report
    public function OutgoingSuppliesReport(Request $t)
    {
        //Filter if all or specific
        $where = ($t->category == 'All' ? "   category != -1 " : ' category =' . $t->category) .
            ($t->branch ? ' and requesting_branch = ' . $t->branch : '');
        $data = []; //Main array
        //Get all the category then loop
        $g_net_p = 0; //Grand Total
        $g_wvat_p = 0; //Grand Total
        $g_total_p = 0; //Grand Total
        $g_quantity = 0; //Grand Total
        $g_total_amount = 0; //Grand Total

        foreach (tbl_outgoingsupp::whereRaw($where)
            ->whereBetween("outgoing_date", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
            ->groupBy('category')->pluck('category') as $key => $value) {
            $group = []; //Inner array
            $net_p = 0; //Sub-Total
            $wvat_p = 0; //Sub-Total
            $quantity = 0; //Sub-Total
            $total_p = 0; //Sub-Total

            //Each category add to inner array
            if ($t->branch) {
                $t_branch = ' requesting_branch =' . $t->branch;
            }

            foreach (tbl_outgoingsupp::with("category")->whereRaw($t_branch)->where("category", $value)
                ->whereBetween("outgoing_date", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
                ->get() as $key1 => $value1) {

                $net_p += $value1->supply_name_details['net_price'];
                $wvat_p += $value1->with_vat_price;
                $total_p += $value1->with_vat_price * $value1->quantity;
                $quantity += $value1->quantity;

                $g_net_p += $value1->supply_name_details['net_price'];
                $g_wvat_p += $value1->with_vat_price;
                $g_total_p += $value1->with_vat_price * $value1->quantity;
                $g_quantity += $value1->quantity;

                $ar = [
                    'category_details' => $value1->category_details['supply_cat_name'],
                    'supply_name' => $value1->supply_name_details['supply_name'],
                    'description' => $value1->supply_name_details['description'],
                    'unit' => $value1->supply_name_details['unit'],
                    'net_price' => $value1->supply_name_details['net_price'],
                    'with_vat' => $value1->with_vat_price,
                    'quantity' => $value1->quantity,
                    'quantity_amount' => $value1->with_vat_price * $value1->quantity,
                    'branch' => $value1->requesting_branch_details['branch_name'],
                    'outgoing_date' => $value1->outgoing_date,
                ];
                array_push($group, $ar);
            }

            // Add inner array to main array (Nested array)
            $ar = [
                'category_details' => '',
                'supply_name' => ($t->type == 'excel' ? 'GRAND TOTAL' : '<b>GRAND TOTAL</b>'),
                'description' => '',
                'unit' => '',
                'net_price' => $net_p,
                'with_vat' => $wvat_p,
                'quantity' => '',
                'quantity_amount' => $total_p,
                'branch' => '',
                'outgoing_date' => '',
            ];
            array_push($group, $ar);
            array_push($data, $group);
        }

        $content = [];
        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    $content['net_price'] = $g_net_p;
                    $content['with_vat'] = $g_wvat_p;
                    $content['quantity'] = $g_quantity;
                    $content['quantity_amount'] = $g_total_p;
                    $content['process_by'] = auth()->user()->name;
                    $content['param'] = ['from' => $t->from, 'to' => $t->to];
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.outgoingsupplies', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = ['CATEGORY', 'SUPPLY NAME', 'UNIT', 'NET PRICE', 'WITH VAT', 'QTY', 'TOTAL AMT', 'OUTGOING DATE'];
                //Data
                $dataitems = [];
                foreach ($data as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $temp = [];
                        $temp['category'] = $value1['category_details'];
                        $temp['supply_name'] = $value1['supply_name'] . " " . $value1['description'];
                        $temp['unit'] = $value1['unit'];
                        $temp['net_price'] = $value1['net_price'];
                        $temp['with_vat'] = $value1['with_vat'];
                        $temp['quantity'] = $value1['quantity'];
                        $temp['amount'] = $value1['quantity_amount'];
                        $temp['outgoing_date'] = ($value1['outgoing_date'] ? date("Y-m-d", strtotime($value1['outgoing_date'])) : null);
                        array_push($dataitems, $temp);
                    }
                }
                return Excel::download(new InventoryExport($dataitems, $columns), "Outgoing Supplies Report.xlsx");
                break;
            default:
                break;
        }
    }

    //For main inventory report
    public function MainInventoryReport(Request $t)
    {
        //Previous month
        $date11 = date("Y-m-d 00:00:00", strtotime("-1 month", strtotime(date("Y") . "-" . date("m") . "-01")));
        $date22 = date("Y-m-t 23:59:59", strtotime("-1 month", strtotime(date("Y") . "-" . date("m") . "-" . date("t"))));
        //Current month
        $date1 = date("Y-m-d 00:00:00", strtotime(date("Y") . "-" . date("m") . "-01"));
        $date2 = date("Y-m-t 23:59:59", strtotime(date("Y") . '-' . date("m") . '-' . date("t")));

        $where = ($t->category == 'All' ? "   category != -1 " : ' category =' . $t->category);
        $return = [];
        $row = 1;

        foreach (tbl_masterlistsupp::select('category')->whereRaw($where)->groupBy('category')->pluck('category') as $key1 => $value1) {
            $group = [];
            $st_beginning_a = 0; //Total
            $st_incoming_a = 0; //Total
            $st_total_a = 0; //Total
            $st_outgoing_a = 0; //Total
            $st_onhand_a = 0; //Total
            $st_average_a = 0; //Total
            $st_ending_a = 0; //Total
            $st_consumption_a = 0; //Total
            $st_ideal_a = 0; //Total
            $st_variance_a = 0; //Total

            foreach (tbl_masterlistsupp::where("category", $value1)->get() as $key => $value) {
                $temp = [];
                $temp['row'] = $row++;
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                $temp['supply_name'] = $value->supply_name . ' ' . $value->description;
                $temp['unit'] = $value->unit;
                $temp['net_price'] = $value->net_price;
                $temp['lead_time'] = $value->lead_time;
                $temp['minimum_order_quantity'] = $value->minimum_order_quantity;
                $temp['order_frequency'] = $value->order_frequency;

                $incoming = tbl_incomingsupp::where('supply_name', $value->id)->whereBetween('incoming_date', [$date1, $date2]);
                $outgoing = tbl_outgoingsupp::where('supply_name', $value->id)->whereBetween('outgoing_date', [$date1, $date2]);

                $incoming_past = tbl_incomingsupp::where('supply_name', $value->id)->whereBetween('incoming_date', [$date11, $date22]);
                $outgoing_past = tbl_outgoingsupp::where('supply_name', $value->id)->whereBetween('outgoing_date', [$date11, $date22]);

                $incoming_and_past = tbl_incomingsupp::where('supply_name', $value->id)->whereBetween('incoming_date', [$date11, $date2]);
                $outgoing_and_past = tbl_outgoingsupp::where('supply_name', $value->id)->whereBetween('outgoing_date', [$date11, $date2]);

                //Beginning (total of previous month)
                $a = clone $incoming_past;
                $temp['beginning_q'] = $a->sum('quantity');
                $a = clone $incoming_past;
                $temp['beginning_a'] = number_format($a->sum('amount'), 2);
                $st_beginning_a += $a->sum('amount'); //Sub-Total

                //Incoming (total of current month)
                $a = clone $incoming;
                $temp['incoming_q'] = $a->sum('quantity');
                $a = clone $incoming;
                $temp['incoming_a'] = number_format($a->sum('amount'), 2);
                $st_incoming_a += $a->sum('amount'); //Sub-Total

                //Total (total of previous month + current month)
                $a = clone $incoming_and_past;
                $temp['total_q'] = $temp['beginning_q'] + $temp['incoming_q'];
                $temp['total_a'] = number_format($a->sum('amount'), 2);
                $st_total_a += $a->sum('amount'); //Sub-Total

                //Outgoing (total of current month)
                $b = clone $outgoing;
                $temp['outgoing_q'] = $b->sum('quantity');
                $b = clone $outgoing;
                $temp['outgoing_a'] = number_format($b->sum('amount'), 2);
                $st_outgoing_a += $b->sum('amount'); //Sub-Total

                //Stocks On Hand (total of previous month + current month) - outgoing
                $c = clone $incoming_and_past;
                $d = clone $outgoing;
                $temp['onhand_q'] = $c->sum('quantity') - $d->sum('quantity');
                $c_a = clone $incoming_and_past;
                $cc_a = clone $incoming_and_past;
                if ($c_a->sum('quantity') > 0) {
                    $temp['onhand_a'] = number_format(($c_a->sum('amount') / $cc_a->sum('quantity') * $temp['onhand_q']), 2);
                    $st_onhand_a += $c_a->sum('amount') / $cc_a->sum('quantity') * $temp['onhand_q'];
                } else {
                    $temp['onhand_a'] = 0;
                }

                //Average ((total of last month + current month) / (quantity of last month + current month) / (current month quantity / date today))
                $a = clone $outgoing;
                $temp['average_q'] = number_format($a->sum('quantity') / date('d'), 2);
                $c_a = clone $incoming_and_past;
                $cc_a = clone $incoming_and_past;
                if ($c_a->sum('quantity') > 0) {
                    $temp['average_a'] = number_format(($c_a->sum('amount') / $cc_a->sum('quantity') * $temp['average_q']), 2);
                    $st_average_a += $c_a->sum('amount') / $cc_a->sum('quantity') * $temp['average_q'];
                } else {
                    $temp['average_a'] = 0;
                }

                //Order Point  (lead time of item * total quantity / day today) + outgoing quantity / current day today
                $a = clone $outgoing;
                $temp['orderpoint'] = number_format(($value->lead_time * ($a->sum('quantity') / date('d'))) + (($a->sum('quantity') / date('d')) * 2), 2);

                //Order Point  (lead time of item * total quantity / day today) + outgoing quantity / current day today
                $a = clone $outgoing;
                $orderqty = $value->order_frequency * ($a->sum('quantity') / date('d'));
                if ($orderqty < $value->minimum_order_quantity) {
                    $temp['ordr'] = number_format($value->minimum_order_quantity, 2);
                } else {
                    $temp['ordr'] = number_format($orderqty, 2);
                }

                //Trigger Point  (lead time of item * total quantity / day today) + outgoing quantity / day today
                $a = clone $incoming_and_past;
                $b = clone $outgoing;
                if (($a->sum('quantity') - $b->sum('quantity')) < $value->lead_time * ($b->sum('quantity') / date('d'))) {
                    $temp['triggerpoint'] = "Order";
                } else {
                    $temp['triggerpoint'] = "Manage";
                }

                //Ending
                $a = clone $incoming_and_past;
                $b = clone $outgoing;
                $aa = clone $incoming;
                $temp['ending_q'] = ($a->sum('quantity') - $b->sum('quantity'));
                if ($aa->sum('amount') > 0) {
                    $temp['ending_a'] = number_format($temp['ending_q'] * ($aa->sum('amount') / $aa->sum('quantity')), 2);
                    $st_ending_a += $temp['ending_q'] * ($aa->sum('amount') / $aa->sum('quantity'));
                } else {
                    $temp['ending_a'] = 0;
                }

                //Consumption
                $a = clone $incoming_and_past;
                $temp['consumption_q'] = $a->sum('quantity') - $temp['ending_q'];
                if ($aa->sum('amount') > 0) {
                    $temp['consumption_a'] = number_format($temp['consumption_q'] * ($aa->sum('amount') / $aa->sum('quantity')), 2);
                    $st_consumption_a += $temp['consumption_q'] * ($aa->sum('amount') / $aa->sum('quantity'));
                } else {
                    $temp['consumption_a'] = 0;
                }

                //Ideal
                $a = clone $incoming_and_past;
                $b = clone $outgoing;
                $temp['ideal_q'] = $a->sum('quantity') - $b->sum('quantity'); //total from last month and this month - outgoing this month
                $aa = clone $incoming;
                if ($aa->sum('amount') > 0) {
                    $temp['ideal_a'] = number_format($temp['ideal_q'] * ($aa->sum('amount') / $aa->sum('quantity')), 2);
                    $st_ideal_a += $temp['ideal_q'] * ($aa->sum('amount') / $aa->sum('quantity'));
                } else {
                    $temp['ideal_a'] = 0;
                }

                //Variance
                $temp['variance_q'] = $temp['ending_q'] - $temp['ideal_q'];
                $aa = clone $incoming;
                if ($temp['variance_q'] > 0) {
                    $temp['variance_a'] = number_format($temp['ending_q'] - ($temp['ending_q'] * ($aa->sum('amount') / $aa->sum('quantity'))), 2);
                    $st_variance_a += $temp['ending_q'] - ($temp['ending_q'] * ($aa->sum('amount') / $aa->sum('quantity')));
                } else {
                    $temp['variance_a'] = 0;
                }
                array_push($group, $temp);
            }

            $ar = [
                'row' => '',
                'category' => '',
                'supply_name' => ($t->type == 'excel' ? 'GRAND TOTAL' : '<b>GRAND TOTAL</b>'),
                'unit' => '',
                'net_price' => '',
                'lead_time' => '',
                'minimum_order_quantity' => '',
                'order_frequency' => '',

                'beginning_q' => '',
                'beginning_a' => number_format($st_beginning_a, 2),
                'incoming_q' => '',
                'incoming_a' => number_format($st_incoming_a, 2),
                'total_q' => '',
                'total_a' => number_format($st_total_a, 2),
                'outgoing_q' => '',
                'outgoing_a' => number_format($st_outgoing_a, 2),
                'onhand_q' => '',
                'onhand_a' => number_format($st_onhand_a, 2),
                'average_q' => '',
                'average_a' => number_format($st_average_a, 2),
                'orderpoint' => '',
                'ordr' => '',
                'triggerpoint' => '',
                'ending_q' => '',
                'ending_a' => number_format($st_ending_a, 2),
                'consumption_q' => '',
                'consumption_a' => number_format($st_consumption_a, 2),
                'ideal_q' => '',
                'ideal_a' => number_format($st_ideal_a, 2),
                'variance_q' => '',
                'variance_a' => number_format($st_variance_a, 2),
            ];

            $group = collect($group)->sortByDesc('triggerpoint')->ToArray();
            array_push($group, $ar);
            array_push($return, $group);

        }

        switch ($t->type) {
            case 'pdf':
                if (count($return) > 0) {
                    $content['data'] = $return;
                    $content['process_by'] = auth()->user()->name;
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.maininventory', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                $columns = [
                    'CATEGORY', 'SUPPLY NAME', 'UNIT', 'NET PRICE', 'BEGINNING INVENTORY', '',
                    'INCOMING SUPPLIES', '', 'TOTAL STOCKS', '', 'OUTGOING SUPPLIES', '',
                    'STOCKS ON HAND', '', 'AVERAGE DAILY USAGE', '', 'LEAD TIME', 'ORDER POINT',
                    'MINIMUM ORDER QTY', 'ORDER QTY', 'TRIGGER POINT', 'ENDING INVENTORY', '',
                    'CONSUMPTION', '', 'IDEAL INVENTORY', '', 'VARIANCE', '',
                ];

                $dataitems = [[
                    "", "", "", "", "QTY", "VALUE", "QTY", "VALUE", "QTY", "VALUE", "QTY", "VALUE",
                    "QTY", "VALUE", "QTY", "VALUE", "", "", "", "", "", "QTY", "VALUE", "QTY", "VALUE",
                    "QTY", "VALUE", "QTY", "VALUE",
                ]];

                foreach ($return as $key1 => $value1) {
                    foreach ($value1 as $key => $value) {
                        $temp = [];
                        $temp['category'] = $value['category'];
                        $temp['supply_name'] = $value['supply_name'];
                        $temp['unit'] = $value['unit'];
                        $temp['net_price'] = $value['net_price'] ?? 0;
                        $temp['beginning_q'] = $value['beginning_q'] ?? 0;
                        $temp['beginning_a'] = $value['beginning_a'] ?? 0;
                        $temp['incoming_q'] = $value['incoming_q'] ?? 0;
                        $temp['incoming_a'] = $value['incoming_a'] ?? 0;
                        $temp['total_q'] = $value['total_q'] ?? 0;
                        $temp['total_a'] = $value['total_a'] ?? 0;
                        $temp['outgoing_q'] = $value['outgoing_q'] ?? 0;
                        $temp['outgoing_a'] = $value['outgoing_a'] ?? 0;
                        $temp['onhand_q'] = $value['onhand_q'] ?? 0;
                        $temp['onhand_a'] = $value['onhand_a'] ?? 0;
                        $temp['average_q'] = $value['average_q'] ?? 0;
                        $temp['average_a'] = $value['average_a'] ?? 0;
                        $temp['lead_time'] = $value['lead_time'] ?? 0;
                        $temp['orderpoint'] = $value['orderpoint'] ?? 0;
                        $temp['minimum_order_quantity'] = $value['minimum_order_quantity'] ?? 0;
                        $temp['ordr'] = $value['ordr'] ?? 0;
                        $temp['triggerpoint'] = $value['triggerpoint'] ?? 0;
                        $temp['ending_q'] = $value['ending_q'] ?? 0;
                        $temp['ending_a'] = $value['ending_a'] ?? 0;
                        $temp['consumption_q'] = $value['consumption_q'] ?? 0;
                        $temp['consumption_a'] = $value['consumption_a'] ?? 0;
                        $temp['ideal_q'] = $value['ideal_q'] ?? 0;
                        $temp['ideal_a'] = $value['ideal_a'] ?? 0;
                        $temp['variance_q'] = $value['variance_q'] ?? 0;
                        $temp['variance_a'] = $value['variance_a'] ?? 0;
                        array_push($dataitems, $temp);
                    }
                }
                return Excel::download(new InventoryExport2($dataitems, $columns), "Main Inventory Report.xlsx");
                break;
            default:
                break;
        }
    }

    //For inventory summary report
    public function InventorySummaryReport(Request $t)
    {
        //Previous month
        $date11 = date("Y-m-d 00:00:00", strtotime("-1 month", strtotime($t->year . "-" . $t->month . "-01")));
        $date22 = date("Y-m-t 23:59:59", strtotime("-1 month", strtotime($t->year . "-" . $t->month . "-" . date("t"))));
        //Current month
        $date1 = date("Y-m-d 00:00:00", strtotime($t->year . "-" . $t->month . "-01"));
        $date2 = date("Y-m-t 23:59:59", strtotime($t->year . '-' . $t->month . '-' . date("t")));

        $data = [];

        foreach (tbl_suppcat::all() as $key => $value) {
            $temp = [];
            $temp['category'] = $value->supply_cat_name;

            $temp['beginning'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11, $date22])->get()->sum("amount");
            //Get incoming based on from, to, and category, then sum amounts
            $temp['incoming'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("amount");
            //Beginning + incoming
            $temp['total'] = tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11, $date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("amount");
            //Get outgoing based on from, to, and category, then sum outgoing_amount based on masterlist supplies net price
            $temp['outgoing'] = tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("amount");
            //Stocks = total - outgoing
            $temp['stocks'] = (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11, $date22])->get()->sum("amount") + tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("amount")) - tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("amount");
            try {
                $temp['ending'] =
                    (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date11, $date2])->get()->sum("quantity") - tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("quantity")) *
                    (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("quantity"));
            } catch (\Throwable $th) {
                $temp['ending'] = 0;
            }

            try {
                $temp['variance'] = $temp['ending'] - (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("quantity") - tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date22])->get()->sum("quantity")) *
                    (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("quantity"))(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date22])->get()->sum("amount")
                     - tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['variance'] = 0;
            }

            try {
                $temp['fluctuation'] = $temp['ending'] - (tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("quantity") - tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date22])->get()->sum("quantity")) *
                    (tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("amount") / tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date2])->get()->sum("quantity"))(tbl_incomingsupp::where("category", $value->id)->whereBetween("incoming_date", [$date1, $date22])->get()->sum("amount")
                     - tbl_outgoingsupp::where("category", $value->id)->whereBetween("outgoing_date", [$date1, $date2])->get()->sum("amount"));
            } catch (\Throwable $th) {
                $temp['fluctuation'] = 0;
            }
            array_push($data, $temp);
        }

        $temp = [];
        foreach ($data as $key => $value) {

            foreach ($value as $key1 => $value1) {
                if ($key1 != 'category') {
                    $temp[$key1] = ($temp[$key1] ?? 0) + $value[$key1];
                } else {
                    if ($t->type == 'excel') {
                        $temp[$key1] = 'GRAND TOTAL';
                    } else {
                        $temp[$key1] = '<b>GRAND TOTAL</b>';
                    }
                }
            }
        }
        array_push($data, $temp);
        $content = [];

        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    $content['process_by'] = auth()->user()->name;
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.inventorysummary', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = [
                    'SUPPLIES CATEGORY', 'BEGINNING INVENTORY', 'PURCHASES', 'TOTAL STOCKS',
                    'OUTGOING SUPPLIES', 'STOCKS ON HAND', 'ENDING INVENTORY', 'VARIANCE',
                    'FLUCTUATION',
                ];
                return Excel::download(new InventoryExport($data, $columns), "Inventory Summary Report.xlsx");
                break;
            default:
                break;
        }
    }

    //For sales report
    public function SalesReport(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));

        $data = tbl_pos::where("branch", $t->branch)
            ->whereBetween("created_at", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
            ->selectRaw(" sum(quantity) as quantity, sum(sub_total_discounted) as sub_total_discounted, branch ,created_at, reference_no  ")
            ->groupby(["branch", "created_at", "reference_no"])
            ->get();

        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    $content['process_by'] = auth()->user()->name;
                    $content['param'] = ['from' => $t->from, 'to' => $t->to, 'branch' => tbl_branches::where("id", $t->branch)->first()->branch_name];
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.sales', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = ['BRANCH', 'DATE', 'REFERENCE NO', 'SALES AMOUNT'];
                //Data
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
            default:
                break;
        }
    }

    //For transaction report
    public function TransactionReport(Request $t)
    {
        $data = tbl_pos::whereBetween("created_at", [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
            ->selectRaw(" sum(quantity) as quantity,
        sum(sub_total_discounted) as sub_total_discounted,
        branch
        ,created_at,
        reference_no")->groupby(["branch", "created_at", "reference_no"])
            ->get();

        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    $content['process_by'] = auth()->user()->name;
                    $content['param'] = ['from' => $t->from, 'to' => $t->to, 'branch' => tbl_branches::where("id", $t->branch)->first()->branch_name];
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.transaction', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = ['BRANCH', 'DATE ', 'REFERENCE NO', 'TOTAL PRODUCT(S)', 'TOTAL AMT'];
                //Data
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
            default:
                break;
        }
    }

    //For purchase order report
    public function PurchaseOrderReport(Request $t)
    {
        //Filter if all or specific
        $where = ($t->supplier == 'All' ? "   supplier_name != -1 " : ' supplier_name =' . $t->supplier);
        $data = []; //Main array
        //Get all the supplier then loop
        $g_total_a = 0;

        foreach (tbl_purchaseord::whereRaw($where)
            ->whereBetween('incoming_date', [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
            ->groupBy('supplier_name')->pluck('supplier_name') as $key => $value) {
            $group = [];
            $total_a = 0;
            //Each supplier add to inner array
            foreach (tbl_purchaseord::with("supplier_name")->where("supplier_name", $value)
                ->whereBetween('incoming_date', [date("Y-m-d 00:00:00", strtotime($t->from)), date("Y-m-d 23:59:59", strtotime($t->to))])
                ->get() as $key1 => $value1) {

                $total_a += $value1->amount;

                $ar = [
                    'supplier_name' => $value1->supplier_name_details['supplier_name'],
                    'description' => $value1->supplier_name_details['description'],
                    'invoice_number' => $value1->invoice_number,
                    'amount' => $value1->amount,
                    'incoming_date' => $value1->incoming_date,
                ];
                array_push($group, $ar);
            }

            //Add inner to main array (Nested array)
            $ar = [
                'supplier_name' => '',
                'description' => '',
                'invoice_number' => ($t->type == 'excel' ? 'TOTAL' : '<b>TOTAL</b>'),
                'amount' => $total_a,
                'incoming_date' => '',
            ];
            array_push($group, $ar);
            array_push($data, $group);
        }

        $content = [];
        switch ($t->type) {
            case 'pdf':
                if (count($data) > 0) {
                    $content['data'] = $data;
                    $content['amount'] = $g_total_a;
                    $content['process_by'] = auth()->user()->name;
                    $content['param'] = ['from' => $t->from, 'to' => $t->to];
                    if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
                        $content['img'] = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
                    } else {
                        $content['img'] = null;
                    }
                    $pdf = PDF::loadView('reports.purchaseorder', $content, [], [
                        'format' => 'A4-L',
                    ]);
                    return $pdf->stream();
                } else {
                    return false;
                }
                break;
            case 'excel':
                //Columns
                $columns = ['SUPPLIER NAME', 'INVOICE NUMBER', 'AMT', 'DATE'];
                //Data
                $dataitems = [];

                foreach ($data as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $temp = [];
                        $temp['supplier_name'] = $value1['supplier_name'] ? $value1['supplier_name'] . " " . '(' . $value1['description'] . ')' : null;
                        $temp['invoice_number'] = $value1['invoice_number'];
                        $temp['amount'] = $value1['amount'];
                        $temp['incoming_date'] = ($value1['incoming_date'] ? date("Y-m-d", strtotime($value1['incoming_date'])) : null);
                        array_push($dataitems, $temp);
                    }
                }
                return Excel::download(new InventoryExport($dataitems, $columns), "Purchase Order Report.xlsx");
                break;
            default:
                break;
        }
    }

    //For retrieving sales list
    public function ListSP(Request $t)
    {
        if (auth()->user()->can('Access POS')) {
            $table = tbl_pos::with(["branch"])
                ->where('branch', auth()->user()->branch)
                ->where('cashier', auth()->user()->id)
                ->whereBetween('created_at', [date("Y-m-d", strtotime(date('Y') . '-' . date('m') . '-01')), date('Y-m-t', strtotime(date("Y") . '-' . date('m') . '-' . date('t')))])
                ->selectRaw(" sum(quantity) as quantity, sum(sub_total_discounted) as sub_total_discounted, branch ,created_at, reference_no  ")
                ->orderBy('created_at', "desc")
                ->groupby(["branch", "created_at", "reference_no"]);
        } else {
            $table = tbl_pos::with(["branch"])
                ->selectRaw(" sum(quantity) as quantity, sum(sub_total_discounted) as sub_total_discounted, branch ,created_at, reference_no  ")
                ->groupby(["branch", "created_at", "reference_no"]);
        }

        if ($t->branch) {
            $table->where("branch", $t->branch);
        }

        if ($t->search) {
            $table->where("reference_no", "like", "%" . $t->search . "%");
        }
        if ($t->dateFromSP && $t->dateUntilSP) {
            $table->whereBetween("created_at", [date("Y-m-d 00:00:00", strtotime($t->dateFromSP)), date("Y-m-d 23:59:59", strtotime($t->dateUntilSP))]);
        }

        $return = [];
        $row = 1;
        foreach ($table->get() as $key => $value) {
            $temp = [];
            $temp['row'] = $row++;
            $temp['quantity'] = $value->quantity;
            $temp['sub_total_discounted'] = number_format($value->sub_total_discounted, 2, ".", ",");
            $temp['branch'] = $value->branch;
            $temp['branch_name'] = tbl_branches::where("id", $value->branch)->first()->branch_name;
            $temp['created_at'] = date("Y-m-d", strtotime($value->created_at));
            $temp['reference_no'] = $value->reference_no;
            array_push($return, $temp);
        }
        $items = Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page);
    }

    //For retrieving sales info
    public function getSPInfo(Request $t)
    {
        return tbl_pos::with(["branch", 'product_name', 'cashier'])->where("reference_no", $t->reference_no)->get();
    }

    //For generating receipt
    public function Receipt(Request $t)
    {
        if ($t->reference_no) {
            $data = tbl_pos::where("reference_no", $t->reference_no)->get();

            $temp = [];
            $temp['data'] = $data;
            $temp['branch'] = $data[0]->branch_name_details->branch_name;
            $temp['branch_location'] = $data[0]->branch_name_details->location;
            $temp['branch_number'] = $data[0]->branch_name_details->phone_number;
            $temp['reference_no'] = $data[0]->reference_no;
            $temp['created_at'] = $data[0]->created_at;
            $temp['mode'] = $data[0]->mode;
            $temp['change'] = $data[0]->change;
            $temp['discount'] = $data[0]->discount;
            $temp['payment'] = $data[0]->payment;

            $data_cloned = clone $data;
            $temp['sub_total'] = $data_cloned->sum('sub_total');
            $data_cloned = clone $data;
            $temp['sub_total_discounted'] = $data_cloned->sum('sub_total_discounted');
            $temp['cashier_name_details'] = User::where("id", $data[0]->cashier)->first()->name;
            $temp['vatable_sales'] = $data_cloned->sum('sub_total') / tbl_vat::where("type", "p")->first()->vat;
            $temp['vat_amount'] = $data_cloned->sum('sub_total') - ($data_cloned->sum('sub_total') / tbl_vat::where("type", "p")->first()->vat);

            $data_cloned = clone $data;
            $pdf = PDF::loadView(
                'receipt.receipt',
                $temp,
                [],
                [
                    'format' => ['57', 95 + (10 * $data_cloned->count())],
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
