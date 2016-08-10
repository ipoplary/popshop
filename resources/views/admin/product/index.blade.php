@extends('admin.layout')

@section('title', 'Product')

@section('app', 'product')

@section('content')

    <div class="row" id="app">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div id="table">
                        <div class="row">

                            <div class="col-md-1">
                                <select class="form-control" v-model="parentId">
                                    <option value="0">所有父类别</option>
                                    @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" v-on:select="getChildren('{{ $parent->id }}')">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1">
                                <select class="form-control" v-model="childId">
                                    <option value="0">所有子类别</option>
                                    <option v-for="child in showChildren" value="@{{ child['id'] }}">@{{ child['name'] }}</option>
                                </select>
                            </div>

                            <div class="radio row col-md-2">
                                <label class="col-md-5 inline">
                                    <input type="radio" name="snapshot" value="0" v-model="snapshot">不含快照
                                </label>

                                <label class="col-md-5 inline">
                                    <input type="radio" name="snapshot" value="1" v-model="snapshot">含快照
                                </label>
                            </div>

                            <div class="col-md-1">
                                <button class="btn btn-success" v-on:click="filter">筛选</button>
                            </div>

                            <div class="col-md-1">
                                <a class="btn btn-primary" href="{{ url('product/create') }}">新增商品</a>
                            </div>

                            @if($sort == 1)
                            <div class="col-md-1">
                                <button type="button" class="btn btn-warning" v-on:click="comfirmSort">确定排序</button>
                            </div>
                            @endif

                        </div>
                        <br/>

                        <table class="table table-striped table-bordered table-hovertable-responsive">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">SKU</th>
                                    <th class="col-md-2">商品名</th>
                                    <th class="col-md-2">所属类别</th>
                                    <th class="col-md-2">操作</th>
                                    @if($sort == 1)
                                    <th class="col-md-1">排序(拖曳进行排序)</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody v-sortable="{ handle: '.handle' }" id="sort">
                            @foreach ($products->items() as $product)
                                <tr class="odd gradeX sort-id" data-id="{{ $product->id }}" v-bind:class="{'warning': '{{ $product->snapshot==1 }}'}">
                                    <td> {{ $product->id }} </td>
                                    <td> {{ $product->sku }} </td>
                                    <td>
                                        {{ $product->name }}
                                        @if($product->snapshot)
                                            (快照)
                                        @endif
                                    </td>
                                    <td> {{ $product->categoryName or '无父类别' }} </td>
                                    <td>

                                        <button type="button" class="btn btn-success btn-sm glyphicon glyphicon-edit" v-on:click="editModal({{ $product->id }}, '{{ $product->sku }}', {{ $product->name }})"> 编辑</button>

                                        <button type="button" class="btn btn-danger btn-sm glyphicon glyphicon-remove" v-on:click="deleteCate({{ $product->id }})"> 删除</button>
                                    </td>

                                    @if($sort == 1)
                                    <td class="row">
                                        <button class="btn btn-warning btn-sm col-md-4 glyphicon glyphicon-move handle">  {{ $product->sort }}</button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $products->appends(['category' => $categoryId, 'snap' => $snapshot])->render() !!}

                    </div>
                </div>
                {{-- /.panel-body --}}
            </div>
            {{-- /.panel --}}
        </div>
        {{-- /.col-lg-12 --}}

    </div>
    {{-- /.row --}}
@endsection

@section('script')
<script>

    var vm = new Vue({
        el: "#app",
        data: {
            snapshot: "{{ $snapshot }}",
            parentId: "{{ $parentId or '0'}}",
            childId: "{{ $childId or '0'}}",
            childrenList: [],
            showChildren: [],
        },
        ready: function() {

            this.childrenList['0'] = [];
            if(this.parentId !== '0')
                this.getChildren(this.parentId);
        },
        watch: {
            parentId: function(parentId) {
                vm.getChildren(parentId);
            }
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
                        } else if(type == 'delete' || type == 'sort') {
                            swal({
                                title: '操作结果',
                                text: returnData.msg,
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    $("#modal").modal('hide');
                                    window.location.reload();
                                }
                            });
                        }

                    } else {

                        swal("出错了！", returnData.msg, "error");

                    }
                }, function(reponse) {

                    swal("出错了！", "数据传输错误", "error");
                });
            },
            deleteCate: function(id) {

                swal({
                    title: "删除类别",
                    text: "确定删除？",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: false
                },
                function(){

                    var url = "{{ url('product/destroy').'/' }}" + id;
                    var params = {};
                    vm.httpPost(url, params, "delete");
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
            filter: function() {
                var url = "{{ url('product/index') }}";
                var category;
                if(this.childId !== '0'){
                    category = this.childId;
                } else if(this.parentId !== '0') {
                    category = this.parentId;
                } else {
                    category = 0;
                }
                var snapshot = this.snapshot;
                url += '?category=' + category + '&snapshot=' + snapshot;
                window.location.href = url;
            },
            comfirmSort: function() {
                var url = "{{ url('product/sort') }}";
                var arr = [];

                $("#sort").find(".sort-id").each(function() {
                    arr.push($(this).attr("data-id"));
                });

                var params = {sort: arr};

                this.httpPost(url, params, "sort");
            }
        }
    });

</script>

@endsection
