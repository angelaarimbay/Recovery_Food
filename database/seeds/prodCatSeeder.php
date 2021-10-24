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
            ['id' => 1, 'product_cat_name' => 'PCat 1', 'status' => '1', ],
            ['id' => 2, 'product_cat_name' => 'PCat 2', 'status' => '1', ],
            ['id' => 3, 'product_cat_name' => 'PCat 3', 'status' => '0', ],
                         
        ]);
    }
}
