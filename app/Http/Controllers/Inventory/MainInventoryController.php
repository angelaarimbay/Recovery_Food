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
        //   return  $table = tbl_incomingsupp::with(["category","supply_name"])
        //     // ->whereRaw($where)->whereHas('supply_name', function ($q) use ($t) {
        //     //     $q->where('supply_name', 'like', "%".$t->search."%");
        //     // })
        //     ->selectRaw(" sum(tbl_incomingsupps.quantity) as quantity ")
        //     ->leftJoin('tbl_masterlistsupps', 'tbl_masterlistsupps.id', '=', 'tbl_incomingsupps.supply_name')
        //     ->groupby(['tbl_masterlistsupps.group'  ])
        //     ->get();

        

        $table =   DB::select(' SELECT  
        (select sum(d.quantity) from tbl_incomingsupps d where d.supply_name in (
         (select id from tbl_masterlistsupps x where x.group = b.group)
        )) as quantity, 
        COALESCE(
        (select sum(d.quantity) from tbl_incomingsupps d where d.supply_name in (
         (select id from tbl_masterlistsupps x where x.group = b.group)
        ))- (select sum(d.quantity) from tbl_outgoingsupps d where d.supply_name in (
         (select id from tbl_masterlistsupps x where x.group = b.group)
        )),0)  as quantity_diff, 
        
        
                                sum(a.amount) as amount,
                                b.group, 
                                max(b.supply_name) as supply_name,  
                                b.net_price,
                                b.unit,
                                (select supply_cat_name from tbl_suppcats x where  x.id = b.category) as category 
        
        
                            FROM tbl_incomingsupps a 
                            left join 
                            tbl_masterlistsupps b 
                            on a.supply_name = b.id 
                            GROUP by b.group, b.net_price, b.category, b.unit;');


        $return = [];
        $row = 1;
        foreach ($table as $key => $value) {
            $temp=[];
            $temp['row'] = $row++ ;
            $temp['category'] =  $value->category;
            $temp['supply_name'] =  $value->supply_name ;
            $temp['net_price'] =  $value->net_price ;
            $temp['quantity_diff'] =  $value->quantity_diff ;
            $temp['unit'] =  $value->unit ;
            $temp['amount'] =  number_format($value->amount, 2, ".", ",");
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
