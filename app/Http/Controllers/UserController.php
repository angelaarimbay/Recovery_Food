<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function getUsers()
    { 
        return User::get();
    }
    
    public function change_password(Request $request){
        User::where("id",auth()->user()->id)->update([
            'password' => bcrypt($request->password),
        ]);
        return true;
    }


    public function getPermission(Request $request)
    {
        $permissions = [];
        if ($request->role) {
            $permissions = Role::findByName($request->role)->permissions;
        }
        return ['data' => Permission::all(), 'selected' => $permissions];
    }
    public function getRoles(Request $request)
    {
        $roles = [];
        if ($request->user) {
            foreach (User::with("roles")->where("id", $request->user)->get() as $key => $value) {
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
    public function getUserRole(Request $request)
    {
        return User::with(["roles"])->get();
    }


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
    public function storeRolePermission(Request $request)
    {
        $get_permission = [];
        foreach ($request->selected as $key => $value) {
            array_push($get_permission, $value['name']);
        }
        $data = Role::where("name", $request->role)->first();
        $data->syncPermissions($get_permission);

        //accessrights

        foreach (User::with("roles")->get() as $key => $value) {
            $get_roles = [];
            foreach ($value->roles as $key1 => $value1) {
                array_push($get_roles, $value1->name);
            }
            $user = User::where("id", $value->id)->first();
            $user->syncRoles($get_roles);
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
      $user =  User::where("id", $request->user)->first();
        // syncronize roles (add/delete)
             $user->syncRoles($get_role);
     
        // get current permission based on role/user selected
        $get_permission = $user->getPermissionsViaRoles($get_role);
        // syncornize permission (add/delete)
        return  $user->syncPermissions($get_permission);
    }
    public function removeUserRole(Request $request)
    {
        $user =  User::where("id", 2)->first();
        return  $user->removeRole('Admin');
    }
















}
