<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix', 10)->unique();
            $table->integer('count');
            $table->softDeletes();
            $table->nullableTimestamps();
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
