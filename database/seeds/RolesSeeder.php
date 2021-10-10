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
            ['id' => 1, 'name' => 'Admin', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22', 'updated_at' => '2021-09-06 16:19:59'],
            ['id' => 2, 'name' => 'Cashier', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22', 'updated_at' => '2021-09-06 16:19:59'],
            ['id' => 3, 'name' => 'Stockman', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22', 'updated_at' => '2021-09-06 16:19:59'],
            ['id' => 4, 'name' => 'Production Assistant', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22', 'updated_at' => '2021-09-06 16:19:59'],
            ['id' => 5, 'name' => 'Supervisor', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22', 'updated_at' => '2021-09-06 16:19:59'],
            
        ]);
    }
}
