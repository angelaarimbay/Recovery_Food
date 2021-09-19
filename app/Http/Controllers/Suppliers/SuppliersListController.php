<?php

namespace App\Http\Controllers\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_supplist;
use Illuminate\Support\Facades\DB;

class SuppliersListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = tbl_supplist::where("status", "!=", null);
     
        // Check if supplier name exists
        $table_clone = clone $table;   // Get all items from supplist
        if ($table_clone
        ->where("supplier_name", $data->supplier_name) // Filter using name
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
                 "supplier_name"=>$data->supplier_name,
                 "description"=>$data->description,
                 "phone_number"=>$data->phone_number,
                 "contact_person"=>$data->contact_person,
                 "address"=>$data->address,
                ]
            );
        } else {
            tbl_supplist::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_supplist::where("status", "!=", null);
            $table_clone = clone $table;   // Get all items from supplist
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("supplier_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_supplist::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
}
