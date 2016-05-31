<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('sku');
            $table->integer('category');
            $table->decimal('org_price', 8, 2);
            $table->decimal('dsc_price', 8, 2)->nullable();
            $table->integer('stock');
            $table->string('introduction');
            $table->text('description');
            $table->integer('icon');
            $table->string('banner');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
