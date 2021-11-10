<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('inventories' meaning crecreate daw ung table sa database
        Schema::create('inventories', function (Blueprint $table) {
            $table->id(); //default dont change this  
            $table->string('column1')->nullable(); 
            $table->string('column2')->nullable(); 
            $table->string('column3')->nullable(); 
            $table->string('column4')->nullable(); 
            $table->integer('int1')->nullable();
            $table->integer('int2')->nullable();
            $table->float('dec1')->nullable();
            $table->float('dec2')->nullable(); 
            // so ang table mo na gagawin is inventories
            // tas lahat ng column yaang ginawa mo.
            // after mo ma input lahat. save mo ctrl+s
            // pag naka save na wala pa sya sa database natin. 
            // type mo sa terminal mo 
            // php artisan migrate:fresh para drop nya ung mga tables mo then create new table
            // kasama ung migration file na ginawa mo.
            // try mo na ayan lang po? or may -m parin po?
            //  -m is create new migration. ndi nmn tayo gagawa e 
            $table->timestamps();//default dont change this
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
