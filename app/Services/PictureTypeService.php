<?php

namespace App\Services;

use App\Models\PictureType;

class PictureTypeService
{
    /**
     * 获取图片类别.
     *
     * @return array 图片类别collection
     */
    public function pictureType()
    {
        $pictureTypes = PictureType::get()->keyBy('id');

        return $pictureTypes;
    }
}
