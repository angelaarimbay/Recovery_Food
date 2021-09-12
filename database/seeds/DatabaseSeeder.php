<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(branchesSeeder::class);
        $this->call(categoriesSeeder::class);
        $this->call(prodCatSeeder::class);
        $this->call(prodSubCatSeeder::class);
    }
}
