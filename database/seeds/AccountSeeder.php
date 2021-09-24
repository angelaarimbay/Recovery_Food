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
        User::create(
            [
            'name'=> '',
            'first_name'=> 'John',
            'last_name'=> 'Doe',
            'email'=> 'johndoe@gmail.com',
            'password'=> bcrypt('123456'),
            'phone_number'=> '+63912345678'
        ],
        );
    }
}
