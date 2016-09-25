<?php

use Illuminate\Database\Seeder;

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
            'count'  => 5,
        ]);
    }
}
