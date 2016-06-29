<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SkuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skus')->insert([
            'prefix' => 'SKU',
            'count' => 5,
        ]);
    }
}