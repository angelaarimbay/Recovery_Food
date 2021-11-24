<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\tbl_company;
use App\Models\tbl_vat;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //For uploading logo
    public function uploadLogo(Request $t)
    {
        try {
            $img = $t->file('file');
            $newfilename = $img->getClientOriginalName() . "~" . time() . '.' . $img->getClientOriginalExtension();
            $input['imagename'] = $newfilename;
            $img->storeAs('public/logo/', $input['imagename']);
            return ['filename' => $img->getClientOriginalName(), 'tempfile' => $newfilename, 'path' => url('/storage/logo/' . $input['imagename'])];
        } catch (\Throwable $th) {
        }
    }

    //For saving logo
    public function storeLogo(Request $t)
    {
        tbl_company::create(['logo' => $t->attachment]);
    }

    //For removing logo
    public function deleteLogo()
    {
        tbl_company::where('active', '!=', 0)->update(['active' => 0]);
    }

    //For retrieving logo
    public function getLogo()
    {
        if (tbl_company::where("active", 1)->orderBy('id', 'desc')->get()->count() > 0) {
            $logo = url('/storage/logo/' . tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo);
            $filename = tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo;
            $temp = explode('~', tbl_company::where("active", 1)->orderBy('id', 'desc')->first()->logo)[0];
        } else {
            $logo = null;
            $filename = null;
            $temp = null;
        }
        return ['path' => $logo, 'tempfile' => $filename, 'filename' => $temp];
    }

    //For storing VAT
    public function storeVat(Request $t)
    {
        if (tbl_vat::where(["type" => $t->type])->get()->count() > 0) {
            if (tbl_vat::where(["type" => $t->type, 'vat' => $t->vat])->get()->count() > 0) {
                return 0;
            } else {
                tbl_vat::where(["type" => $t->type])
                    ->update(['vat' => $t->vat,
                        'type' => $t->type,
                        'cashier' => auth()->user()->id]);
                return 1;
            }
        } else {
            tbl_vat::create(['vat' => $t->vat,
                'type' => $t->type,
                'cashier' => auth()->user()->id]);
            return 1;
        }

    }

    //For retrieving VAT
    public function getVat(Request $t)
    {
        return tbl_vat::where("type", $t->type)->orderby("created_at", 'desc')->first();
    }
}
