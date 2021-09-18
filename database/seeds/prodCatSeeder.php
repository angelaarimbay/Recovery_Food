<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_prodcat;

class ProdCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_prodcat::insert([
            [
                'status' => 1,
                'product_cat_name'=> 'PCat 1',
            ],
            [
                'status' => 1,
                'product_cat_name'=> 'PCat 2',
            ],
            [
                'status' => 0,
                'product_cat_name'=> 'PCat 3',
            ]
        ]);
    }
}
