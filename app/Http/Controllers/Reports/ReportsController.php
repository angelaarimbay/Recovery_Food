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
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;

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
                $temp['format_net_price'] = $value->format_net_price;
                $temp['format_with_vat'] = $value->format_with_vat;
                $temp['vat'] = $value->vat;
                $temp['format_without_vat'] = $value->format_without_vat;
                $temp['exp_date'] = date("Y-m-d", strtotime($value->exp_date));
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
                                    ->whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])
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
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','WITH VAT','QTY','AMT','DATE'];
            //data
                $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                $temp['supply_name'] = $value->supply_name_details['supply_name'] . " " . $value->supply_name_details['description'];
                $temp['unit'] = $value->supply_name_details['unit'];
                $temp['net_price'] = $value->supply_name_details['format_net_price'];
                $temp['with_vat'] = $value->supply_name_details['format_with_vat'];
                $temp['quantity'] = $value->quantity;
                $temp['total_amount'] = $value->format_amount;
                $temp['incoming_date'] = date("Y-m-d", strtotime($value->incoming_date));
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
                                    ->whereBetween("outgoing_date", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])
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
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','WITH VAT','QTY','AMT','DATE'];
            //data
            $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                $temp['supply_name'] = $value->supply_name_details['supply_name'] . " " . $value->supply_name_details['description'];
                $temp['unit'] = $value->supply_name_details['unit'];
                $temp['net_price'] = $value->supply_name_details['format_net_price'];
                $temp['with_vat'] = $value->supply_name_details['format_with_vat'];
                $temp['quantity'] = $value->quantity;
                $temp['outgoing_amount'] = $value->outgoing_amount;
                $temp['outgoing_date'] = date("Y-m-d", strtotime($value->outgoing_date));
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
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_incomingsupp::where("category", $t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.maininventory', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['CATEGORY','SUPPLY NAME','UNIT','NET PRICE','STOCKS ON HAND','TOTAL AMT'];
            //data
                $dataitems = [];
             foreach ($data as $key => $value) {
                 $temp = [];
                 $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                 $temp['supply_name'] = $value->supply_name_details['supply_name'] . " " . $value->supply_name_details['description'];
                 $temp['unit'] = $value->supply_name_details['unit'];
                 $temp['net_price'] = $value->supply_name_details['format_net_price'];
                 $temp['quantity_difference'] = $value->quantity_difference;
                 $temp['quantity_amount'] = number_format($value->quantity_amount, 2, ".", ",");
                 array_push($dataitems, $temp);
             }
            return   Excel::download(new InventoryExport($dataitems, $columns), "Main Inventory Report.xlsx");
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
        $data = [];
        foreach ($data_temp as $key => $value) {
            $temp = [];
            $temp['category'] = $value->supply_cat_name;
            $temp['incoming'] =  tbl_incomingsupp::whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])->where("category", $value->id)->get()->sum("quantity") ;
            $temp['outgoing'] = tbl_outgoingsupp::whereBetween("outgoing_date", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])->where("category", $value->id)->get()->sum("quantity") ;
            $temp['stocks'] = tbl_incomingsupp::whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])->where("category", $value->id)->get()->sum("quantity")
                                    - tbl_outgoingsupp::whereBetween("outgoing_date", [date("Y-m-d H:i:s", strtotime($t->from . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->to . ' 11:59:59'))])->where("category", $value->id)->get()->sum("quantity");
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
        $data = tbl_pos::whereBetween('created_at', [$t->from, $t->to])
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
            ->orderBy('created_at',"desc") ->groupby(["branch","created_at","reference_no"])
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
            $table->whereBetween("created_at", [$t->dateFromSP, $t->dateUntilSP]);
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
            $temp['mode'] = $data[0]->mode;
            $temp['change'] = $data[0]->change;
            $temp['discount'] = $data[0]->discount;
            $temp['payment'] = $data[0]->payment;


            $data_cloned = clone $data;
            $temp['sub_total'] = $data_cloned->sum('sub_total');
            $data_cloned = clone $data;
            $temp['sub_total_discounted'] =$data_cloned->sum('sub_total_discounted');
            $temp['cashier_name_details'] = User::where("id", $data[0]->cashier)->first()->name;
            
             
            $data_cloned = clone $data;
            $pdf = PDF::loadView(
                'receipt.receipt',
                $temp,
                [],
                ['format' => ['57',76 + (7 * $data_cloned->count())],
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
