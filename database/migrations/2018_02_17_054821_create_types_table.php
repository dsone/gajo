<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ident_1');
            $table->string('ident_2');
            $table->integer('sort')->default(1);  // sort order, the higher the weight, the more at the bottom it is
            $table->integer('display')->default(1);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique(['name', 'user_id']);
        });

        Schema::create('release_type', function (Blueprint $table) {
            $table->integer('release_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->primary(['release_id', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('types');
        Schema::dropIfExists('release_type');
    }
}
