<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_branches;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_branches::insert([ 
            ['id' => 1, 'status' => '1', 'branch_name' => 'Branch 1', 'location' => 'Test', 'phone_number' => '123456789', 'email_add' => '123@gmail.com', 'branch_image' => '',  ],
            ['id' => 2, 'status' => '1', 'branch_name' => 'Branch 2', 'location' => 'Test', 'phone_number' => '123456789', 'email_add' => '123@gmail.com', 'branch_image' => '', ],
            ['id' => 3, 'status' => '1', 'branch_name' => 'Branch 3', 'location' => 'Test', 'phone_number' => '123456789', 'email_add' => '123@gmail.com', 'branch_image' => '', ],
            ['id' => 4, 'status' => '0', 'branch_name' => 'test', 'location' => 'test', 'phone_number' => 'test', 'email_add' => 'test', 'branch_image' => '',  ],
            
        ]);
    }
}
