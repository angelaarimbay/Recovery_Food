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
            ['id' => 1, 'name' => 'John Doe', 'first_name' => 'John', 'last_name' => 'Doe', 'email' => 'admin@gmail.com', 'password' => '$2y$10$JEJRCudImOsME.DRBJSss.ZUKok9o6ueCMow64q7G0gObsUMDQ942', 'phone_number' => '(639) 123-4567', 'branch' => '5', 'remember_token' => ''],
            ['id' => 2, 'name' => 'Julius Dolana', 'first_name' => 'Julius', 'last_name' => 'Dolana', 'email' => 'user@gmail.com', 'password' => '$2y$10$CdF/Zid7F2.HeU6/SGP1pu1eD/ct6Jy8u2sMQx5DI7n/hFEXELqYC', 'phone_number' => '(0945) 384-0702', 'branch' => '1', 'remember_token' => ''],
            ['id' => 3, 'name' => 'Jane Doe', 'first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'supervisor@gmail.com', 'password' => '$2y$10$HXMgsxJlPVI29nj5MSeJiuJJ0lE4C/nkVHYdPRq3LbD7dDHPPAShq', 'phone_number' => '(123) 456-789', 'branch' => '1', 'remember_token' => ''],
            ['id' => 4, 'name' => 'Juan Dela Cruz', 'first_name' => 'Juan', 'last_name' => 'Dela Cruz', 'email' => 'stockman@gmail.com', 'password' => '$2y$10$9TruosZ10vYwC3AR9nvVru.muE6B2aGNblMHJHv5kbgVYnj7hA2oq', 'phone_number' => '(123) 456-789', 'branch' => '5', 'remember_token' => ''],
            ['id' => 5, 'name' => 'Pedro Calungsod', 'first_name' => 'Pedro', 'last_name' => 'Calungsod', 'email' => 'prodassistant@gmail.com', 'password' => '$2y$10$IlEjUuHUD.bycKB8GuFIauTUHS9SJDHCjPqqKzWV0SFtuFxpYgmY.', 'phone_number' => '(123) 456-789', 'branch' => '5', 'remember_token' => ''],
        ]
        );
    }
}
