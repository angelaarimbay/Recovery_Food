<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Accumulation;
use Faker\Generator as Faker;

$factory->define(Accumulation::class, function (Faker $faker) {
    static $order = 1;  
    return [
        "policy_no" => $order++ ,
        "inception" => date("Y-m-d h:i:s"),
        "expiry" => date("Y-m-d h:i:s"),
        "insured_code" => $order++ ,
        "insured" =>  $faker->sentence(10), 
        "location_of_risk" =>   $faker->sentence(10), 
        "premium" =>   $faker->numberBetween(100000,10000000000), 
        "our_si" =>  $faker->numberBetween(100000,10000000000), 
        "eq_si" =>  $faker->numberBetween(100000,10000000000), 
        "ty_si" =>   $faker->numberBetween(100000,10000000000), 
        "fl_si" =>   $faker->numberBetween(100000,10000000000), 
        "full_si" =>   $faker->numberBetween(100000,10000000000), 
        "our_si_or" =>   $faker->numberBetween(100000,10000000000), 
        "our_si_tty" =>   $faker->numberBetween(100000,10000000000), 
        "our_si_fac" =>   $faker->numberBetween(100000,10000000000), 
        "cresta_id" =>   $faker->randomElement(['PHL_BTN','PHL_CVT','PHL_LGN','PHL_PAM','PHL_PAN','PHL_NSA','PHL_MSC','PHL_MAN','PHL_LAN','PHL_ZSI'] ), 
        "block" =>   $faker->postcode . '-R' .$faker->randomDigit , 
        "zip_code" =>   $faker->postcode,
        "suffix" =>  $faker->randomElement(['E','R']) .$faker->randomDigit , 
        "eq_zone" =>  $faker->randomElement([0,1,2,3,4,5,6,7,8,9]) , 
        "ty_zone" =>  $faker->randomElement([0,1,2,3,4,5,6,7,8,9]) , 
        "fl_zone" =>   $faker->randomElement([0,1,2,3,4,5,6,7,8,9]) , 
    ];
});
