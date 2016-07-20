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
                'md5' => '89904a73a135e2b7643bb3362d3e2686',
            ],
            [
                'type_id' => 1,
                'name' => 'test2.jpg',
                'path' => 'upload/img/product/test2.jpg',
                'md5' => '54892744ed1de8c76b9edaef2d8caacf',
            ],
            [
                'type_id' => 1,
                'name' => 'test3.jpg',
                'path' => 'upload/img/product/test3.jpg',
                'md5' => 'bf6415847738f771168a44a4d4caf9e1',
            ],
            [
                'type_id' => 1,
                'name' => 'test4.jpg',
                'path' => 'upload/img/product/test4.jpg',
                'md5' => '4279a4907d61e5d937bbc66fc21cef0f',
            ],

        ]);
    }
}
