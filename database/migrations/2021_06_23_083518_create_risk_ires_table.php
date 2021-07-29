<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskIresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_ires', function (Blueprint $table) {
            $table->id();
            $table->string('policy_no','max')->nullable(); 
            $table->string('title','max')->nullable(); 
            $table->string('description','max')->nullable(); 
            $table->dateTime('date')->nullable();
            $table->string('filename','max')->nullable(); 
            $table->integer('active')->default(1); 
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
        Schema::dropIfExists('risk_ires');
    }
}
