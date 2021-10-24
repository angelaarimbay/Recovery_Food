<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingsupp;
use App\Models\tbl_outgoingprod;
use App\Models\tbl_suppcat;
use App\Models\tbl_prodcat;
use App\Models\tbl_prodsubcat;
use App\Models\tbl_branches;
use App\Models\tbl_suppliesinventory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB; 

class BranchesInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
   
    public function get(Request $t)
    {
        if ($t->branch) { 
            $where = ($t->branch? "requesting_branch=".$t->branch:"").
                 ($t->category? ($t->branch?" and ":"")." category=".$t->category:"") ;
 
       
                 $table = tbl_outgoingsupp::with(["category","supply_name","requesting_branch"])  
                 ->selectRaw("max(id) as id, category, supply_name, requesting_branch, sum(quantity) as quantity")
                 ->groupby(["category","supply_name","requesting_branch"])
                 ->whereRaw($where)->where("supply_name", "!=", null);
            

            if ($t->search) {
                $table =  $table ->whereHas('supply_name', function ($q) use ($t) {
                    $q->where('supply_name', 'like', "%".$t->search."%");
                });  
            } 
            $return = [];
            foreach ($table->get() as $key => $value) { 
                $temp = [];
                $temp['row']  = $key+1;
                $temp['category'] = $value->category_details;
                $temp['supply_name'] = $value->supply_name_details;
                $temp['requesting_branch'] = $value->requesting_branch_details;
                $temp['outgoing_amount']  =  number_format($value->with_vat_price *  ($value->quantity -  tbl_suppliesinventory::where([ 'branch'=>$t->branch, 'ref'=>$value->id ])->sum('quantity') ),2) ;
                $temp['quantity'] = $value->quantity -  tbl_suppliesinventory::where([  'branch'=>$t->branch, 'ref'=>$value->id ])->sum('quantity') ;
            
                array_push($return,$temp);
            } 
            $items =   Collection::make($return);
            return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);

        } else {
            return [];
        }
    }

    public function get2(Request $t)
    {
        if ($t->branch) { 
                //check param
                $where = ($t->branch? "requesting_branch=".$t->branch:"").
                       ($t->category? ($t->branch?" and ":"")." category=".$t->category:"") ;
                //formulate query
                $table= tbl_outgoingprod::with(["category","sub_category","product_name","requesting_branch"])
                            ->selectRaw('category,sub_category,product_name,requesting_branch,  sum(quantity) as quantity  ')
                            ->groupbyRaw("category,sub_category,product_name,requesting_branch")->whereRaw($where) ; 
                
                //check if like
                if ($t->search) {
                    $table = $table->whereHas('product_name', function ($q) use ($t) {
                                $q->where('product_name', 'like', "%".$t->search."%");
                            });  
                }  
                //recreate table for paginate
                $return = [];
                foreach ($table->get() as $key => $value) { 
                    $temp = [];
                    $temp['row']  = $key+1;
                    $temp['category'] = $value->category_details;
                    $temp['sub_category'] = $value->sub_category_details;
                    $temp['product_name'] = $value->product_name_details;
                    $temp['requesting_branch'] = $value->requesting_branch_details;
                    $temp['outgoing_amount'] = $value->outgoing_amount;
                    $temp['quantity'] = $value->quantity; 
                    array_push($return,$temp);
                } 
                //return
                $items =   Collection::make($return);
                return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
 
 
        } else {
            return [];
        }
    }

    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name","id"])->where("status", 1)->get();
    }

    public function prodCat()
    {
        return tbl_prodcat::select(["product_cat_name","id"])->where("status", 1)->get();
    }

    public function prodSubCat()
    {
        return tbl_prodsubcat::select(["prod_sub_cat_name","id"])->where("status", 1)->get();
    }

    public function branchName()
    {
        return tbl_branches::select(["branch_name","id"])->where("status", 1)->get();
    }
}
