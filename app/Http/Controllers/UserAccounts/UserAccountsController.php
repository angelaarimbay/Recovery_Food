<?php

namespace App\Http\Controllers\UserAccounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserAccountsController extends Controller
{
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
                 "password"=>  Crypt::encryptString($data->password), 
                ]
            );
        } else {
            User::create( [ "name"=>$data->first_name.' '.$data->last_name,
            "first_name"=>$data->first_name,
            "last_name"=>$data->last_name,
            "email"=>$data->email,
            "phone_number"=>$data->phone_number, 
            "password"=>  Crypt::encryptString($data->password), 
           ] + ['name'=>'']);
        }
        return 0;
    }
    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = User::where("email", "!=", null);
            $table_clone = clone $table;   // Get all items from suppcat
           
            return $table_clone->selectRaw("email as user_name  , @row:=@row+1 as row ")->where("email", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        // Else
        return  User::selectRaw("email as user_name, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
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





}
