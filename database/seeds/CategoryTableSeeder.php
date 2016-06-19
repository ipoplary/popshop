<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => '服装',
                'parent_id' => 0,
                'sort' => 1,
            ],
            [
                'name' => '食品',
                'parent_id' => 0,
                'sort' => 2,
            ],
            [
                'name' => '家具',
                'parent_id' => 0,
                'sort' => 3,
            ],
            [
                'name' => '3C类',
                'parent_id' => 0,
                'sort' => 4,
            ],
            [
                'name' => '衬衫',
                'parent_id' => 1,
                'sort' => 1,
            ],
            [
                'name' => '毛衣',
                'parent_id' => 1,
                'sort' => 2,
            ],
            [
                'name' => '长裤',
                'parent_id' => 1,
                'sort' => 3,
            ],
            [
                'name' => '蔬菜',
                'parent_id' => 2,
                'sort' => 1,
            ],
            [
                'name' => '肉类',
                'parent_id' => 2,
                'sort' => 2,
            ],
            [
                'name' => '杂粮',
                'parent_id' => 2,
                'sort' => 3,
            ],
            [
                'name' => '调味品',
                'parent_id' => 2,
                'sort' => 4,
            ],
            [
                'name' => '干货',
                'parent_id' => 2,
                'sort' => 5,
            ],
            [
                'name' => '沙发',
                'parent_id' => 3,
                'sort' => 1,
            ],
            [
                'name' => '桌子',
                'parent_id' => 3,
                'sort' => 2,
            ],
            [
                'name' => '椅子',
                'parent_id' => 3,
                'sort' => 3,
            ],
            [
                'name' => '衣柜',
                'parent_id' => 3,
                'sort' => 4,
            ],
            [
                'name' => '手机',
                'parent_id' => 4,
                'sort' => 1,
            ],
            [
                'name' => '电脑',
                'parent_id' => 4,
                'sort' => 2,
            ],
            [
                'name' => '平板电脑',
                'parent_id' => 4,
                'sort' => 3,
            ],
        ]);
    }
}
