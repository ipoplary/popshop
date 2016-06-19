<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('sku');
            $table->integer('category_id');
            $table->decimal('org_price', 8, 2);
            $table->decimal('dsc_price', 8, 2)->nullable();
            $table->integer('stock');
            $table->string('introduction')->nullable();
            $table->text('description');
            $table->integer('icon_id');
            $table->string('banner');
            $table->integer('snapshot')->default(0);
            $table->nullableTimestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('products');
    }
}
