<?php

use Illuminate\Database\Seeder;

class AccumulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Accumulation::class, 50000)->create()->each(function($post){
            $post->save();
            });
    }
}
