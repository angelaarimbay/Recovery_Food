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


use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;

//ung iba lagay mo lahatin mo na

class ReportsController extends Controller
{
    //report for
    public function ExportMasterlist(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category", $t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.masterlist', $content, [], [
                'format' => 'A4-L'
              ]);
            return $pdf->stream();
        break;
        case 'excel':
            //columns
            $columns = ['ID1','Supply name1','Category1'];
            //data
            $dataitems = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['ID'] = $value->row;
                $temp['supply_name'] = $value->supply_name;
                $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;

                array_push($dataitems, $temp);
            }
            return Excel::download(new InventoryExport($dataitems, $columns), "your report name.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }

    public function ExportPO(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
  
        //para malaman mo kung may laman need mo return to, pero pag eexport mo na sa pdf aalisin mo ung return
        $data = tbl_purchaseord::with('supplier_name_details')->whereBetween('incoming_date', [$t->from, $t->to])
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
            $columns = ['#','SUPPLIER NAME','INVOICE NUMBER','AMOUNT','DATE']; // Excel Headers

            // Data
            $dataitems = [];
            foreach ($data as $key => $value) { // From Data
                $temp = [];
                $temp['ID'] = $value->row;
                $temp['supply_name'] = $value->supply_name;
                $temp['supplier_name'] = tbl_purchaseord::where("id", $value->supplier_name)->first()->supplier_name;
                $temp['invoice_number'] = $value->invoice_number;
                $temp['format_amount'] = $value->format_amount;
                $temp['incoming_date'] = $value->incoming_date;

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

    public function ExportTP(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        //para malaman mo kung may laman need mo return to, pero pag eexport mo na sa pdf aalisin mo ung return
        $data = tbl_pos::whereBetween('created_at', [$t->from, $t->to])
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.transactionreport', $content, [], [
                'format' => 'A4-L' // A4 paper daw ung default nyo, so A4 yan then -L meaning Landscape
              ]);
            return $pdf->stream();
        break;
        case 'excel':  //ikaw na mag set dito ng mga columns na need. excel to. ok p
            //columns
            $columns = ['ID1','Supply name1','Category1']; //lalagay mo lang header ng excel mo
            //data
                $dataitems = [];
             foreach ($data as $key => $value) { //ito nmn syempre ung galing sa data
                 $temp = [];
                 $temp['ID'] = $value->row;
                 $temp['supply_name'] = $value->supply_name;
                 $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                 //   kaw na mag tuloy. oo
                 array_push($dataitems, $temp);
             }
            return   Excel::download(new InventoryExport($dataitems, $columns), "your report name.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }



    public function ListSP(Request $t){
      

        DB::statement(DB::raw("set @row:=0"));
        $table = tbl_pos::with(["branch",'product_name'])
                        ->selectRaw("*, @row:=@row+1 as row ");


        if($t->branch){
           $table->where("branch",$t->branch);
        }
        if($t->category){
            $table->where("branch",$t->category);
         }
         if($t->search){
            $table->whereHas('supply_name', function ($q) use ($t) {
                $q->where('supply_name', 'like', "%".$t->search."%");
            });
         }


        return  $table->paginate($t->itemsPerPage, "*", "page", $t->page);

    }




    //sales report,
    public function ExportSP(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        //para malaman mo kung may laman need mo return to, pero pag eexport mo na sa pdf aalisin mo ung return
      

        DB::statement(DB::raw("set @row:=0"));
        $data = tbl_pos::with(["branch",'product_name'])
                        ->selectRaw("*, @row:=@row+1 as row ");


        if($t->branch){
           $data->where("branch",$t->branch);
        }
        if($t->category){
            $data->where("branch",$t->category);
         }
         if($t->search){
            $data->whereHas('supply_name', function ($q) use ($t) {
                $q->where('supply_name', 'like', "%".$t->search."%");
            });
         }

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data;
            $pdf = PDF::loadView('reports.transactionreport', $content, [], [
                'format' => 'A4-L' // A4 paper daw ung default nyo, so A4 yan then -L meaning Landscape
              ]);
            return $pdf->stream();
        break;
        case 'excel':  //ikaw na mag set dito ng mga columns na need. excel to. ok p
            //columns
            $columns = ['ID1','Supply name1','Category1']; //lalagay mo lang header ng excel mo
            //data
                $dataitems = [];
             foreach ($data as $key => $value) { //ito nmn syempre ung galing sa data
                 $temp = [];
                 $temp['ID'] = $value->row;
                 $temp['supply_name'] = $value->supply_name;
                 $temp['category'] = tbl_suppcat::where("id", $value->category)->first()->supply_cat_name;
                 //   kaw na mag tuloy. oo
                 array_push($dataitems, $temp);
             }
            return   Excel::download(new InventoryExport($dataitems, $columns), "your report name.xlsx");
        break;
        case 'print':

        break;
        default:
        # code...
        break;
        }
    }
}
