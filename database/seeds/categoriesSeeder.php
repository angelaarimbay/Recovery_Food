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
            ['id' => 1, 'supply_cat_name' => 'SCat 1', 'status' => '1'],
            ['id' => 2, 'supply_cat_name' => 'SCat 2', 'status' => '1'],
            ['id' => 3, 'supply_cat_name' => 'SCat 3', 'status' => '0' ],
            
        ]);
    }
}
