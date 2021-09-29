<?php

use Illuminate\Database\Seeder; 
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([ 
            [
                'name' => 'Admin',
                'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Cashier',
                'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Stockman',
                'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Production Assistant',
                'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Supervisor',
                'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
        ]);
    }
}
