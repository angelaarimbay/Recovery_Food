<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'Access POS',
                'description' => 'manage POS',
                'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Dashboard',
                'description' => 'manage dashboard',
                'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Branches',
                'description' => 'manage branches',
                'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Categories',
                'description' => 'manage categories', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Inventory',
                'description' => 'manage inventory', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Products',
                'description' => 'manage products', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Suppliers',
                'description' => 'manage suppliers', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Reports',
                'description' => 'manage reports', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access User Accounts',
                'description' => 'manage user accounts', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
            [
                'name' => 'Access Settings',
                'description' => 'manage settings', 'guard_name' => 'api', 'created_at' => '2021-04-25 21:27:22.540', 'updated_at' => '2021-09-06 16:19:59.357'
            ],
        ]);
    }
}
