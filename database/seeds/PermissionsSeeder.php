<?php

use Illuminate\Database\Seeder;
use App\Models\permissions;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        permissions::insert([
            [
                'name' => 'Access POS',
                'description' => 'manage POS',
            ],
            [
                'name' => 'Access Dashboard',
                'description' => 'manage dashboard',
            ],
            [
                'name' => 'Access Branches',
                'description' => 'manage branches',
            ],
            [
                'name' => 'Access Categories',
                'description' => 'manage categories',
            ],
            [
                'name' => 'Access Inventory',
                'description' => 'manage inventory',
            ],
            [
                'name' => 'Access Products',
                'description' => 'manage products',
            ],
            [
                'name' => 'Access Suppliers',
                'description' => 'manage suppliers',
            ],
            [
                'name' => 'Access Reports',
                'description' => 'manage reports',
            ],
            [
                'name' => 'Access User Accounts',
                'description' => 'manage user accounts',
            ],
            [
                'name' => 'Access Settings',
                'description' => 'manage settings',
            ],
        ]);
    }
}
