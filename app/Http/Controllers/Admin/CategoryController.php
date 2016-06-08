<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Category;

class CategoryController extends Controller
{

    private $pageNum;

    public function __construct()
    {
        $this->pageNum = 10;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        // 父类别
        $parents = Category::where('parent', 0)
                    ->get()
                    ->toArray();

        $noParent = array(
            '0' => array(
                'id' => 0,
                'name' => '无父类别'
            )
        );

        // 获取分页信息
        $cate = Category::where('parent', 0)->forPage(1,$this->pageNum)->paginate($this->pageNum);


        // 类别列表数据
        $categories = $cate->getCollection()->keyBy('id');

        // 关联父类信息
        foreach($categories as &$v) {
            $v = $v->parentCate;
        }


        $data['parents'] = array_merge($noParent, $parents);

        $data['cate'] = $cate;

        return view('admin.category.index', $data);
        return view('admin.category.index');
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
    public function postStore(Request $request)
    {
        $name   = $request->input('name');
        $parent = $request->input('parent');
        $sort   = $request->input('sort');

        $category = new Category;

        $category->name   = $name;
        $category->parent = $parent;
        $category->sort   = $sort;

        $result = $category->save();

        if($result)
            return response()->json($this->_returnData(1, '添加成功'));

        else
            return response()->json($this->_returnData(-1, '添加失败'));
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
    public function postUpdate(Request $request, $id)
    {
        $id = (int)$id;

        $category = Category::find($id);
        if( ! $category )
            return response()->json($this->_returnData(1, '找不到相关的类别信息'));

        if($request->input('name')) {
            $category->name   = $name;
        }

        if($request->input('parent')) {
            $category->parent = $parent;
        }

        if($request->input('sort')) {
            $category->sort   = $sort;
        }

        $result = $category->save();

        if($result)
            return response()->json($this->_returnData(1, '更新成功'));

        else
            return response()->json($this->_returnData(-1, '更新失败'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDestroy($id)
    {
        $id = (int)$id;

        $category = Category::find($id);
        $result = $category->delete();

        if($result)
            return response()->json($this->_returnData(1, '删除成功'));

        else
            return response()->json($this->_returnData(-1, '删除失败'));
    }
}
