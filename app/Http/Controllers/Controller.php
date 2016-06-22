<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 组装json数据的数组
     * @param  integer $err   错误码
     * @param  string  $msg   信息
     * @param  mixed   $extra 数据
     * @return array          返回json数据的数组形式
     */
    protected function returnData($msg = '', $err = 0, $extra = null)
    {
        $returnArr = array(
            'err'   => $err,
            'msg'   => $msg,
            'extra' => $extra
        );

        return $returnArr;
    }
}
