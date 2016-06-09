<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => '服装',
                'parent' => 0,
                'sort' => 1,
            ],
            [
                'name' => '食品',
                'parent' => 0,
                'sort' => 2,
            ],
            [
                'name' => '家具',
                'parent' => 0,
                'sort' => 3,
            ],
            [
                'name' => '3C类',
                'parent' => 0,
                'sort' => 4,
            ],
            [
                'name' => '衬衫',
                'parent' => 1,
                'sort' => 1,
            ],
            [
                'name' => '毛衣',
                'parent' => 1,
                'sort' => 2,
            ],
            [
                'name' => '长裤',
                'parent' => 1,
                'sort' => 3,
            ],
            [
                'name' => '蔬菜',
                'parent' => 2,
                'sort' => 1,
            ],
            [
                'name' => '肉类',
                'parent' => 2,
                'sort' => 2,
            ],
            [
                'name' => '杂粮',
                'parent' => 2,
                'sort' => 3,
            ],
            [
                'name' => '调味品',
                'parent' => 2,
                'sort' => 4,
            ],
            [
                'name' => '干货',
                'parent' => 2,
                'sort' => 5,
            ],
            [
                'name' => '沙发',
                'parent' => 3,
                'sort' => 1,
            ],
            [
                'name' => '桌子',
                'parent' => 3,
                'sort' => 2,
            ],
            [
                'name' => '椅子',
                'parent' => 3,
                'sort' => 3,
            ],
            [
                'name' => '衣柜',
                'parent' => 3,
                'sort' => 4,
            ],
            [
                'name' => '手机',
                'parent' => 4,
                'sort' => 1,
            ],
            [
                'name' => '电脑',
                'parent' => 4,
                'sort' => 2,
            ],
            [
                'name' => '平板电脑',
                'parent' => 4,
                'sort' => 3,
            ],
        ]);
    }
}
