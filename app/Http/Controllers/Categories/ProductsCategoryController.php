<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_prodcat;

class ProductsCategoryController extends Controller
{
    public function save(Request $data)
    {
        $table = tbl_prodcat::where("status", '!=', null);
     
 
        // Check if supply category name exists
        $table_clone = clone $table;   // Get all items from suppcat
        if ($table_clone
        ->where("product_cat_name", $data->product_cat_name) // Filter using name
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
                 'product_cat_name'=>$data->product_cat_name
                ]
            );
        } else {
            tbl_prodcat::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        if ($t->search) { // If has value
            $table = tbl_prodcat::where("status", '!=', null);
            $table_clone = clone $table;   // Get all items from prodcat 
 
            return $table_clone->where("product_cat_name", 'like', '%'.$t->search.'%')->paginate($t->itemsPerPage, '*', 'page', 1);
        }
        // Else
        return  tbl_prodcat::paginate($t->itemsPerPage, '*', 'page', $t->page);
    }
}
