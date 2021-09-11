<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_maininv;
use App\Models\tbl_suppcat;
use Illuminate\Support\Facades\DB;

class MainInventoryController extends Controller
{
    public function save(Request $data)
    {
        $table = tbl_maininv::all();
        
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ['beginning_inv_qty'=>$data->beginning_inv_qty,
                 'lead_time'=>$data->lead_time,
                 'min_order_qty'=>$data->min_order_qty,
                 'order_frequency'=>$data->order_frequency,
                 'ending_inv_qty'=>$data->ending_inv_qty,
                ]
            );
        } else {
            tbl_maininv::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw('set @row:=0'));
        if ($t->search) { // If has value
            $table = tbl_maininv::with('category');
            $table_clone = clone $table;   // Get all items from maininv
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supply_name", 'like', '%'.$t->search.'%')->paginate($t->itemsPerPage, '*', 'page', 1);
        }
        // Else
        return  tbl_maininv::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, '*', 'page', $t->page);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(['supply_cat_name','id'])->get();
    }
}
