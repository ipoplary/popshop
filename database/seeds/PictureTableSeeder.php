<?php

use Illuminate\Database\Seeder;

class PictureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pictures')->insert([
            [
                'type_id' => 1,
                'name' => 'test1.jpg',
                'path' => 'upload/img/product/test1.jpg',
                'md5' => '3ce156bd1a733c7365d39c9e642261e9',
            ],
            [
                'type_id' => 1,
                'name' => 'test2.jpg',
                'path' => 'upload/img/product/test2.jpg',
                'md5' => '8d0be06bde08fb4619018b460ce34f1a',
            ],
            [
                'type_id' => 1,
                'name' => 'test3.jpg',
                'path' => 'upload/img/product/test3.jpg',
                'md5' => '024316d38f56e6766056478e64b7ca9c',
            ],
            [
                'type_id' => 1,
                'name' => 'test4.jpg',
                'path' => 'upload/img/product/test4.jpg',
                'md5' => 'c16ded2bb765c805714773238b47af81',
            ],

        ]);
    }
}
