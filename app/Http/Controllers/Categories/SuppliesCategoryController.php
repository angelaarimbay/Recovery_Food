<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_suppcat;
use Illuminate\Support\Facades\DB;

class SuppliesCategoryController extends Controller
{
    public function save(Request $data)
    {
        $table = tbl_suppcat::where("status", '!=', null);
     
 
        // Check if supply category name exists
        $table_clone = clone $table;   // Get all items from suppcat
        if ($table_clone
        ->where("supply_cat_name", $data->supply_cat_name) // Filter using name
        ->where("id", '!=', $data->id)  // Filter if id is not selected
        ->count()>0) {
            return 1;
        }
        // Else continue
        
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ['status'=>$data->status,
                 'supply_cat_name'=>$data->supply_cat_name
                ]
            );
        } else {
            tbl_suppcat::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    { DB::statement(DB::raw('set @row:=0'));
        if ($t->search) { // If has value
            $table = tbl_suppcat::where("status", '!=', null);
            $table_clone = clone $table;   // Get all items from suppcat
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supply_cat_name", 'like', '%'.$t->search.'%')->paginate($t->itemsPerPage, '*', 'page', 1);
        }
        // Else
        return  tbl_suppcat::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, '*', 'page', $t->page);

        // ->paginate($t->itemsPerPage, '*', 'page', $t->page); 
        // parang dito may kulang e..  paginate(item per page, 'all items', 'per [page]', pagenumber )
        // baka may need formula. between item per page vs page number
    }
}
