<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingprod;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_masterlistprod;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
 

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
                "product_name"=>$data->product_name['id'],
                "quantity"=>$data->quantity,
                "amount"=> tbl_masterlistprod::where("id",$data->product_name['id'] )->first()->price * $data->quantity,
                "incoming_date"=>$data->incoming_date,
                ]
            );
        } else {
            tbl_incomingprod::create($data->except('product_name') + ['product_name'=>$data->product_name['id'], 'amount'=>tbl_masterlistprod::where("id",$data->product_name['id'] )->first()->price * $data->quantity]);
        }
        return 0;
    }
    
    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0");
     
        $table = tbl_incomingprod::with(["category","sub_category","product_name"])->whereRaw($where);
      
        if($t->dateFrom && $t->dateUntil){
          $table =  $table->whereBetween("incoming_date", [date("Y-m-d H:i:s", strtotime($t->dateFrom . ' 00:00:01')), date("Y-m-d H:i:s", strtotime($t->dateUntil . ' 11:59:59'))]);
        } 

        if ($t->search) { // If has value 
            $table = $table->whereHas('product_name', function ($q) use ($t) {
                $q->where('product_name', 'like', "%".$t->search."%");
            }) ->paginate($t->itemsPerPage, "*", "page", 1);
        }



        $return = [];
        foreach ($table->get() as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id; 
            $temp['amount'] = number_format($value->amount,2);   
            $temp['incoming_date'] = $value->incoming_date;  
            $temp['product_name'] = $value->product_name_details;  
            $temp['price'] = number_format($value->product_name_details['price'],2);   
            $temp['quantity'] = $value->quantity; 
            $temp['category'] = $value->category_details;   
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
        return tbl_masterlistprod::  where("category", $t->category)
        ->where("sub_category", $t->sub_category)
        ->where("status", 1)->get();
    }
}
