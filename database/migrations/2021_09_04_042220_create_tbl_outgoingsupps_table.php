<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOutgoingsuppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_outgoingsupps', function (Blueprint $table) {
            $table->id();
            $table->string('category')->references('id')->on('tbl_suppcat');
            $table->string('supply_name')->references('id')->on('tbl_masterlistsupp');
            $table->float('quantity');
            $table->string('requesting_branch')->references('id')->on('tbl_branches');
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_outgoingsupps');
    }
}
