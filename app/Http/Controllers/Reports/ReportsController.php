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
    //report for 
    public function ExportMasterlist(Request $t)
    { 
        DB::statement(DB::raw("set @row:=0")); 
            $data = tbl_masterlistsupp::with("category" )
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();
        
        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.masterlist', $content );
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



    public function ExportIncominglist(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
      return    $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.masterlist', $content, [], [
                'format' => 'A5-L'
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

    public function ExportOutgoinglist(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.masterlist', $content, [], [
                'format' => 'A5-L'
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
    public function ExportMain(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.masterlist', $content, [], [
                'format' => 'A5-L'
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
        DB::statement(DB::raw("set @row:=0")); 
        $data = tbl_masterlistsupp::with("category")
                                    ->where("category",$t->category)
                                    ->selectRaw("*, @row:=@row+1 as row ")->get();

        switch ($t->type) {
        case 'pdf':
            $content['data'] = $data; 
            $pdf = PDF::loadView('reports.masterlist', $content, [], [
                'format' => 'A5-L'
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
                'format' => 'A5-L'
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
                'format' => 'A5-L'
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
                'format' => 'A5-L'
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
