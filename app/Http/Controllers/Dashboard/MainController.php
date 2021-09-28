<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_masterlistprod;
use App\Models\tbl_purchaseord;
use App\User;

class MainController extends Controller
{
    public function test(Request $request)
    {
        $img = $request->file('file');
        $newfilename  = $img->getClientOriginalName()."-".time().'.'.$img->getClientOriginalExtension();
        $input['imagename'] = $newfilename;
        $img->storeAs('public/files/bulletin/', $newfilename);
        return ['filename'=>$input['imagename'],'fakefilename'=> $img->getClientOriginalName()];
    }

    public function getSupp()
    {
        return tbl_masterlistsupp::where("status", 1)->get()->count("supply_name");
    }

    public function getProd()
    {
        return tbl_masterlistprod::where("status", 1)->get()->count("product_name");
    }

    public function getPO()
    {
        return tbl_purchaseord::where("invoice_number", "!=", null)->get()->count("invoice_number");
    }

    public function getUser()
    {
        return User::where("email", "!=", null)->get()->count("email");
    }
}
