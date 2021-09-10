<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblIncomingsuppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_incomingsupps', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_number');
            $table->string('supplier_name');
            $table->string('supplier_description');
            $table->string('category');
            $table->string('supply_name');
            $table->string('supply_description')->nullable();
            $table->string('unit');
            $table->float('net_price');
            $table->float('with_vat');
            $table->integer('quantity');
            $table->float('amount');

            // $table->string('col'); //required string
            // $table->string('col')->nullable(); //optional string
            // $table->string('col',25)->nullable(); //with required length of str

            // $table->integer('col'); //required number (whole number only)
            // $table->integer('col')->nullable(); //optional number (whole number only)
            // $table->integer('col',25)->nullable(); //with required length of number $table->double('net_price');


            // $table->float('col'); //required number (with decimals)
            // $table->float('col')->nullable(); //optional number  (with decimals)
            // $table->float('col',25)->nullable(); //with required length of number (with decimals)


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
        Schema::dropIfExists('tbl_incomingsupps');
    }
}
