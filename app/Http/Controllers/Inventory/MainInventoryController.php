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
        $where = ($t->category? "tbl_masterlistsupps.category !=0  and tbl_masterlistsupps.category=".$t->category:"tbl_masterlistsupps.category != 0");
        // $table = tbl_incomingsupp::query()
        // ->with(["category","supply_name"])
        // ->whereRaw($where)->whereHas('supply_name', function ($q) use ($t) {
        //     $q->where('supply_name', 'like', "%".$t->search."%");
        // })
        // ->selectRaw("
        // tbl_masterlistsupps.group, 
        // max(net_price),
        // sum(amount) as amount, 
        // sum(quantity) as quantity, 
        //  max(tbl_masterlistsupps.category) as category, 
        //  max(tbl_masterlistsupps.supply_name) as supply_name")
        // ->leftJoin('tbl_masterlistsupps', 'tbl_masterlistsupps.id', '=', 'tbl_incomingsupps.supply_name') 
        // ->groupby(['tbl_masterlistsupps.group'  ])
        // ->get();

     return   $table = DB::selectRaw('SELECT sum(a.quantity) as quantity, sum(a.amount) as amount, b.group, max(b.supply_name) as supply_name, max(b.category) as category FROM `tbl_incomingsupps` a left join tbl_masterlistsupps b on a.supply_name = b.id GROUP by b.group;')->get();


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
