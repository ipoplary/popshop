<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use App\Models\Picture;
use App\Models\PictureType;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postPicture(Request $request)
    {
        //判断请求中是否包含name=picture的上传文件
        if(!$request->hasFile('picture')){
            exit('上传文件为空！');
        }
        $file = $request->file('picture');

        var_dump($file->getPath());
        var_dump(md5_file($file->getRealPath()));

        var_dump(md5_file($file));
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }

        // 获取传过来的图片类别，并将其作为目录名称
        $pictureTypeId = (int)$request->input('dir');
        $pictureType = PictureType::find($pictureTypeId);

        // 重命名图片
        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $filePath = 'upload/img/'.$pictureType->dir.'/'.$newFileName;

        if(! is_dir('upload/img/'.$pictureType->dir))
            mkdir('upload/img/'.$pictureType->dir, '0777');

        // 上传图片
        $image  = Image::make($filePath);

        if(! $image->save($filePath))
            return response()->json($this->returnData('上传失败！'));
        var_dump(public_path($filePath));dd();
        dd(md5_file(public_path($filePath)));
        // 保存图片数据到数据库
        $picture = new Picture;
        $insertArr = [
            'type_id' => $pictureTypeId,
            'name' => $newFileName,
            'path' => $filePath,
            'md5'  => md5_file($filePath),
        ];
        $pictureId = (string)$picture->insertGetId($insertArr);

        // 保存结果处理
        if($pictureId) {
            $extra = [
                'url' => asset($filePath),
                'picureId' => $pictureId
            ];
            return response()->json($this->returnData('上传成功！', 1, $extra));
        } else {
            return response()->json($this->returnData('保存失败！'));
        }
    }
}
