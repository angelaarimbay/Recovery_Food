<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_prodsubcat;
use Illuminate\Support\Facades\DB;

class ProductsSubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = tbl_prodsubcat::where("status", "!=", null);
     
        // Check if product-sub category name exists
        $table_clone = clone $table;   // Get all items from prodsubcat
        if ($table_clone
        ->where("prod_sub_cat_name", $data->prod_sub_cat_name) // Filter using name
        ->where("id", "!=", $data->id)  // Filter if id is not selected
        ->count()>0) {
            return 1;
        }
        // Else continue
        
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["status"=>$data->status,
                 "prod_sub_cat_name"=>$data->prod_sub_cat_name
                ]
            );
        } else {
            tbl_prodsubcat::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_prodsubcat::where("status", "!=", null);
            $table_clone = clone $table;   // Get all items from prodsubcat
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("prod_sub_cat_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_prodsubcat::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
}
