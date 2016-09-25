<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * 获取父类别.
     *
     * @return object 父类别
     */
    public function parentCategory()
    {
        $parentCategorys = Category::where('parent_id', 0)->get()->keyBy('id');

        return $parentCategorys;
    }
}
