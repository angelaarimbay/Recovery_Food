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
        
        // Check if supply name exists
        $table_clone = clone $table;   // Get all items from masterlistsupp
        if ($table_clone
        ->where("supply_name", $data->supply_name) // Filter using name
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
            tbl_masterlistsupp::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_masterlistsupp::with("category")->where("status", "!=", null);
            $table_clone = clone $table;   // Get all items from masterlistsupp
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supply_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_masterlistsupp::with("category")->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
    public function suppCat()
    {
        // return tbl_masterlistsupp::with("category")->select("category")->get();
        // return tbl_masterlistsupp::select("category")->get();
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
