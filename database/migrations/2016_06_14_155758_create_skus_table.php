<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix')->unique();
            $table->integer('count');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('skus');
    }
}