<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_branches; 
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BranchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        $table = tbl_branches::where("status", "!=", null);
        if ($t->search) { // If has value 
             $table =  $table->where("branch_name", "like", "%".$t->search."%");
        } 
        $return = [];
        foreach ($table->get() as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id;
            $temp['branch_image'] =  ($value->branch_image?'/storage/branches/'.$value->branch_image:'/img/Logo.jpg');
            $temp['branch_name'] = $value->branch_name;
            $temp['email_add'] = $value->email_add;
            $temp['location'] = $value->location;
            $temp['phone_number'] = $value->phone_number; 
            $temp['status'] = $value->status;  
            array_push($return,$temp);
        }  
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
 
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
