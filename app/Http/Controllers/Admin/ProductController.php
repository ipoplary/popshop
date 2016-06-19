<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
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
    public function getIndex(Request $request, $categoryId = '0')
    {
        $data['categoryId'] = (int) $categoryId;

        $data['products'] = new Product();

        $data['parents'] = Category::where('parent_id', 0)->get();

        // 是否需要排序操作
        $data['sort'] = 0;

        // 获取特定类别的商品，当类别为确定的子类别时，不分页（排序操作），类别为父类别或者无确定类别时进行分页
        if ($data['categoryId'] !== 0) {
            // 有类别参数
            $category = Category::find($data['categoryId']);

            if ($category->parent == 0) {
                // 类别为父类别时，获取父类别的所有子类别下的商品
                $chidren = $category->children->keyBy('id');

                $whereIn = $chidren->keys()->toArray();

                $data['products'] = $data['products']->whereIn('category', $whereIn)->paginate($this->pageNum);

                foreach ($data['products']->items() as &$v) {
                    $v->categoryName = $chidren[$v->category]->name;
                }
                unset($v);
            } else {
                // 类别为子类别时，获取该类别的商品，需要进行排序，此时不分页
                $data['sort'] = 1;
                $data['products'] = $data['products']->where('category', $category->id)->paginate(0);

                foreach ($data['products']->items() as &$v) {
                    $v->categoryName = $category->name;
                }
                unset($v);
            }
        } else {
            $data['products'] = $data['products']->paginate($this->pageNum);

            foreach ($data['products']->items() as &$v) {
                $v->categoryName = $v->Category->name;
            }
        }

        return view('admin.product.index', $data);
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
    public function destroy($id)
    {
        //
    }
}
