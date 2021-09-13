<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOutgoingprodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_outgoingprods', function (Blueprint $table) {
            $table->id();
            $table->integer('category')->references('id')->on('tbl_prodcat');
            $table->integer('sub_category')->references('id')->on('tbl_prodsubcat');
            $table->integer('product_name')->references('id')->on('tbl_prodlist');
            $table->float('quantity');
            $table->integer('requesting_branch')->references('id')->on('tbl_branches');
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
        Schema::dropIfExists('tbl_outgoingprods');
    }
}
