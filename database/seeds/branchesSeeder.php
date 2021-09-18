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
            [
                'status' => 1,
                'branch_name' => 'Branch 1',
                'location' => 'Test',
                'phone_number' => '123456789',
                'email_add' => '123@gmail.com'
            ],
            [
                'status' => 1,
                'branch_name' => 'Branch 2',
                'location' => 'Test',
                'phone_number' => '123456789',
                'email_add' => '123@gmail.com'
            ],
            [
                'status' => 0,
                'branch_name' => 'Branch 3',
                'location' => 'Test',
                'phone_number' => '123456789',
                'email_add' => '123@gmail.com'
            ],
        ]);
    }
}
