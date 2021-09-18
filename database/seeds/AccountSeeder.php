<?php

use App\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        User::create([ 
            'name'=> 'cy',
            'password'=> bcrypt('123456'),
            'email'=>'admin@admin.com' 
        ], 
    );
        
    }
}
