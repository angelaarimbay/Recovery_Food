<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingprod;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_masterlistprod;
use App\Models\tbl_branches;
use Illuminate\Support\Facades\DB;

class OutgoingProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = tbl_outgoingprod::where("product_name", "!=", null);

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["category"=>$data->category,
                 "sub_category"=>$data->sub_category,
                 "product_name"=>$data->product_name,
                 "quantity"=>$data->quantity,
                 "requesting_branch"=>$data->requesting_branch,
                ]
            );
        } else {
            tbl_outgoingprod::create($data->all());
        }
        return 0;
    }
    
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_outgoingprod::with(["category","sub_category","product_name","requesting_branch"])->where("product_name", "!=", null);
            $table_clone = clone $table;   // Get all items from outgoingprod
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("product_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_outgoingprod::with(["category","sub_category","product_name","requesting_branch"])->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }

    public function prodCat()
    {
        return tbl_prodcat::select(["product_cat_name","id"])->where("status", 1)->get();
    }

    public function prodSubCat()
    {
        return tbl_prodsubcat::select(["prod_sub_cat_name","id"])->where("status", 1)->get();
    }

    public function prodName(Request $t)
    {
        return tbl_masterlistprod::select(["product_name","id"])->where("category", $t->category)->where("sub_category", $t->sub_category)->where("status", 1)->get();
    }

    public function branchName()
    {
        return tbl_branches::select(["branch_name","id"])->where("status", 1)->get();
    }
}
