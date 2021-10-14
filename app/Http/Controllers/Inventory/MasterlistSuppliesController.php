<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_suppcat;
use Illuminate\Support\Facades\DB;

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
                ]
            );
        } else {
            $supply='';
            if(is_array($data->supply_name)){
                 $supply = $data->supply_name['supply_name'];
            }else{
                $supply = $data->supply_name;
            }
 

            //check supply if exsiting
            $table_clone = clone $table; 
            if( $table_clone->where(['supply_name'=>$supply, 'unit'=>$data->unit, 'description'=>$data->description])->get()->count()>0){
                $table_clone = clone $table;
                //get the group 
                $group = $table_clone->where(['supply_name'=>$supply, 'unit'=>$data->unit, 'description'=>$data->description])->first()->group;
            }else{
                $table_clone = clone $table;
                //get the last row and add 1 for a new group
                try {
                     
                $group = $table_clone->orderBy('group')->first()->group + 1;
                } catch (\Throwable $th) {
                    $group =   0;
                }
         
            }            
            // return  $data->except('supply_name') ;
            tbl_masterlistsupp::create(
                $data->except('supply_name') + 
                ['group' => $group,
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
        DB::statement(DB::raw("set @row:=0"));
        return $table = tbl_masterlistsupp::with("category",'supplier')
        ->whereRaw($where)
        ->selectRaw("*, @row:=@row+1 as row ")
        ->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
    public function validateItem(Request $t)
    {
        try {
            return tbl_masterlistsupp::where("supply_name", $t->name)->get();
        } catch (Throwable $th) {
            return false;
        }
    }
    public function sum(Request $t)
    {
        //  ->where("date", date("Y-m-d", strtotime($t->date) ) )
        return tbl_masterlistsupp::where("id", $t->id)->sum("net_price");
    }
}
