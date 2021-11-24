<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\tbl_masterlistsupp;
use App\Models\tbl_suppcat;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MasterlistSuppliesController extends Controller
{
    //Middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

    //For saving masterlist supplies info
    public function save(Request $data)
    {
        $table = tbl_masterlistsupp::where("status", "!=", null);

        $table_clone = clone $table;
        if ($table_clone->where("id", $data->id)->count() > 0) {
            //Update
            $table_clone = clone $table;
            $table_clone->where("id", $data->id)->update(
                ["status" => $data->status,
                    "category" => $data->category,
                    "supplier" => $data->supplier['id'],
                    "supply_name" => $data->supply_name,
                    "description" => $data->description,
                    "unit" => $data->unit,
                    "net_price" => $data->net_price,
                    "vat" => $data->vat,
                    "vatable" => $data->vatable,
                    "exp_date" => $data->exp_date,
                    "lead_time" => $data->lead_time,
                    "order_frequency" => $data->order_frequency,
                    "minimum_order_quantity" => $data->minimum_order_quantity,
                ]
            );
        } else {
            $supply = '';
            if (is_array($data->supply_name)) {
                $supply = $data->supply_name['supply_name'];
            } else {
                $supply = $data->supply_name;
            }

            tbl_masterlistsupp::create(
                $data->except('supply_name', 'supplier') +
                ['supply_name' => $supply,
                    "supplier" => $data->supplier['id']]//When same item = sum quantity
            );
        }
        return 0;
    }

    //For retrieving supply names
    public function suppName(Request $t)
    {
        return tbl_masterlistsupp::where("supplier", $t->supplier)->where("status", 1)->get();
    }

    //For retrieving masterlist supplies info
    public function get(Request $t)
    {
        $where = ($t->category ? "category !=0  and category=" . $t->category : "category != 0") .
            ($t->supplier ? " and supplier=" . $t->supplier : "");

        // return $where;
        $table = tbl_masterlistsupp::with("category", "supplier")
            ->selectRaw("*, case when exp_date is null THEN null when datediff(exp_date,current_timestamp) > 7 THEN null ELSE datediff(exp_date,current_timestamp) end as days")
            ->whereRaw($where);

        if ($t->search) { //If has value
            $table = $table->where("supply_name", "like", "%" . $t->search . "%");
        }

        $return = [];
        foreach ($table->orderByRaw("  days desc ")->get() as $key => $value) {
            $temp = [];
            $temp['row'] = $key + 1;
            $temp['id'] = $value->id;
            $temp['status'] = $value->status;
            $temp['supplier'] =
            $data = DB::table("tbl_supplists")
                ->selectRaw(' CONCAT(supplier_name , " ", COALESCE(description,"")) as supplier_name, phone_number, contact_person, address, description, id')
                ->where("id", $value->supplier)->where("status", 1)->first();
            $temp['category'] = $value->category_details;
            $temp['unit'] = $value->unit;
            $temp['vat'] = $value->vat;
            $temp['vatable'] = $value->vatable;
            $temp['supply_name'] = $value->supply_name;
            $temp['description'] = $value->description;
            $temp['format_net_price'] = $value->format_net_price;
            $temp['net_price'] = $value->net_price;
            $temp['lead_time'] = $value->lead_time;
            $temp['order_frequency'] = $value->order_frequency;
            $temp['minimum_order_quantity'] = $value->minimum_order_quantity;
            $temp['without_vat_price'] = number_format($value->without_vat_price, 2);
            $temp['with_vat_price'] = number_format($value->with_vat_price, 2);
            $temp['days'] = $value->days;
            $temp['exp_date'] = $value->exp_date;
            array_push($return, $temp);
        }
        $items = Collection::make($return);
        return new LengthAwarePaginator(collect($items)->forPage($t->page, $t->itemsPerPage)->values(), $items->count(), $t->itemsPerPage, $t->page, []);
    }

    //For retrieving supply categories
    public function suppCat()
    {
        return tbl_suppcat::select(["supply_cat_name", "id"])->where("status", 1)->get();
    }

    //For validating item
    public function validateItem(Request $t)
    {
        try {
            return tbl_masterlistsupp::where("supply_name", $t->name)->get();
        } catch (\Throwable $th) {
            return false;
        }
    }

    //For getting the sum of net price
    public function sum(Request $t)
    {
        return tbl_masterlistsupp::where("id", $t->id)->sum("net_price");
    }

    //For retrieving suppliers info
    public function suppliers()
    {
        $data = DB::table("tbl_supplists")
            ->selectRaw(' CONCAT(supplier_name , " ", COALESCE(description,"")) as supplier_name, phone_number, contact_person, address, description, id')
            ->get();
        return $data;
    }
}
