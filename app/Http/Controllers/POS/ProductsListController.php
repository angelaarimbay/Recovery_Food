<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingprod;
use Illuminate\Support\Facades\DB;

class ProductsListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0")); 
        return tbl_outgoingprod::with(['category','sub_category',"product_name"])
        ->whereHas('requesting_branch', function ($q) {
            $q->where('id', auth()->user()->branch );
        }) ->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);

 
    }
}
