<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_branches;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
{
    public function save(Request $data)
    {
        $table = tbl_branches::where("status", "!=", null);

        // Check if branch name exists
        $table_clone = clone $table;   // Get all items from branches
        if ($table_clone
        ->where("branch_name", $data->branch_name) // Filter using name
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
                 "branch_name"=>$data->branch_name,
                 "location"=>$data->location,
                 "phone_number"=>$data->phone_number,
                 "email_add"=>$data->email_add,
                 "branch_image"=>$data->branch_image,
                ]
            );
        } else {
            tbl_branches::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_branches::where("status", "!=", null);
            $table_clone = clone $table;   // Get all items from branches
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("branch_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_branches::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
    public function attachment(Request $u)
    {
        $img = $u->file("file"); // File (depending on the parameter)

        // Unique file name
        $newfilename  = $img->getClientOriginalName() . "-" . time() . "." . $img->getClientOriginalExtension();
        
        // Path of file for saving or storing
        $img->storeAs("public/branches", $newfilename);
        return ["fakename" => $img->getClientOriginalName(), "filename" => $newfilename];
    }
}
