<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\tbl_suppliesinventory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DeductedSuppliesController extends Controller
{
    //For retrieving deducted supplies
    public function get(Request $t)
    {
        $where = ($t->category ? "category !=0  and category=" . $t->category : "category != 0");
        $table = tbl_suppliesinventory::whereRaw($where);

        if ($t->search) { //If has value
            $table = $table->where("supply_name", "like", "%" . $t->search . "%");
        }
        if ($t->dateFrom && $t->dateUntil) {
            $table = $table->whereBetween("outgoing_date", [date("Y-m-d 00:00:00", strtotime($t->dateFrom)), date("Y-m-d 23:59:59", strtotime($t->dateUntil))]);
        }

        $return = [];
        foreach ($table->get() as $key => $value) {
            $temp = [];
            $temp['row'] = $key + 1;
            $temp['id'] = $value->id;
            $temp['category'] = $value->category_details;
            $temp['supply_name'] = $value->supply_name_details;
            $temp['unit'] = $value->supply_name_details['unit'];
            $temp['net_price'] = $value->supply_name_details['net_price'];
            $temp['with_vat_price'] = $value->supply_name_details['with_vat_price'];
            $temp['quantity'] = $value->quantity;
            $temp['amount'] = $value->quantity * $value->supply_name_details['net_price'];
            $temp['outgoing_date'] = $value->outgoing_date;
            array_push($return, $temp);
        }

        $items = Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }
}
