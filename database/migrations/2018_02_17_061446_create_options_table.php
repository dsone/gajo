<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('private')->default(true);
            $table->boolean('colorblind')->default(false);
            $table->boolean('hideReleased')->default(true);
            $table->boolean('hideTBA')->default(true);
            $table->string('rss')->unique();
            $table->integer('user_id')->unsigned()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('options');
    }
}
