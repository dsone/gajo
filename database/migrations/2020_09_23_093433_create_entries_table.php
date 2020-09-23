<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('ident_1')->default('TBA');
            $table->string('ident_2')->default('TBA');
            $table->timestamp('release_at');
            $table->integer('visibility')->default(config('gajo.settings.list.visibility.private'));
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique([ 'ident_1', 'ident_2', 'type_id', 'user_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
