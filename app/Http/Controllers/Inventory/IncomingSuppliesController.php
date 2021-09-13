<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use Illuminate\Support\Facades\DB;

class IncomingSuppliesController extends Controller
{
    public function save(Request $data)
    {
        $table = tbl_incomingsupp::where('supply_name', '!=', 0);
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ['category'=>$data->category,
                 'supply_name'=>$data->supply_name,
                 'quantity'=>$data->quantity,
                 'amount'=>$data->amount,
                 'incoming_date'=>$data->incoming_date,
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
            $table = tbl_incomingsupp::with(['category','supply_name']);
            $table_clone = clone $table;   // Get all items from incomingsupp
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supply_name", 'like', '%'.$t->search.'%')->paginate($t->itemsPerPage, '*', 'page', 1);
        }
        // Else
        return  tbl_incomingsupp::with(['category','supply_name'])->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, '*', 'page', $t->page);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(['supply_cat_name','id'])->where('status', 1)->get();
    }

    public function suppName(Request $t)
    {
        return tbl_masterlistsupp::select(['supply_name','id'])->where('category', $t->category)->where('status', 1)->get();
    }
    
}
