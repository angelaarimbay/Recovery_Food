<?php

namespace App\Http\Controllers\UserAccounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_useracc;
use Illuminate\Support\Facades\DB;

class UserAccountsController extends Controller
{
    public function save(Request $data)
    {
        $table = tbl_useracc::where("user_name", "!=", null);
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["first_name"=>$data->first_name,
                 "last_name"=>$data->last_name,
                 "email_add"=>$data->email_add,
                 "phone_number"=>$data->phone_number,
                 "user_name"=>$data->user_name,
                 "password"=>$data->password,
                 "user_role"=>$data->user_role,
                ]
            );
        } else {
            tbl_useracc::create($data->all());
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_useracc::where("user_name", "!=", null);
            $table_clone = clone $table;   // Get all items from suppcat
           
            return $table_clone->selectRaw("*, @row:=@row+1 as row ")->where("user_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  tbl_useracc::selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
}
