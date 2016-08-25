<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Services\PictureService;
use DB;

class ProductController extends Controller
{
    private $pageNum;
    private $prefix;

    public function __construct()
    {
        $this->pageNum = 10;
        $this->prefix = 'SKU';
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $data['categoryId'] = (int)$request->input('category', '0');
        $data['snapshot']   = (int)$request->input('snapshot', '0');

        // 商品非快照
        $data['products'] = new Product();

        if ($data['snapshot'] === 0)
            $data['products'] = $data['products']->where('snapshot', 0);

        $data['parents'] = Category::where('parent_id', 0)->get();

        // 是否需要排序操作
        $data['sort'] = 0;

        // 获取特定类别的商品，当类别为确定的子类别时，不分页（排序操作），类别为父类别或者无确定类别时进行分页
        if ($data['categoryId'] !== 0) {
            // 有类别参数
            $category = Category::find($data['categoryId']);
            $data['category'] = $category;

            if ($category->parent_id == 0) {
                // 类别为父类别时，获取父类别的所有子类别下的商品
                $data['parentId'] = $data['categoryId'];

                $chidren = $category->getChildren->keyBy('id');

                $whereIn = $chidren->keys()->toArray();

                $data['products'] = $data['products']->whereIn('category_id', $whereIn)->paginate($this->pageNum);

                foreach ($data['products']->items() as &$v) {
                    $v->categoryName = $chidren[$v->category_id]->name;
                }
                unset($v);
            } else {
                // 类别为子类别时，获取该类别的商品，需要进行排序，此时不分页
                $data['parentId'] = $category->parent_id;
                $data['childId']  = $data['categoryId'];

                $data['sort'] = 1;
                $data['products'] = $data['products']->where('category_id', $category->id)->orderBy('sort')->paginate(0);

                foreach ($data['products']->items() as &$v) {
                    $v->categoryName = $category->name;
                }
                unset($v);
            }
        } else {
            // 无类别参数，获取所有商品
            $data['products'] = $data['products']->paginate($this->pageNum);

            foreach ($data['products']->items() as &$v) {

                $v->categoryName = $v->getCategory->name;
            }
        }

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        // 获取sku
        $sku = SKU::where('prefix', $this->prefix)->first();

        $data['sku'] = $this->prefix . sprintf('%05s', (string)$sku->count);

        // 所有父类别
        $data['parents'] = Category::where('parent_id', 0)->get();
        $data['type'] = 'add';

        return view('admin.product.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        // 验证请求的信息
        $this->validateInfo($request);

        // 若sku已存在，添加失败
        $isSkuExsist = Product::where('sku', $request->input('sku'))->count();
        if($isSkuExsist > 0)
            return response()->json($this->returnData('添加商品失败，该SKU已存在！'));

        // 事务
        DB::transaction(function() use($request) {
            // banner数组转为json
            $banner = json_encode($request->input('banner'));

            $product = new Product;
            $product->name         = $request->input('name');
            $product->sku          = $request->input('sku');
            $product->category_id  = $request->input('category_id');
            $product->org_price    = $request->input('org_price');
            $product->dsc_price    = $request->input('dsc_price');
            $product->stock        = $request->input('stock');
            $product->introduction = $request->input('introduction');
            $product->description  = htmlentities($request->input('description'));
            $product->icon_id      = $request->input('icon_id');
            $product->banner       = $banner;

            // 商品排序默认为0，显示在最上
            $product->sort         = 0;

            $result = $product->save();

            // 数据库中sku值+1
            $sku = SKU::where('prefix', $this->prefix)->first();
            $sku->count += 1;
            $sku->save();

        });

        return response()->json($this->returnData('添加商品成功！', 1));
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
    public function getEdit($id)
    {
        // 商品详细信息
        $data['product'] = Product::find($id);

        // 父类别
        $data['product']->parentCategory = Category::find($data['product']->category_id)->parent_id;

        // 描述字段格式化
        $data['product']->description = html_entity_decode($data['product']->description);

        // 图标及banner处理
        $data['product']->iconDetail = json_encode(PictureService::detailBatch([$data['product']->icon_id], ['id', 'name', 'url']));
        $data['product']->bannerDetail = json_encode(PictureService::detailBatch(json_decode($data['product']->banner), ['id', 'name', 'url']));

        // 所有父类别
        $data['parents'] = Category::where('parent_id', 0)->get();
        $data['type'] = 'edit';

        return view('admin.product.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $id)
    {
        // 更新商品：将原有的商品存为快照，重新建一个商品
        // 事务
        DB::transaction(function() use($request, $id){
            $oldProduct = Product::find($id);
            if (! $oldProduct)
                return response()->json($this->returnData('找不到商品！'));

            $oldProduct->snapshot = 1;
            $oldProduct->save();

            $product = new Product;
            $product->name         = $request->input('name');
            $product->sku          = $request->input('sku');
            $product->category_id  = $request->input('category_id');
            $product->org_price    = $request->input('org_price');
            $product->dsc_price    = $request->input('dsc_price');
            $product->stock        = $request->input('stock');
            $product->introduction = $request->input('introduction');
            $product->description  = $request->input('description');
            $product->icon_id      = $request->input('icon_id');
            $product->banner       = $request->input('banner');

            $result = $product->save();

            // 数据库中sku值+1
            $sku = SKU::where('prefix', $this->prefix)->get();
            $sku->count += 1;
            $sku->save();

            return response()->json($this->returnData('修改商品成功，原有商品改为快照！', 1));
        });
        return response()->json($this->returnData('修改商品失败！'));
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
        // 将商品快照值设为1
        $product = Product::find($id);

        if ($product === null)
            return response()->json($this->returnData('删除失败，没有找到该商品！'));

        $product->snapshot = 1;
        $result = $product->save();
        if (! $result)
            return response()->json($this->returnData('删除失败！'));
        else
            return response()->json($this->returnData('删除成功！', 1));
    }

    /**
     * 排序操作
     * @param  Request $request 请求数据
     * @return json             排序结果
     */
    public function postSort(Request $request)
    {
        $sortArr = $request->input('sort');
        $i = 1;
        foreach ($sortArr as $v) {
            $product[$i] = Product::find($v);
            $product[$i]->sort = $i;
            $product[$i]->save();
            ++$i;
        }

        return response()->json($this->returnData('排序成功！', 1));
    }

    /**
     * 验证输入的产品信息
     * @param  Request $request 请求数据
     * @return void
     */
    private function validateInfo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'sku'=> 'required',
            'category_id'=> 'required|integer',
            'org_price'=> 'numeric|min:0',
            'dsc_price'=> 'required|numeric|min:0',
            'stock'=> 'required|integer|min:0',
            'introduction'=> 'required|string',
            'description'=> 'required',
            'icon_id'=> 'required|integer',
            'banner'=> 'required',
        ]);
        return;
    }
}
