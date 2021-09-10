<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblInvsummsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_invsumms', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->float('beginning_inv');
            $table->float('purchases');
            $table->float('total_inv');
            $table->float('outgoing_supp');
            $table->integer('stocks_on_hand');
            $table->float('ending_inv');
            $table->float('variance');
            $table->float('fluctuation_impact');
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
        Schema::dropIfExists('tbl_invsumms');
    }
}
