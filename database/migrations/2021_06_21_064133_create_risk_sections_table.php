<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_sections', function (Blueprint $table) {
            $table->id();
            // $table->string('insured_code','max')->nullable(); 
            // $table->string('address','max')->nullable(); 
            // $table->string('policy_no','max')->nullable(); 
            // $table->dateTime('inception')->nullable();
            // $table->dateTime('expiry')->nullable();
            // $table->integer('latitude')->nullable(); 
            // $table->integer('longitude')->nullable();  
            // $table->string('proposed_next_servey',"max")->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_sections');
    }
}
