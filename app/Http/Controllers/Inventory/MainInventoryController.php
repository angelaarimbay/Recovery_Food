<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_incomingsupp;
use App\Models\tbl_suppcat;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_outgoingsupp;
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
        $table = DB::select("
                select  
                max(`group`)  as 'group',
                supply_name, 
                unit, 
                (select supply_cat_name from tbl_suppcats x where x.id = a.category ) as category, 
                avg(net_price) as net_price 
                from tbl_masterlistsupps a
                where ".$where."
                group by supply_name, unit, category ");

        $return = [];
        $row = 1;
        foreach ($table as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  $value->category;
            $temp['supply_name'] =  $value->supply_name ;
            $temp['net_price'] =  $value->net_price ;
          
            $id_array = tbl_masterlistsupp::where("group",$value->group)->pluck('id');
              //get quantity
            $in_data = tbl_incomingsupp::wherein('supply_name', $id_array)->sum('quantity');
            $out_data = tbl_outgoingsupp::wherein('supply_name', $id_array)->sum('quantity'); 

            $temp['quantity_diff'] =  $in_data - $out_data;
            $temp['unit'] =  $value->unit ;
            $temp['amount'] = ($in_data - $out_data) * $value->net_price ;
            array_push($return, $temp);
        }

        $items =   Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(),$t->itemsPerPage, $t->page, []);
    }
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }
}
