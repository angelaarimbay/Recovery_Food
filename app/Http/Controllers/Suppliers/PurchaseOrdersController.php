<?php

namespace App\Http\Controllers\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_purchaseord;
use App\Models\tbl_supplist; 
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = tbl_purchaseord::where("supplier_name", "!=", null);
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["invoice_number"=>$data->invoice_number,
                 "supplier_name"=>$data->supplier_name,
                 "amount"=>$data->amount,
                ]
            );
        } else {
            tbl_purchaseord::create($data->all());
        }
        return 0;
    }

    public function get(Request $t)
    {  $table = tbl_purchaseord::with("supplier_name")->where("supplier_name", "!=", null);


        if ($t->dateFrom && $t->dateUntil) {
            $table = $table->whereBetween("incoming_date", [date("Y-m-d", strtotime($t->dateFrom)), date("Y-m-d", strtotime($t->dateUntil))]);
        }

        if ($t->search) { // If has value 
            $table= $table->selectRaw("*, @row:=@row+1 as row ")->whereHas('supplier_name', function ($q) use ($t) {
                $q->where('supplier_name', 'like', "%".$t->search."%");
            }) ;
        }
         
        $return = [];
        foreach ($table->get() as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id; 
            $temp['amount'] = $value->amount;  
            $temp['format_amount'] = $value->format_amount;  
            $temp['incoming_date'] = $value->incoming_date;  
            $temp['invoice_number'] = $value->invoice_number;  
            $temp['supplier_name'] = $value->supplier_name_details;    
            array_push($return,$temp);
        }   
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
  
    }

    public function suppName()
    {
        return tbl_supplist::select(["supplier_name","id"])->where("status", 1)->get();
    }
}
