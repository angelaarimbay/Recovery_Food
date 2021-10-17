<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingprod;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_masterlistprod;
use App\Models\tbl_branches;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0").
                ($t->branch? " and requesting_branch=".$t->branch:"");
  
        $table = tbl_outgoingprod::with(["category","sub_category","product_name","requesting_branch"]) 
                ->whereRaw($where)
                ->where("product_name", "!=", null);
 
        if ($t->dateFrom && $t->dateUntil) {
            $table = $table->whereBetween("outgoing_date", [date("Y-m-d", strtotime($t->dateFrom)), date("Y-m-d", strtotime($t->dateUntil))]);
        }

        if ($t->search) { // If has value
              $table =  $table->whereHas('product_name', function ($q) use ($t) {
                $q->where('product_name', 'like', "%".$t->search."%");
            }) ->paginate($t->itemsPerPage, "*", "page", 1);
        }
         
        
        $return = [];
        foreach ($table->get() as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id; 
            $temp['status'] = $value->status;  
            $temp['category'] = $value->category_details;  
            $temp['outgoing_amount'] = $value->outgoing_amount;  
            $temp['outgoing_date'] = $value->outgoing_date;  
            $temp['product_name'] = $value->product_name_details;  
            $temp['quantity'] = $value->quantity;  
            $temp['quantity_diff'] = $value->quantity_diff;  
            $temp['requesting_branch'] = $value->requesting_branch_details;  
            $temp['sub_category'] = $value->sub_category_details;  
            array_push($return,$temp);
        }   
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
  
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
