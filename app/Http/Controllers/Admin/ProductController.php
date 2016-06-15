<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex($categoryId = '0')
    {

        $data['categoryId'] = (int)$categoryId;
        $category = Category::find($data['categoryId']);

        $data['products'] = new Product;

        // 类别分为父类别和子类别
        if($category->parent == 0) {
            $whereIn = $category->children->keyBy('id')->keys()->toArray();

            $data['products'] = $data['products']->whereIn('category', [5]);

            dd($data['products']->get());
        }

        // 获取分页信息
        if($parent < 0){
            $cate = Product::orderBy('category')->paginate($this->pageNum);
        } else {
            $this->pageNum = 0;
            $cate = Product::where('parent', $parent)->paginate($this->pageNum);
        }

        // 关联父类信息
        if($parent > 0) {
            foreach($cate->getCollection() as &$v) {
                $v->parentName = $v->parentCate->name;
            }
        }

        $data['cate'] = $cate;

        return view('admin.category.index', $data);
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
}
