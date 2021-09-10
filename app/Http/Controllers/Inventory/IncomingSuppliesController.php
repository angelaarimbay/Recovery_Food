<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use Illuminate\Support\Facades\DB;

class IncomingSuppliesController extends Controller
{
    public function save(Request $data)
    {
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ['invoice_number'=>$data->invoice_number,
                 'supplier_name'=>$data->supplier_name,
                 'supplier_description'=>$data->supplier_description,
                 'category'=>$data->category,
                 'supply_name'=>$data->supply_name,
                 'supply_description'=>$data->supply_description,
                 'unit'=>$data->unit,
                 'quantity'=>$data->quantity,
                 'amount'=>$data->amount,
                ]
            );
        } else {
            tbl_incomingsupp::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw('set @row:=0'));
        if ($t->search) { // If has value
            $table = tbl_incomingsupp::with('category')->where("status", '!=', null);
            $table_clone = clone $table;   // Get all items from incomingsupplies
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supply_name", 'like', '%'.$t->search.'%')->paginate($t->itemsPerPage, '*', 'page', 1);
        }
        // Else
        return  tbl_incomingsupp::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, '*', 'page', $t->page);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(['supply_cat_name','id'])->get();
    }
}
