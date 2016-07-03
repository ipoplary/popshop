<?php
namespace App\Services;

use App\Models\PictureType;

class PictureService
{

    /**
     * 获取图片类别
     * @return object 图片类别collection
     */
    public function pictureType()
    {
        return PictureType::get();
    }
}