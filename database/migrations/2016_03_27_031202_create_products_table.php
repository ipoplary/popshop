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
            $table->string('name', 191);
            $table->string('sku', 20);
            $table->integer('category_id');
            $table->decimal('org_price', 8, 2);
            $table->decimal('dsc_price', 8, 2)->nullable();
            $table->integer('stock');
            $table->integer('sold')->nullable();
            $table->string('introduction', 191)->nullable();
            $table->text('description');
            $table->integer('icon_id');
            $table->string('banner', 191);
            $table->integer('sort')->nullable();
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
