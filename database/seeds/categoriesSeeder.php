<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_suppcat;


class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_suppcat::insert([ 
            ['id' => 1, 'supply_cat_name' => 'Dry Goods', 'status' => '1', ],
            ['id' => 2, 'supply_cat_name' => 'Cleaning Materials', 'status' => '1', ],
            ['id' => 3, 'supply_cat_name' => 'Non-Food', 'status' => '1', ],
                         
        ]);
    }
}
