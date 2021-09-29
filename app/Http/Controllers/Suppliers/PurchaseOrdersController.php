<?php

namespace App\Http\Controllers\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_purchaseord;
use App\Models\tbl_supplist;
use Illuminate\Support\Facades\DB;

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
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_purchaseord::with("supplier_name")->where("supplier_name", "!=", null);
            $table_clone = clone $table;   // Get all items from purchaseord
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supplier_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_purchaseord::with("supplier_name")->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }

    public function suppName()
    {
        return tbl_supplist::select(["supplier_name","id"])->where("status", 1)->get();
    }
}
