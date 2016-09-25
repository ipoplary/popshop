<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    /**
     * 组装json数据的数组.
     *
     * @param int    $err   错误码
     * @param string $msg   信息
     * @param mixed  $extra 数据
     *
     * @return array 返回json数据的数组形式
     */
    protected function returnData($msg = '', $err = 0, $extra = null)
    {
        $returnArr = [
            'err'   => $err,
            'msg'   => $msg,
            'extra' => $extra,
        ];

        return $returnArr;
    }
}
