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
        $data['pictures'] = json_encode($pictures->keyBy('id')->toArray());

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
        echo '<pre>';
        // 事务
        DB::transaction(function () use($request, $pictureList) {
            //判断请求中是否包含name=picture的上传文件
            if(!$request->hasFile('files')){
                exit('上传文件为空！');
            }
            $files = $request->file('files');
            var_dump($_FILES);
            var_dump($files);
            // 获取传过来的图片类别，并将其作为目录名称
            $pictureTypeId = (int)$request->input('type');
            $pictureDir = PictureType::find($pictureTypeId)->dir;

            foreach($files as $file) {
                //判断文件上传过程中是否出错
                if(! $file->isValid())
                    return response()->json($this->returnData('文件上传失败！'));

                var_dump(get_class_methods($file));echo '<br/>';echo '<br/>';
                var_dump(md5_file($file->getPathname()));echo '<br/>';echo '<br/>';
                // 重命名图片
                $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
                $filePath = 'upload/img/'.$pictureDir.'/'.$newFileName;

                // 上传图片
                $image  = Image::make($file);
                var_dump($image);echo '<br/>';echo '<br/>';
                if(! $image->save($filePath))
                    return response()->json($this->returnData('文件保存失败！'));

                var_dump(md5_file(public_path($filePath)));echo '<br/>';echo '<br/>';
                var_dump(md5_file(public_path('upload/img/category/8404076e2d84cfc19c716799542d3ade.jpg')));
                dd();
                // 保存图片数据到数据库
                $picture = new Picture;
                $insertArr = [
                    'type_id' => $pictureTypeId,
                    'name' => $newFileName,
                    'path' => $filePath,
                    'md5'  => md5_file($filePath),
                ];
                $pictureList[] = $insertArr;
                $pictureId = (string)$picture->insertGetId($insertArr);
                if(! $pictureId)
                    return response()->json($this->returnData('上传成功，但添加入数据库失败！'));

            }

        });

        // 成功
        return response()->json($this->returnData('上传成功！', 1, $pictureList));
    }
}
