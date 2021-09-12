<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProdlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_prodlists', function (Blueprint $table) {
            $table->id();
            $table->string('category')->references('id')->on('tbl_prodcat');
            $table->string('sub_category')->references('id')->on('tbl_prodsubcat');
            $table->string('product_name');
            $table->string('description')->nullable();
            $table->float('price');
            $table->integer('quantity');
            $table->date('exp_date')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('tbl_prodlists');
    }
}
