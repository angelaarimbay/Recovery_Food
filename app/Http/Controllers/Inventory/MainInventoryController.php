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
        DB::statement(DB::raw("set @row:=0"));
        if ($t->search) { // If has value
            $table = tbl_incomingsupp::with(["category","supply_name"])->groupby(["category","supply_name"]);
            return $table->selectRaw("category,supply_name, @row:=@row+1 as row ")->where("supply_name", "like", "%".$t->search."%")->paginate($t->itemsPerPage, "*", "page", 1);
        }
        $data = tbl_incomingsupp::with(["category","supply_name"])->groupby(["category","supply_name"])->selectRaw("category,supply_name")->get();

        $return = [];
        $row = 1;
        foreach ($data as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  $value->category_details;
            $temp['supply_name'] =  $value->supply_name_details ;
            $temp['quantity_amount'] =  number_format($value->quantity_amount, 2, ".", ",");
            $temp['quantity_difference'] =  $value->quantity_difference ;
            array_push($return, $temp);
        }
 
        $items =   Collection::make($return);
        return new LengthAwarePaginator($items->forPage(1, $t->itemsPerPage), $data->count(), 5, $t->page, []);
    }

    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
}
