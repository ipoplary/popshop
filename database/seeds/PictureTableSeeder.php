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
            ],
            [
                'type_id' => 1,
                'name' => 'test2.jpg',
                'path' => 'upload/img/product/test2.jpg',
            ],
            [
                'type_id' => 1,
                'name' => 'test3.jpg',
                'path' => 'upload/img/product/test3.jpg',
            ],
            [
                'type_id' => 1,
                'name' => 'test4.jpg',
                'path' => 'upload/img/product/test4.jpg',
            ],

        ]);
    }
}
