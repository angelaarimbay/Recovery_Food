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
            DB::statement(DB::raw("set @row:=0"));
            $where = ($t->branch? "requesting_branch=".$t->branch:"").
                 ($t->category? ($t->branch?" and ":"")." category=".$t->category:"") ;
 
     
            $table= tbl_outgoingsupp::with(["category","supply_name","requesting_branch"])->selectRaw("*, @row:=@row+1 as row ");
            if ($where) {
                if ($t->search) {
                    $table = $table->whereRaw($where)
                            ->whereHas('supply_name', function ($q) use ($t) {
                                $q->where('supply_name', 'like', "%".$t->search."%");
                            });
                } else {
                    $table = $table->whereRaw($where);
                }
            }
            if ($t->search) {
                return $table ->whereHas('supply_name', function ($q) use ($t) {
                    $q->where('supply_name', 'like', "%".$t->search."%");
                })->paginate($t->itemsPerPage, "*", "page", $t->page);
            } else {
                return $table->paginate($t->itemsPerPage, "*", "page", $t->page);
            }
        } else {
            return [];
        }
    }

    public function get2(Request $t)
    {
        if ($t->branch) {
            DB::statement(DB::raw("set @row:=0"));
            $where = ($t->branch? "requesting_branch=".$t->branch:"").
                 ($t->category? ($t->branch?" and ":"")." category=".$t->category:"") ;
 
     
            $table= tbl_outgoingprod::with(["category","sub_category","product_name","requesting_branch"]);
            if ($where) {
                if ($t->search) {
                    $table = $table->whereRaw($where)
                            ->whereHas('product_name', function ($q) use ($t) {
                                $q->where('product_name', 'like', "'%".$t->search."%");
                            });
                } else {
                    $table = $table->whereRaw($where);
                }
            }
            if ($t->search) {
                return $table ->whereHas('product_name', function ($q) use ($t) {
                    $q->where('product_name', 'like', "'%".$t->search."%");
                })->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
            } else {
                return $table->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
            }
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
