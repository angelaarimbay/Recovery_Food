<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingprod;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_masterlistprod;
use Illuminate\Support\Facades\DB;

class IncomingProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $data)
    {
        $table = tbl_incomingprod::where("product_name", "!=", null);

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["category"=>$data->category,
                "sub_category"=>$data->sub_category,
                "product_name"=>$data->product_name,
                "quantity"=>$data->quantity,
                "amount"=>$data->amount,
                "incoming_date"=>$data->incoming_date,
                ]
            );
        } else {
            tbl_incomingprod::create($data->all());
        }
        return 0;
    }
    
    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0");
        DB::statement(DB::raw("set @row:=0")); 
        $table = tbl_incomingprod::with(["category","sub_category","product_name"])->selectRaw("*, @row:=@row+1 as row ")->whereRaw($where);
      
        if ($t->search) { // If has value
            $table_clone = clone $table;   // Get all items from incomingsupp  
            if($t->dateFrom && $t->dateUntil){
                $table_clone->whereBetween("incoming_date",[date("Y-m-d",strtotime($t->dateFrom)), date("Y-m-d",strtotime($t->dateUntil))]);
            } 
            return $table_clone->whereHas('product_name', function ($q) use ($t) {
                $q->where('product_name', 'like', "%".$t->search."%");
            }) ->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else 
        if($t->dateFrom && $t->dateUntil){
            $table->whereBetween("incoming_date",[date("Y-m-d",strtotime($t->dateFrom)), date("Y-m-d",strtotime($t->dateUntil))]);
        } 
        return  $table->paginate($t->itemsPerPage, "*", "page", $t->page);
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
}
