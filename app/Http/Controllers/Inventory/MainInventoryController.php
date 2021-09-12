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


        // { text: "#", value: "count", align: "start", filterable: false },
        // { text: "Category", value: "category.category", filterable: false },
        // { text: "Supply Name", value: "supply_name.supply_name" },
        // { text: "Stocks On Hand", value: "quantity_difference", align: "right" },
        // { text: "Total Amount", value: "quantity_amount", align: "right", filterable: false},

        DB::statement(DB::raw('set @row:=0'));
        if ($t->search) { // If has value
            $table = tbl_incomingsupp::with(['category','supply_name'])->groupby(['category','supply_name']);
            $table_clone = clone $table;   // Get all items from masterlistsupplies
           
            return $table_clone->selectRaw("category,supply_name, @row:=@row+1 as row ")->where("supply_name", 'like', '%'.$t->search.'%')->groupby(['category','supply_name'])->paginate($t->itemsPerPage, '*', 'page', 1);
        }
        
        // Else
        return  tbl_incomingsupp::with(['category','supply_name'])->selectRaw("category,supply_name, @row:=@row+1 as row ")->groupby(['category','supply_name'])->paginate($t->itemsPerPage, '*', 'page', $t->page);
 
      
    }
}
