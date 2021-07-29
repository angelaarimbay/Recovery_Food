<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccumulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accumulations', function (Blueprint $table) {
            $table->id();
            $table->string('policy_no','max')->nullable();
            $table->string('endt_no','max')->nullable();

            $table->dateTime('inception')->nullable();
            $table->dateTime('expiry')->nullable();
            $table->string('insured_code','max')->nullable();
            $table->string('insured','max')->nullable();
            $table->string('location_of_risk','max')->nullable();
            $table->float('premium')->nullable();
            $table->float('our_si')->nullable();
            $table->float('eq_si')->nullable();
            $table->float('ty_si')->nullable();
            $table->float('fl_si')->nullable(); 
            $table->float('full_si')->nullable(); 

            $table->float('our_si_or')->nullable();
            $table->float('our_si_fac')->nullable(); 
            $table->float('our_si_tty')->nullable(); 
            $table->float('our_si_quo')->nullable(); 

            $table->string('cresta_id','max')->nullable();
            $table->string('block','max')->nullable(); 
            $table->string('zip_code','max')->nullable(); 
            $table->string('suffix','max')->nullable();
            $table->string('eq_zone','max')->nullable();
            $table->string('ty_zone','max')->nullable();
            $table->string('fl_zone','max')->nullable();
            $table->string('gps_long','max')->nullable();
            $table->string('gps_lat','max')->nullable();

            $table->string('unit_no','max')->nullable();
            $table->string('report_code','max')->nullable();
            $table->string('username','max')->nullable();
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
        Schema::dropIfExists('accumulations');
    }
}
