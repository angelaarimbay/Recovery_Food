<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_masterlistprod;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use Illuminate\Support\Facades\DB;

class MasterlistProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        //  return $data->all();

        $table = tbl_masterlistprod::where("status", "!=", null);
     
        // Check if product name exists
        $table_clone = clone $table;   // Get all items from masterlistprod
        if ($table_clone
        ->where("product_name", $data->product_name) // Filter using name
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
                 "category"=>$data->category,
                 "sub_category"=>$data->sub_category,
                 "product_name"=>$data->product_name,
                 "description"=>$data->description,
                 "price"=>$data->price,
                 "exp_date"=>$data->exp_date,
                ]
            );
        } else {
            tbl_masterlistprod::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_masterlistprod::with(["category","sub_category"])->where("status", "!=", null);
            $table_clone = clone $table;   // Get all items from masterlistprod
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("product_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_masterlistprod::with(["category","sub_category"])->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }

    public function prodCat()
    {
        return tbl_prodcat::select(["product_cat_name","id"])->where("status", 1)->get();
    }

    public function prodSubCat()
    {
        return tbl_prodsubcat::select(["prod_sub_cat_name","id"])->where("status", 1)->get();
    }
}
