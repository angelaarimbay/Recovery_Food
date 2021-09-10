<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMaininvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_maininvs', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('supply_name');
            $table->string('supply_description')->nullable();
            $table->string('unit');
            $table->float('net_price');
            $table->integer('stocks_on_hand');
            $table->integer('beginning_inv_qty');
            $table->integer('lead_time');
            $table->integer('min_order_qty');
            $table->integer('order_frequency');
            $table->integer('ending_inv_qty');
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
        Schema::dropIfExists('tbl_maininvs');
    }
}
