<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_outgoingsupp;
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
 
     
          $table= tbl_outgoingsupp::with(["category","supply_name","requesting_branch"]);
          if ($where) {
              if ($t->search) {
                  $table = $table->whereRaw($where)
                            ->whereHas('supply_name', function ($q) use ($t) {
                                $q->where('supply_name', 'like', '%'.$t->search.'%');
                            });
              } else {
                  $table = $table->whereRaw($where);
              }
          }
          if ($t->search) {
              return $table ->whereHas('supply_name', function ($q) use ($t) {
                  $q->where('supply_name', 'like', '%'.$t->search.'%');
              })->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
          } else {
              return $table->selectRaw("*, @row:=@row+1 as row ")->paginate($t->itemsPerPage, "*", "page", $t->page);
          }
      }else{
          return [];
      }
    }
}
