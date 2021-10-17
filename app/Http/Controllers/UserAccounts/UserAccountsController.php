<?php

namespace App\Http\Controllers\UserAccounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_branches;
use App\User; 
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $data)
    {
        $table = User::where("email", "!=", null);
        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count()>0) {
            // Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                [ "name"=>$data->first_name.' '.$data->last_name,
                 "first_name"=>$data->first_name,
                 "last_name"=>$data->last_name,
                 "email"=>$data->email,
                 "phone_number"=>$data->phone_number,
                 "branch"=>$data->branch, 
                ]
            );
               
         
        } else {
            $return =   User::create([ "name"=>$data->first_name.' '.$data->last_name,
            "first_name"=>$data->first_name,
            "last_name"=>$data->last_name,
            "email"=>$data->email,
            "phone_number"=>$data->phone_number,
            "branch"=>$data->branch,
            "password"=> bcrypt($data->password),
           ] + ['name'=>'']);

    
        }
        return 0;
    }
    public function get(Request $t)
    { 
         $table = User::where("email", "!=", null) ;
        
        if ($t->search) { // If has value 
            $table = $table->with('roles')->where("name", "like", "%".$t->search."%");
        } 
    
       
        $return = [];
        foreach ($table->get() as $key => $value) { 
            $temp = [];
            $temp['row']  = $key+1;
            $temp['id'] = $value->id;  
            $temp['branch'] = $value->branch_details;  
            $temp['email'] = $value->email;  
            $temp['first_name'] = $value->first_name;  
            $temp['last_name'] = $value->last_name;  
            $temp['name'] = $value->name;  
            $temp['permissionslist'] = $value->permissionslist;  
            $temp['phone_number'] = $value->phone_number;  
            $temp['photo_url'] = $value->photo_url;  
            $temp['roles'] = $value->roles;  
            array_push($return,$temp);
        }   
        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
  
    }



    // get list of permission based in role
    public function getPermission(Request $request)
    {
        $permissions = [];
        if ($request->role) {
            $permissions = Role::findByName($request->role)->permissions;
        }
        return ['data' => Permission::all(), 'selected' => $permissions];
    }
    // get list of role based in selected user
    public function getRoles(Request $request)
    {
        $roles = [];
        if ($request->user) {
            foreach (User::with("roles")->where("emplid", $request->user)->get() as $key => $value) {
                foreach ($value->roles as $key1 => $value1) {
                    $temp = [];
                    $temp['id'] = $value1->id;
                    $temp['name'] = $value1->name;
                    $temp['description'] = $value1->description;
                    array_push($roles, $temp);
                }
            }
        }
        return ['data' => Role::all(), 'selected' => $roles];
    }
    // get user with roles
    public function getUserRole(Request $request)
    {
        return User::with(["roles", 'employee'])->get();
    }

    // save roles
    public function storeRole(Request $request)
    {
        $data = Role::query();
        if ($data->where("id", $request->id)->count() > 0) {
            $data = Role::where("id", $request->id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description
                ]);
        } else {
            $data = Role::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        }
        return  $request->all();
    }
    // save permission
    public function storePermission(Request $request)
    {
        $data = Permission::query();
        if ($data->where("id", $request->id)->count() > 0) {
            $temp = $data->where("id", $request->id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description
                ]);
        } else {
            $temp = $data->create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        }
        return  $request->all();
    }

    //ito un ung kanina na pinakita ko
    public function storeRolePermission(Request $request)
    {
        $get_permission = [];
        foreach ($request->selected as $key => $value) {
            array_push($get_permission, $value['name']);
        }
        $data = Role::where("name", $request->role)->first();
        $data->syncPermissions($get_permission); //all users sync nya ung permissions

        //accessrights

        foreach (User::with("roles")->get() as $key => $value) {
            $get_roles = [];
            foreach ($value->roles as $key1 => $value1) {
                array_push($get_roles, $value1->name);
            }
            $user = User::where("id", $value->id)->first(); //then all roles na na sync aapply nya sa users
            $user->syncRoles($get_roles); // na may same role
            $get_permission = User::where("id", $value->id)->first()->getPermissionsViaRoles($get_roles);
            $user->syncPermissions($get_permission);
        }
        return true;
    }

    
    public function storeUserRole(Request $request)
    {
       
        // get the names of role from the list
        $get_role = [];
        foreach ($request->selected as $key => $value) {
            array_push($get_role, $value['name']);
        }
       
        // // get selected user
        $user =  User::where("emplid", $request->user)->first();
        // syncronize roles (add/delete)
        $user->syncRoles($get_role);
     
        // get current permission based on role/user selected
        $get_permission = $user->getPermissionsViaRoles($get_role);
        // syncornize permission (add/delete)
        return  $user->syncPermissions($get_permission);
    }
    public function removeUserRole(Request $request)
    {
        $user =  User::where("emplid", 2)->first();
        return  $user->removeRole('Admin');
    }
    public function branchName()
    {
        return tbl_branches::select(["branch_name","id"])->where("status", 1)->get();
    }

    
    public function createSeeder(Request $request)
    { 
        $temp_db = DB::table($request->id)->get();
        $temp_str = '';


        foreach ($temp_db  as $key1 => $value1) {
            $temp_str .= '[';
            $temp_num = 0;
            $temp_count = 0;
            foreach ($temp_db[$key1] as $key => $value) {
                $temp_count++;
            }

            foreach ($temp_db[$key1] as $key => $value) {
                $temp_num++;
                if ($temp_num == $temp_count) {
                    if ($key == 'id') {
                        $temp_str .= "'" . $key . "' => " . ($value??null) . "";
                    } else {
                        $temp_str .= "'" . $key . "' => '" .($value??null). "'";
                    }
                } else {
                    if ($key == 'id') {
                        $temp_str .= "'" . $key . "' => " . ($value??null) . ", ";
                    } else {
                        $temp_str .= "'" . $key . "' => '" .($value??null). "', ";
                    }
                }
            }
                $temp_str .= '],' . "\r\n"; 
        }

        return $temp_str;
    }

}
