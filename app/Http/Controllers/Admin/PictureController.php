<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\PictureType;
use DB;
use Image;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        // 图片列表，倒序排列
        $pictures = Picture::orderBy('id', 'desc')->get(['id', 'name', 'path', 'type_id']);

        // 获取图片类型
        foreach($pictures as $v) {
            $v->pictureTypeName = $v->pictureType->name;
            $v->pictureTypeDir = $v->pictureType->dir;
            $v->url = asset($v->path);
            unset($v->pictureType);
        }
        unset($v);

        // 图片数据转为json数据
        $data['pictures'] = json_encode($pictures->toArray());

        return view('admin.picture.index', $data);
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

    public function postUpload(Request $request)
    {
        // 存储图片数据的数组
        $pictureList = [];

        // 事务
        $data = DB::transaction(function () use($request) {

            //判断请求中是否包含name=picture的上传文件
            if(!$request->hasFile('files')){
                exit('上传文件为空！');
            }
            $files = $request->file('files');

            // 获取传过来的图片类别，并将其作为目录名称
            $pictureTypeId = (int)$request->input('type');
            $pictureDir = PictureType::find($pictureTypeId)->dir;

            foreach($files as $file) {
                //判断文件上传过程中是否出错
                if(! $file->isValid())
                    return response()->json($this->returnData('文件上传失败！'));

                // 重命名图片
                $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
                $filePath = 'upload/img/'.$pictureDir.'/'.$newFileName;

                // 上传图片
                $image = Image::make($file);

                if(! $image->save($filePath))
                    return response()->json($this->returnData('文件保存失败！'));

                // 获取图片md5并在数据库中查找，若找到数据，则将图片删除，用已存在的返回
                $md5 = md5_file($filePath);
                $isPicture = Picture::where(['md5' => $md5])->get(['id', 'name', 'path', 'type_id'])->first();
                if($isPicture) {

                    $pictureList[] = $isPicture->toArray();

                } else {

                    // 保存图片数据到数据库
                    $picture = new Picture;
                    $insertArr = [
                        'type_id' => $pictureTypeId,
                        'name' => $newFileName,
                        'path' => $filePath,
                        'md5'  => $md5,
                    ];

                    $pictureId = (int)$picture->insertGetId($insertArr);

                    $pictureList[] = array_merge(['id' => $pictureId, 'url' => asset($filePath)], $insertArr);


                    if(! $pictureId)
                        return false;
                }

            }
            return $pictureList;
        });

        if($data == false)
            return response()->json($this->returnData('上传成功，但添加入数据库失败！'));
        else
            return response()->json($this->returnData('上传成功！', 1, $data));
    }
}
