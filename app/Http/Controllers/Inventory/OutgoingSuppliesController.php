<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_branches;
use Illuminate\Support\Facades\DB;

class OutgoingSuppliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = tbl_outgoingsupp::where("supply_name", "!=", null);

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["category"=>$data->category,
                 "supply_name"=>$data->supply_name,
                 "quantity"=>$data->quantity,
                 "requesting_branch"=>$data->requesting_branch,
                ]
            );
        } else {
            tbl_outgoingsupp::create($data->all());
        }
        return 0;
    }
    
    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0").
                ($t->branch? " and requesting_branch=".$t->branch:"");
 
        DB::statement(DB::raw("set @row:=0"));
        $table = tbl_outgoingsupp::with(["category","supply_name","requesting_branch"])
        ->selectRaw("*, @row:=@row+1 as row ")
        ->whereRaw($where)
        ->where("supply_name", "!=", null);
 
        if ($t->search) { // If has value
            $table_clone = clone $table;   // Get all items from outgoingsupp

            if ($t->dateFrom && $t->dateUntil) {
                $table_clone->whereBetween("outgoing_date", [date("Y-m-d", strtotime($t->dateFrom)), date("Y-m-d", strtotime($t->dateUntil))]);
            }
            return $table_clone->whereHas('supply_name', function ($q) use ($t) {
                $q->where('supply_name', 'like', "%".$t->search."%");
            }) ->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        if ($t->dateFrom && $t->dateUntil) {
            $table->whereBetween("outgoing_date", [date("Y-m-d", strtotime($t->dateFrom)), date("Y-m-d", strtotime($t->dateUntil))]);
        }
        return  $table->paginate($t->itemsPerPage, "*", "page", $t->page);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }

    public function suppName(Request $t)
    {
        return tbl_masterlistsupp::select(["supply_name","id"])->where("category", $t->category)->where("status", 1)->get();
    }

    public function branchName()
    {
        return tbl_branches::select(["branch_name","id"])->where("status", 1)->get();
    }
}
