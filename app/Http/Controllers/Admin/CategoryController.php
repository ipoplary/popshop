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
    public function getIndex($category = '-1')
    {
        $data['categoryId'] = $category;

        $data['parents'] = $this->_getParentCategories();

        // 获取分页信息
        if($category === '-1'){
            $cate = Category::where('parent', '!=', 0)->orderBy('parent')->orderBy('sort')->paginate($this->pageNum);
        } else {
            $this->pageNum = 0;
            $cate = Category::where('parent', $category)->orderBy('sort')->paginate($this->pageNum);
        }

        // 关联父类信息
        foreach($cate->getCollection() as &$v) {
            $v->parentName = $v->parentCate->name;
        }

        $data['cate'] = $cate;

        return view('admin.category.index', $data);
    }

    private function _getParentCategories()
    {
        // 父类别
        $parents = Category::where('parent', 0)
                    ->get()
                    ->toArray();

        $noParent = [
            '0' => [
                'id' => '-1',
                'name' => '无父类别',
                'name_all' => '所有'
            ]
        ];

        return array_merge($noParent, $parents);
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
        $category = new Category;

        $category->name   = $request->input('name');
        $category->parent = $request->input('parent');
        $category->sort   = (int)Category::where('parent', $category->parent)->max('sort') + 1;

        $result = $category->save();

        if($result)
            return response()->json($this->returnData('添加成功', 1));

        else
            return response()->json($this->returnData('添加失败'));
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
            return response()->json($this->returnData('找不到相关的类别信息'));

        if( $request->input('name') ) {
            $category->name   = $request->input('name');
        }

        if( $request->input('parent') ) {
            $category->parent = $request->input('parent');
        }

        $result = $category->save();

        if($result)
            return response()->json($this->returnData('更新成功', 1));

        else
            return response()->json($this->returnData('更新失败'));

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
            return response()->json($this->returnData('删除成功', 1));

        else
            return response()->json($this->returnData('删除失败'));
    }

    public function postSort(Request $request)
    {
        $sortArr = $request->input('sort');
        $i = 1;
        foreach($sortArr as $v) {
            $category[$i] = Category::find($v);
            $category[$i]->sort = $i;
            $category[$i]->save();
            $i++;
        }

        return response()->json($this->returnData('排序成功！', 1));
    }
}
