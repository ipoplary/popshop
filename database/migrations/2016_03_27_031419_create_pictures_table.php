<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id');
            $table->string('name', 191)->unique()->nullable();
            $table->string('path', 191)->unique();
            $table->string('md5', 191)->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('images');
    }
}
