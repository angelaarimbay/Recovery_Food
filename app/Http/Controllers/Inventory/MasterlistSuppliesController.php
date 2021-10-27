<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_suppcat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterlistSuppliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = tbl_masterlistsupp::where("status", "!=", null);
        
      
        $table_clone = clone $table;
        if ($table_clone->where("id",$data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["status"=>$data->status,
                 "category"=>$data->category,
                 "supplier"=>$data->supplier,
                 "supply_name"=>$data->supply_name,
                 "description"=>$data->description,
                 "unit"=>$data->unit,
                 "net_price"=>$data->net_price,
                 "vat"=>$data->vat,
                 "vatable"=>$data->vatable,
                 "exp_date"=>$data->exp_date,
                 "lead_time"=>$data->lead_time,
                 "order_frequency"=>$data->order_frequency,
                 "maximum_order_quantity"=>$data->maximum_order_quantity,
                ]
            );

             
        } else {
            $supply='';
            if(is_array($data->supply_name)){
                 $supply = $data->supply_name['supply_name'];
            }else{
                $supply = $data->supply_name;
            }
  
            // return  $data->except('supply_name') ;
            tbl_masterlistsupp::create(
                $data->except('supply_name') + 
                [ 
                 'supply_name'=>$supply] //purpose is when same item sum quantity
            );
        }
        return 0;
    }
    public function suppName(Request $t)
    { 
        return tbl_masterlistsupp::where("supplier", $t->supplier)->where("status", 1)->get();
    }

    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0").
                 ($t->search?" and supply_name like '%".$t->search."%'":'');
        
        // return $where; 
         $table = tbl_masterlistsupp::with("category",'supplier')
        ->whereRaw($where)
        ->selectRaw("*, @row:=@row+1 as row ")
        ->get();

        $return = [];
        foreach ($table as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id; 
            $temp['status'] = $value->status;  
            $temp['supplier'] = $value->supplier_name_details;  
            $temp['category'] = $value->category_details;  
            $temp['unit'] = $value->unit;  
            $temp['vat'] = $value->vat;  
            $temp['vatable'] = $value->vatable;   
            $temp['supply_name'] = $value->supply_name;  
            $temp['supply_description'] = $value->supply_description;  
            $temp['format_net_price'] = $value->format_net_price;  
            $temp['net_price'] = $value->net_price;    
            $temp['lead_time'] = $value->lead_time;  
            $temp['order_frequency'] = $value->order_frequency;  
            $temp['maximum_order_quantity'] = $value->maximum_order_quantity;   

            $temp['without_vat_price'] = number_format($value->without_vat_price,2);   
            $temp['with_vat_price'] = number_format($value->with_vat_price,2);   
            array_push($return,$temp);
        }   

        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
    public function validateItem(Request $t)
    {
        try {
            return tbl_masterlistsupp::where("supply_name", $t->name)->get();
        } catch (\Throwable $th) {
            return false;
        }
       
    }
    public function sum(Request $t)
    {
        //  ->where("date", date("Y-m-d", strtotime($t->date) ) )
        return tbl_masterlistsupp::where("id", $t->id)->sum("net_price");
    }

}
