<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingprod;
use App\Models\tbl_pos;
use Illuminate\Support\Facades\DB;

class ProductsListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function get(Request $t)
    {
        DB::statement(DB::raw("set @row:=0"));
        return tbl_outgoingprod::with(["category","sub_category","product_name"])
        ->whereHas("requesting_branch", function ($q) {
            $q->where("id", auth()->user()->branch);
        })->whereHas("product_name", function ($q1) use ($t) {
            $q1->where("product_name", "like", "%".$t->search."%");
        }) ->selectRaw("*, @row:=@row+1 as row")->paginate($t->itemsPerPage, "*", "page", $t->page);
    }
    
    public function save(Request $t)
    {
        $refno = strtotime(date("Y-m-d h:i:s.u"));
        foreach ($t->all() as $key => $value) {
            tbl_pos::create(['category' => $value['category'],
                             'sub_category'=> $value['sub_category'],
                             'product_name'=> $value['product_name'],
                             'quantity'=> $value['quantity'],
                             'sub_total'=> $value['sub_total'],
                             'sub_total_discounted'=> $value['sub_total_discounted'] ,
                             'mode'=> $value['mode'],
                             'reference_no'=>$refno,
                             'branch'=> auth()->user()->branch,
                             'cashier'=>auth()->user()->id]);
        }
        return 'saved!';
    }
}
