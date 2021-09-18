<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers()
    {
        // return User::all()->map(function($query){
        //     $query['roles'] = DB::table('model_has_roles as a')
        //     ->select('b.name')
        //     ->leftJoin('roles as b','a.role_id','=','b.id')
        //     ->where('a.model_id',$query->id)
        //     ->get();
        //     return $query;
        // });
        return User::select('id','name','email','empl_contactno','empl_caddress')->where('active',1)->get();
    }
}
