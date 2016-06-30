<?php

use Illuminate\Database\Seeder;

class PictureTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('picture_types')->insert([
            [
                'dir' => 'product',
                'name' => '商品',
            ],
            [
                'dir' => 'category',
                'name' => '类别',
            ],

        ]);
    }
}
