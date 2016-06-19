<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => '白色衬衫',
                'sku' => 'S00001',
                'category_id' => 5,
                'org_price' => 59.90,
                'dsc_price' => 49.90,
                'stock' => 100,
                'introduction' => '白色衬衫',
                'description' => '<p>白色衬衫</p><p>纯白色</p>',
                'icon_id' => 1,
                'banner' => '2,3',
                'snapshot' => 0,
            ],
            [
                'name' => '黑色长裤',
                'sku' => 'S00002',
                'category_id' => 7,
                'org_price' => 99.90,
                'dsc_price' => 79.90,
                'stock' => 200,
                'introduction' => '黑色长裤',
                'description' => '<p>黑色长裤</p><p>修身</p>',
                'icon_id' => 4,
                'banner' => '5,6,7',
                'snapshot' => 0,
            ],
            [
                'name' => '米色长裤',
                'sku' => 'S00003',
                'category_id' => 7,
                'org_price' => 109.90,
                'dsc_price' => 99.90,
                'stock' => 150,
                'introduction' => '米色长裤',
                'description' => '<p>米色长裤</p><p>普通长裤</p>',
                'icon_id' => 8,
                'banner' => '9,10',
                'snapshot' => 0,
            ],
        ]);
    }
}
