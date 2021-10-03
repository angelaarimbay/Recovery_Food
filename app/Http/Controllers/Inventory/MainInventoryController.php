<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_suppcat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MainInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function get(Request $t)
    {
        $where = ($t->category? "category !=0  and category=".$t->category:"category != 0");
        $table = tbl_incomingsupp::with(["category","supply_name"])
                                    ->whereRaw($where)->whereHas('supply_name', function ($q) use ($t) {
                                        $q->where('supply_name', 'like', "'%".$t->search."%");
                                    })
                                    ->groupby(["category","supply_name"])
                                    ->selectRaw("category,supply_name")
                                    ->get();
        $return = [];
        $row = 1;
        foreach ($table as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  $value->category_details;
            $temp['supply_name'] =  $value->supply_name_details ;
            $temp['quantity_amount'] =  number_format($value->quantity_amount, 2, ".", ",");
            $temp['quantity_difference'] =  ($value->quantity_difference??0) ;
            array_push($return, $temp);
        }

        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), 5, $t->page, []);
      
    }
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
}
