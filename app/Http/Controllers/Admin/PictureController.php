<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\PictureType;
use DB;
use Illuminate\Http\Request;
use Image;

class PictureController extends Controller
{
    // 首页加载图片数
    private $pageNum;

    public function __construct()
    {
        parent::__construct();
        $this->pageNum = 20;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        // 图片列表，倒序排列
        $pictures = Picture::orderBy('id', 'desc')->take($this->pageNum)->get(['id', 'name', 'path', 'type_id']);

        // 获取图片类型
        foreach ($pictures as $v) {
            $v->pictureTypeName = $v->getPictureType->name;
            $v->pictureTypeDir = $v->getPictureType->dir;
            $v->url = asset($v->path);
            unset($v->getPictureType);
        }
        unset($v);

        // 图片数据转为json数据
        $data['pictures'] = $pictures->toJson();

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function postDestroy($id)
    {
        $id = (int) $id;

        $picture = Picture::find($id);

        // 图片文件路径
        $path = $picture->path;

        $result = $picture->destroy($id);

        if ($result == 1) {
            // 数据库删除成功后，删除文件
            $unlinkResult = unlink($path);

            if (!$unlinkResult) {
                return response()->json($this->returnData('数据库删除成功，文件删除失败！'));
            }

            return response()->json($this->returnData('删除成功！', 1));
        }

        return response()->json($this->returnData('删除失败！'));
    }

    public function postUpload(Request $request)
    {

        // 事务
        $data = DB::transaction(function () use ($request) {

            //判断请求中是否包含name=picture的上传文件
            if (!$request->hasFile('files')) {
                exit('上传文件为空！');
            }
            $files = $request->file('files');

            // 获取传过来的图片类别，并将其作为目录名称
            $pictureTypeId = (int) $request->input('type');
            $pictureDir = PictureType::find($pictureTypeId)->dir;

            // 存储图片数据的数组
            $pictureList = [];

            foreach ($files as $k => $file) {
                //判断文件上传过程中是否出错
                if (!$file->isValid()) {
                    return response()->json($this->returnData('文件上传失败！'));
                }

                // 重命名图片
                $newFileName = uniqid(date('ymd').$k).'.'.$file->getClientOriginalExtension();
                $filePath = 'upload/img/'.$pictureDir.'/'.$newFileName;

                // 上传图片
                $image = Image::make($file);

                if (!$image->save($filePath)) {
                    return response()->json($this->returnData('文件保存失败！'));
                }

                // 获取图片md5并在数据库中查找，若找到数据，则将图片删除，用已存在的返回
                $md5 = md5_file($filePath);
                $isPicture = Picture::where(['md5' => $md5])->get(['id', 'name', 'path', 'type_id'])->first();
                if ($isPicture) {
                    // 删除图片
                    unlink($filePath);
                    $pictureList[] = array_merge($isPicture->toArray(), ['exist' => 1, 'url' => asset($isPicture->path)]);
                } else {

                    // 保存图片数据到数据库
                    $picture = new Picture();
                    $insertArr = [
                        'type_id' => $pictureTypeId,
                        'name'    => $newFileName,
                        'path'    => $filePath,
                        'md5'     => $md5,
                    ];

                    $pictureId = (int) $picture->insertGetId($insertArr);

                    $pictureList[] = [
                        'id'      => $pictureId,
                        'type_id' => $pictureTypeId,
                        'name'    => $newFileName,
                        'path'    => $filePath,
                        'url'     => asset($filePath),
                    ];

                    if (!$pictureId) {
                        return false;
                    }
                }
            }

            return $pictureList;
        });

        if ($data === false) {
            return response()->json($this->returnData('上传成功，但添加入数据库失败！'));
        } else {
            return response()->json($this->returnData('上传成功！', 1, $data));
        }
    }

    public function postList(Request $request)
    {
        $typeId = (int) $request->input('pictureType');
        $limit = $request->input('limit') ? (int) $request->input('limit') : $this->pageNum;
        $offset = $request->input('offset') ? (int) $request->input('offset') : 0;

        $whereArr = [];
        if ($typeId > 0) {
            $whereArr = ['type_id' => $typeId];
        }

        $pictures = Picture::orderBy('id', 'desc')->offset($offset)->limit($limit)->where($whereArr)->get(['id', 'name', 'path', 'type_id']);

        // 获取图片类型
        foreach ($pictures as $v) {
            $v->pictureTypeName = $v->getPictureType->name;
            $v->pictureTypeDir = $v->getPictureType->dir;
            $v->url = asset($v->path);
            unset($v->getPictureType);
        }
        unset($v);

        return response()->json($this->returnData('上传成功！', 1, $pictures));
    }
}
