@extends('admin.layout')

@section('title', 'Category')

@section('app', 'category')

@section('content')

    <div class="row" id="app">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    类别列表
                </div>
                {{-- /.panel-heading --}}
                <div class="panel-body">
                    <div id="table">
                        <div class="row">

                            <div class="col-md-1">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                    选择类别
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                @foreach ($parents as $parent)
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href=" {{ url('category/index').'/'.$parent['id'] }} "> {{ isset($parent['name_all'])? $parent['name_all']: $parent['name'] }} </a>
                                    </li>
                                @endforeach
                                </ul>
                            </div>

                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" v-on:click="addModal">新增类别</button>
                            </div>

                            <div class="col-md-1">
                                <a type="button" class="btn btn-warning" href="{{ url('category/index').'/parent' }}">父类别</a>
                            </div>

                            @if($categoryId != '0')
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success" v-on:click="comfirmSort">确定排序</button>
                            </div>
                            @endif

                        </div>
                        <br/>

                        <table class="table table-striped table-bordered table-hovertable-responsive">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">名称</th>
                                    <th class="col-md-2">父类别</th>
                                    <th class="col-md-2">操作</th>
                                    @if($categoryId != '0')
                                    <th class="col-md-1">排序(拖曳进行排序)</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody v-sortable="{ handle: '.handle' }">
                            @foreach ($cate->items() as $category)
                                <tr class="odd gradeX">
                                    <td>
                                        {{ $category->id }}
                                    </td>
                                    <td> {{ $category->name }} </td>
                                    <td> {{ $category->parentCate? $category->parentCate->name : '无父类别' }} </td>
                                    <td>

                                        <button type="button" class="btn btn-success btn-sm glyphicon glyphicon-edit" v-on:click="editModal({{ $category->id }}, '{{ $category->name }}', {{ $category->parent }})"> 编辑</button>

                                        <button type="button" class="btn btn-danger btn-sm glyphicon glyphicon-remove" v-on:click="deleteCate({{ $category->id }})"> 删除</button>
                                    </td>

                                    @if($categoryId != '0')
                                    <td class="row">
                                        <button class="btn btn-primary btn-sm col-md-2">{{ $category->sort }}</button>
                                        <i class="handle glyphicon glyphicon-move col-md-2"></i>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $cate->render() !!}

                    </div>
                </div>
                {{-- /.panel-body --}}
            </div>
            {{-- /.panel --}}
        </div>
        {{-- /.col-lg-12 --}}

        {{-- BEGIN 添加、编辑模态框 --}}
        <div id="modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title" id="modal-title"> @{{ modalTitle }} </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">类别名称:</label>
                            <input type="hidden" value="@{{ editCategoryId }}">
                            <input type="text" class="form-control" id="category-name" placeholder="请填写类别" v-model="inputName">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">父类别:</label>
                            <select class="form-control" v-model="inputParent">

                                @foreach ($parents as $parent)

                                   <option v-if="{{ $parent['id'] }} != editCategoryId || editCategoryId == 0" value="{{ $parent['id'] }}"> {{ $parent['name'] }} </option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" v-on:click="confirm">确定</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- END 添加、编辑模态框 --}}

    </div>
    {{-- /.row --}}
@endsection

@section('script')
<script>

    var vm = new Vue({
        el: "#app",
        data: {
            "modalTitle": "",
            "editCategoryId": "",
            "inputName": "",
            "inputParent": "",
            "children": []
        },
        methods: {
            addModal: function () {
                this.editCategoryId = "";
                this.inputName = '';
                this.inputParent = 0;
                this.modalTitle = "添加类别";
                $("#modal").modal();
            },
            editModal: function (id, name, parent) {

                this.editCategoryId = id;

                this.inputName = name;
                this.inputParent = parent;

                this.modalTitle = "修改类别";
                $("#modal").modal();
            },
            confirm: function () {
                var name = this.inputName;
                var parent = this.inputParent;

                var type, params, url;
                if(this.editCategoryId > 0) {
                    {{-- 更新数据 --}}
                    type = "update";
                    params = {
                        "name": name,
                        "parent": parent
                    };
                    url = "{{ url('/category/update') }}" + "/" + this.editCategoryId;
                } else {
                    {{-- 创建数据 --}}
                    type = "store";
                    params = {
                        "name": name,
                        "parent": parent
                    };
                    url = "{{ url('/category/store') }}";
                }

                this.$http.post( url, params, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    emulateJSON: true
                }).then( function (reponse) {
                    {{-- success --}}
                    var returnData = reponse.data;

                    if(returnData.err == 1) {

                        swal({
                            title: this.modalTitle,
                            text: returnData.msg,
                            type: "success"
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $("#modal").modal('hide');
                                window.location.reload();
                            }
                        });

                    } else {

                        swal("出错了！", returnData.msg, "error");

                    }
                }, function (reponse) {

                    swal("出错了！", "数据传输错误", "error");
                });

            },
            deleteCate: function (id) {

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

                    var url = "{{ url('/category/destroy').'/' }}" + id;
                    var params = {};
                    vm.$http.post( url, params, {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        emulateJSON: true
                    }).then( function (reponse) {
                        {{-- success --}}
                        var returnData = reponse.data;

                        if(returnData.err == 1) {

                            swal("删除类别", returnData.msg, "success");
                            window.location.reload();

                        } else {

                            swal("出错了！", returnData.msg, "error");

                        }
                    }, function (reponse) {

                        swal("出错了！", "数据传输错误", "error");
                    });
                });
            },
            comfirmSort: function () {

            }
        }
    });

</script>

@endsection