<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_suppcat;


class SuppliesCategoryController extends Controller
{
    // public 
    // private 

    public function save(Request $data){ 
        $table = tbl_suppcat::where("status", '!=', null);
      
        $table_clone = clone $table;  
        if($table_clone->where("supply_cat_name", $data->supply_cat_name)->count()>0){
            return 1; //kaw na bahala sa return. un ung gagamitin mo sa page mo
        }
        //else continue
        
        $table_clone = clone $table;  
        if($table_clone->where("id", $data->id)->count()>0){
            // update
            $table_clone = clone $table; 
            $table_clone->where("id",$data->id)->update(
                ['status'=>$data->status,
                 'supply_cat_name'=>$data->supply_cat_name
                ]
            );
        }else{ 
            tbl_suppcat::create($data->all());
        } 
        return 0;
               
    }
    public function get(Request $t) {
        //kunin natin pag nasave na sa database  
        return  tbl_suppcat::paginate($t->itemsPerPage, '*', 'page', $t->page);
    }
}
