<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use Illuminate\Support\Facades\DB;

class MainInventoryController extends Controller
{
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_incomingsupp::with(["category","supply_name"])->groupby(["category","supply_name"]);
            $table_clone = clone $table;   // Get all items from incomingsupp
           
            return $table_clone->selectRaw("category,supply_name, @row:=@row+1 as row ")->where("supply_name", "like", "%".$t->search."%")->groupby(["category","supply_name"])->paginate($t->itemsPerPage, "*", "page", 1);
        }
        
        // Else
        return  tbl_incomingsupp::with(["category","supply_name"])->selectRaw("category,supply_name, @row:=@row+1 as row ")->groupby(["category","supply_name"])->paginate($t->itemsPerPage, "*", "page", $t->page);
 
      
    }
}
