<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_prodsubcat;

class prodSubCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_prodsubcat::insert([ 
            [
                'status' => 1,
                'prod_sub_cat_name'=> 'PSCat 1',
            ],
            [
                'status' => 1,
                'prod_sub_cat_name'=> 'PSCat 2',
            ],
            [
                'status' => 0,
                'prod_sub_cat_name'=> 'PSCat 3',
            ]
        ]);
    }
}
