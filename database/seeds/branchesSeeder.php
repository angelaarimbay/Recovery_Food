<?php

use Illuminate\Database\Seeder;
use App\Models\tbl_branches;

class branchesSeeder extends Seeder
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
                'branch_name' => 'ABCD',
                'location' => 'Test',
                'phone_number' => '123456789',
                'email_add' => '123@gmail.com'
            ],
        ]);
    }
}
