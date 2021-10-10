<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingprod;
use App\Models\tbl_pos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

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
        $table =  tbl_outgoingprod::with(["category","sub_category","product_name"])
        ->whereHas("requesting_branch", function ($q) {
            $q->where("id", auth()->user()->branch);
        })->whereHas("product_name", function ($q1) use ($t) {
            $q1->where("product_name", "like", "%".$t->search."%");
        }) ;


        $return = [];
        $row = 1;
        foreach ($table->get() as $key => $value) {
            $temp=[];
            if ($value->quantity_diff != 0) {
                array_push($return, $value);
            }
        }
    

        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), 5, $t->page, []);
    }

    public function getSalesCount()
    {
        return tbl_pos::where(['branch'=> auth()->user()->branch])
        ->whereBetween("created_at", [date("Y-m-d H:i:s", strtotime(date("Y-m-d") . ' 00:00:01')),  date("Y-m-d H:i:s", strtotime(date("Y-m-d") . ' 11:59:59')) ])
        ->count();
    }
    
    public function save(Request $t)
    {
        $refno = strtotime(date("Y-m-d h:i:s.u"));
        foreach ($t->all() as $key => $value) {
            $data =    tbl_pos::create(['category' => $value['category'],
                             'sub_category'=> $value['sub_category'],
                             'product_name'=> $value['product_name'],
                             'quantity'=> $value['quantity'],
                             'sub_total'=> $value['sub_total'],
                             'sub_total_discounted'=> $value['sub_total_discounted'],
                             'payment'=> $value['payment'],
                             'discount'=> $value['discount'],
                             'change'=> $value['change'],
                             'mode'=> $value['mode'],
                             'reference_no'=>$refno,
                             'branch'=> auth()->user()->branch,
                             'cashier'=>auth()->user()->id]);
        }
        return $data;
    }

    public function getSalesToday()
    {
        $data = tbl_pos::where(['cashier'=> auth()->user()->id])
                        ->whereBetween("created_at", [date("Y-m-d H:i:s", strtotime(date("Y-m-d") . ' 00:00:01')),  date("Y-m-d H:i:s", strtotime(date("Y-m-d") . ' 11:59:59')) ])
                        ->get();

        $content['data'] = $data;
        $pdf = PDF::loadView('pos.transaction',
        $content,
        [],
        ['format' => 'A4-L']
        );
        return $pdf->stream();
    }
}
