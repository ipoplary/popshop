<?php

namespace App\Services;

use App\Models\Picture;

class PictureService
{
    /**
     * 获取指定图片数据.
     *
     * @param int   $id    图片ID
     * @param array $field 返回的字段，默认返回全部
     *
     * @return array $picture  图片数据
     */
    public static function detail($id, $field = [])
    {
        $picture = Picture::find($id);
        $picture->url = asset($picture->path);

        if ((bool) $field) {
            $pictureDetail = [];
            foreach ($field as $v) {
                $pictureDetail[$v] = $picture->$v;
            }
        } else {
            $pictureDetail = $picture->toArray();
        }

        return $pictureDetail;
    }

    /**
     * 批量获取指定图片数据.
     *
     * @param array $ids   图片ID数组
     * @param array $field 返回的字段，默认返回全部
     *
     * @return array $picture  图片数据
     */
    public static function detailBatch($ids, $field = [])
    {
        $picturesDetail = [];

        if (!is_array($ids) || empty($ids)) {
            return $picturesDetail;
        }

        foreach ($ids as $v) {
            $picturesDetail[] = self::detail($v, $field);
        }

        return $picturesDetail;
    }
}
