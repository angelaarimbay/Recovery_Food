<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::unprepared('SET IDENTITY_INSERT permissions ON');
        DB::table('permissions')->insert([   
            ['id' => 1, 'name' => 'Access POS', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 2, 'name' => 'Access Dashboard', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 3, 'name' => 'Access Branches', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 4, 'name' => 'Access Categories', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 5, 'name' => 'Access Inventory', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 6, 'name' => 'Access Products', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 7, 'name' => 'Access Suppliers', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 8, 'name' => 'Access Reports', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 9, 'name' => 'Access Settings', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            ['id' => 10, 'name' => 'Access User Accounts', 'description' => '', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:39:16.410', 'updated_at' => '2021-08-20 10:03:57.897'],
            
        
        ]);
            

        // DB::unprepared('SET IDENTITY_INSERT permissions OFF');
            
    }
}
