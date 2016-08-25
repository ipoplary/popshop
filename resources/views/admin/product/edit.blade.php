@extends('admin.layout')

@section('title', 'Product')

@section('app', 'product')

{{-- 注入类别服务类 --}}
@if(! isset($categoryService))
    @inject('categoryService', 'App\Services\CategoryService')
@endif

@section('content')

    <div class="row" id="app">
        <div class="col-md-12">
            <div class="form-horizontal">
                <fieldset>
                    <div>
                        <legend class="">添加商品</legend>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品名</label>
                        <div class="controls col-sm-4">
                            <input type="text" class="form-control" v-model="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">SKU</label>
                        <div class="controls col-sm-4">
                            <input type="text" class="form-control" disabled="disabled" v-model="sku">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">类别</label>
                        <div class="controls col-sm-2">
                            <select class="form-control input-xlarge" v-model="parentCategory">
                                @foreach($categoryService->parentCategory() as $parentCategory):
                                    <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="controls col-sm-2">
                            <select class="form-control input-xlarge" v-model="category">
                                <option v-for="child in showChildren" value="@{{ child['id'] }}">@{{ child['name'] }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">原价格</label>
                        <div class="controls col-sm-1">
                            <input type="text" class="form-control" v-model="originalPrice">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">优惠价格</label>
                        <div class="controls col-sm-1">
                            <input type="text" class="form-control" v-model="discountPrice">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品库存</label>
                        <div class="controls col-sm-1">
                            <input type="text" class="form-control" v-model="stock">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品简介</label>
                        <div class="controls col-sm-6">
                            <input type="text" class="form-control" v-model="intro">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品图片</label>
                        <div class="controls col-sm-1">
                            <button class="btn btn-warning" v-on:click="selectImage(1)">选择图片</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            {{-- 图标 --}}
                            <ul v-if="icon">
                                <li class="picture-list">
                                    <div class="picture-box">
                                        {{-- 图片列表 --}}
                                        <img class="picture-list-img" v-bind:src="icon.url" v-bind:alt="icon.name" />
                                    </div>
                                    <span class="picture-name">@{{ icon.name }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品轮播图</label>
                        <div class="controls col-sm-1">
                            <button class="btn btn-success" v-on:click="selectImage(2)">选择图片</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            {{-- 轮播图 --}}
                            <ul v-if="banners">
                                <li class="picture-list" v-for="banner in banners">
                                    <div class="picture-box">
                                        {{-- 轮播图列表 --}}
                                        <img class="picture-list-img" v-bind:src="banner.url" v-bind:alt="banner.name" />
                                    </div>
                                    <span class="picture-name">@{{ banner.name }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Textarea -->
                        <label class="control-label col-sm-2">商品详情</label>
                        <div class="controls col-sm-6">
                            <div id="desc"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="controls col-sm-3">
                            <input v-on:click="confirm" type="button" class="btn btn-primary" value="提交">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

@endsection

@section('script')

@include('admin.picture.select')

<script>
    var vm = new Vue({
        el: "#app",
        data: {
            {{-- 字段 --}}
            name: "{{ $product->name or '' }}",
            sku: "{{ $product->sku or $sku }}",
            parentCategory: "{{ $product->parentCategory or '' }}",
            category: "{{ $product->category_id or '' }}",
            originalPrice: "{{ $product->org_price or '' }}",
            discountPrice: "{{ $product->dsc_price or '' }}",
            stock: "{{ $product->stock or '' }}",
            intro: "{{ $product->introduction or '' }}",
            icon: "",
            banners: "",
            desc: "",
            {{-- End 字段 --}}
            type: "{{ $type }}",
            childrenList: [],
            showChildren: [],
        },
        ready: function() {
            // 编辑器
            $('#desc').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: false
            });
            if(this.type == 'edit') {
                // 获取父类的子类别
                this.showChildren = [];
                this.getChildren(this.parentCategory);

                // 描述文本
                $("#desc").summernote('code', '{!! $product->description !!}');
            }
        },
        watch: {
            parentCategory: function() {
                vm.showChildren = [];
                vm.getChildren(vm.parentCategory);
            },
        },
        methods: {
            httpPost: function(url, params, type) {
                this.$http.post( url, params, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    emulateJSON: true
                }).then( function(reponse) {

                    var returnData = reponse.data;
                    if(returnData.err == 1) {

                        if(type == 'getChildrenList') {

                            vm.childrenList[params.id] = returnData.extra;

                            vm.showChildren = this.childrenList[params.id];
                        } else if(type == 'add') {
                            swal({
                                title: '添加商品',
                                text: returnData.msg,
                                type: 'success',
                            },
                            function(isConfirm) {
                                window.location.href = "{{ url('product?category=') }}" + vm.category;
                            });
                        }

                    } else {

                        swal("出错了！", returnData.msg, "error");

                    }
                }, function(reponse) {

                    swal("出错了！", "数据传输错误", "error");
                });
            },
            getChildren: function(id) {
                {{-- 若不存在父类的子类，获取其的子类列表，并存到数组中 --}}
                if(typeof(this.childrenList[id]) === 'undefined') {
                    var url = "{{ url('category/children') }}";
                    var params = {
                        'id': id
                    };
                    var type = "getChildrenList";

                    this.httpPost(url, params, type);
                } else {
                    this.showChildren = this.childrenList[id];
                }

            },
            selectImage: function(source) {
                var pictureType = 1;
                var limit = 1;
                if(source == 2)
                    limit = 5;
                var selectPictures = [];
                if(this.type == 'edit') {
                    if(source == 1) {
                        selectPictures = {!! $product->iconDetail !!};
                    } else {
                        selectPictures = {!! $product->bannerDetail !!};
                    }
                }

                {{-- source:来源(图标或轮播图)
                     pictureType:图片类型(产品)
                     limit:限制数量(最多可选)
                     selectPictures:已选的图片(用于编辑页面非新增页面)
                --}}

                var options = {
                    source: source,
                    pictureType: pictureType,
                    limit: limit,
                    selectPictures: selectPictures,
                }
                selectVm.show(options);
                return false;
            },
            confirm: function() {
                if(this.type == 'add') {
                    var url = "{{ url('product/store') }}";
                } else if(this.type == 'edit') {
                    var url = "{{ url('product/update') }}";
                }
                var icon_id = this.icon.id;
                var banner = [];
                $.each(this.banners, function(i, item) {
                    banner.push(item.id);
                });
                var description = $('#desc').summernote('code');

                var params = {
                    name: this.name,
                    sku: this.sku,
                    category_id: this.category,
                    org_price: this.originalPrice,
                    dsc_price: this.discountPrice,
                    stock: this.stock,
                    introduction: this.intro,
                    description: description,
                    icon_id: icon_id,
                    banner: banner
                };
                this.httpPost(url, params, this.type);
            },
        }
    });

    selectVm.$watch('selectPictures', function() {
        {{-- 图片列表更改，显示到页面上 --}}
        if(selectVm.source == 1)
            vm.icon = selectVm.selectPictures[0];
        else
            vm.banners = selectVm.selectPictures;
    });
</script>
@endsection