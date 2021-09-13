<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_suppcat;


class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_suppcat::insert([ 
            [
                'status' => 1,
                'supply_cat_name'=> 'SCat 1',
            ],
            [
                'status' => 1,
                'supply_cat_name'=> 'SCat 2',
            ],
            [
                'status' => 0,
                'supply_cat_name'=> 'SCat 3',
            ]
        ]);
    }
}
