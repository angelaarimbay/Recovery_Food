<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_outgoingsupp;  
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;

//ung iba lagay mo lahatin mo na

class ReportsController extends Controller
{ 
    /** for masterlist
     * 09-26-21 - done
     * 
     */
    public function ExportMasterlist(Request $t)
    { 
        DB::statement(DB::raw("set @row:=0")); 
            $data = tbl_masterlistsupp::with("category" )
                                    ->where("category",$t->category)
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }
    /** for incoming
     * 09-26-21 - done
     * 
     */
    public function ExportIncominglist(Request $t)
    {
          DB::statement(DB::raw("set @row:=0")); 
          $data = tbl_incomingsupp::where("category",$t->category)
                                    ->whereBetween("incoming_date",[$t->from, $t->to])
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.Incoming_supplies', $content, [], [
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }
    /** for out
     * 09-26-21 - done
     * 
     */
    public function ExportOutgoinglist(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
            $data = tbl_outgoingsupp::with(["category",'requesting_branch'])
                                    ->where("requesting_branch",$t->branch)
                                    ->whereBetween("outgoing_date",[$t->from, $t->to]) 
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.Outgoing_supplies', $content, [], [
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }

    /** for Main
     * 09-26-21 - done
     * 
     */
    public function ExportMain(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
          $data = tbl_incomingsupp::with(["category",'supply_name'])
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.Main_inventory', $content, [], [
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }


    public function ExportInventorysummary(Request $t)
    {
         // 1st Get all the category
         $data_temp = tbl_suppcat::all();
         // Set array for temporary table
         $data = [];
         foreach ($data_temp as $key => $value) {
             $temp = [];
             // Get incoming based on from, to and per category, then sum amounts
  
             $temp['category'] = $value->supply_cat_name;
             $temp['incoming'] =  number_format(tbl_incomingsupp::where("category", $value->id)->get()->sum("amount"), 2, ".", ",");
              
             // Get outgoing based on from, to and per category, then sum outgoing_amount based on masterlist net
             $temp['outgoing'] =  number_format(tbl_outgoingsupp::where("category", $value->id)->get()->sum("outgoing_amount"), 2, ".", ",");
            
             $temp['stocks'] = number_format(tbl_incomingsupp::where("category", $value->id)->get()->sum("amount")
                                   - tbl_outgoingsupp::where("category", $value->id)->get()->sum("outgoing_amount"), 2, ".", ",");
             array_push($data, $temp);
         }
   

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.Inventory_summary', $content, [], [
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }

    public function ExportSales(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }

    public function ExportTransaction(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }
    
    public function ExportPurchase(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
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
                    $temp['category'] = tbl_suppcat::where("id",$value->category)->first()->supply_cat_name;
                //   kaw na mag tuloy. oo
                    array_push($dataitems,$temp);
             }    
            return   Excel::download(new InventoryExport($dataitems,$columns), "your report name.xlsx");
        break;
        case 'print': 

        break;
        default:
        # code...
        break;
        }
                       
      
    }
}
