<?php

use Illuminate\Database\Seeder;
use App\Models\roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        roles::insert([ 
            [
                'name' => 'Admin',
                'description' => '',
            ],
            [
                'name' => 'Cashier',
                'description' => '',
            ],
            [
                'name' => 'Stockman',
                'description' => '',
            ],
            [
                'name' => 'Production Assistant',
                'description' => '',
            ],
            [
                'name' => 'Supervisor',
                'description' => '',
            ],
        ]);
    }
}
