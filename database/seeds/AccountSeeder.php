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
        User::insert([ 
            ['id' => 1, 'name' => 'John Doe', 'first_name' => 'John', 'last_name' => 'Doe', 'email' => 'admin@gmail.com',   'password' => '$2y$10$JEJRCudImOsME.DRBJSss.ZUKok9o6ueCMow64q7G0gObsUMDQ942', 'phone_number' => '+63912345678', 'branch' => '2', 'remember_token' => '', 'created_at' => '2021-09-25 08:26:30', 'updated_at' => '2021-10-05 04:13:32'],
            ['id' => 2, 'name' => 'Julius Dolana', 'first_name' => 'Julius', 'last_name' => 'Dolana', 'email' => 'user@gmail.com',   'password' => '$2y$10$CdF/Zid7F2.HeU6/SGP1pu1eD/ct6Jy8u2sMQx5DI7n/hFEXELqYC', 'phone_number' => '123', 'branch' => '1', 'remember_token' => '', 'created_at' => '2021-09-25 08:38:53', 'updated_at' => '2021-09-26 04:47:12'],
        ]
        );
    }
}
