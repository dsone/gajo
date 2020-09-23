<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ident_1');
            $table->string('ident_2');
            $table->integer('sort')->default(1);  // sort order, the higher the weight, the more at the bottom it is
            $table->integer('display')->default(1);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique([ 'name', 'user_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
