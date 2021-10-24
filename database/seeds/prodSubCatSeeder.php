<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_prodsubcat;

class ProdSubCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_prodsubcat::insert([ 
            ['id' => 1, 'prod_sub_cat_name' => 'PSCat 1', 'status' => '1', ],
            ['id' => 2, 'prod_sub_cat_name' => 'PSCat 2', 'status' => '1', ],
            ['id' => 3, 'prod_sub_cat_name' => 'PSCat 3', 'status' => '0', ],
                     
        ]);
    }
}
