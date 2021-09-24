<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::unprepared('SET IDENTITY_INSERT roles ON');
        DB::table('roles')->insert([   
            ['id' => 1, 'name' => 'Manager', 'description' => 'Manages RF', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'],
            ['id' => 2, 'name' => 'Stockman', 'description' => 'Manages inventory', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:28:56.627', 'updated_at' => '2021-09-06 16:19:54.733'],
            ['id' => 3, 'name' => 'Production Assistant', 'description' => 'Manages Products', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:30:13.830', 'updated_at' => '2021-04-25 21:31:45.803'],
            ['id' => 4, 'name' => 'Cashier', 'description' => 'manages Sales', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:33:26.593', 'updated_at' => '2021-09-06 16:17:40.377'],
            ['id' => 5, 'name' => 'Supervisor', 'description' => 'Monitor the inventory ', 'guard_name' => 'api', 'created_at' => '2021-04-26 14:37:17.017', 'updated_at' => '2021-09-06 16:19:48.667'],
                         
        ]); 
        // DB::unprepared('SET IDENTITY_INSERT roles OFF');
    }
}
