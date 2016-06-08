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
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="table">
                        <div>
                            <button type="button" class="btn btn-primary" v-on:click="addModal">新增类别</button>
                        </div><br/>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>名称</th>
                                    <th>父类别</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($cate->items() as $category)
                                <tr class="odd gradeX" v-bind:class="'success'">
                                    <td>
                                        <span class="glyphicon glyphicon-plus" v-on:click="getChildCate({{ $category->id }})"></span>
                                        {{ $category->id }}
                                    </td>
                                    <td> {{ $category->name }} </td>
                                    <td> {{ $category->parentCate? $category->parentCate->name : '无父类别' }} </td>
                                    <td>

                                        <button type="button" class="btn btn-success btn-sm glyphicon glyphicon-edit" v-on:click="editModal({{ $category->id }}, '{{ $category->name }}', {{ $category->parent }})"> 编辑</button>

                                        <button type="button" class="btn btn-danger btn-sm glyphicon glyphicon-remove" v-on:click="deleteCate({{ $category->id }})"> 删除</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $cate->links() !!}

                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->

        <!-- BEGIN 添加、编辑模态框 -->
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
        <!-- END 添加、编辑模态框 -->

    </div>
    <!-- /.row -->
@endsection

@section('script')
<script>
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
                    // 更新数据
                    type = "update";
                    params = {
                        "name": name,
                        "parent": parent,
                        "id": this.editCategoryId
                    };
                    url = "{{ url('/category/update') }}";
                } else {
                    // 创建数据
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
                    // success
                    var returnData = reponse.data;

                    if(returnData.err == 0) {

                        swal(this.modalTitle, returnData.msg, "success");
                        $("#modal").modal('hide');
                        window.location.reload();

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

                    var url = "{{ url('/category/delete') }}";
                    var params = {

                        "id": id
                    };
                    vm.$http.post( url, params, {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        emulateJSON: true
                    }).then( function (reponse) {
                        // success
                        var returnData = reponse.data;

                        if(returnData.err == 0) {

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
            getChildCate: function(id) {
                var url = "{{ url('/category/child') }}";
                var params = {
                    "id": id
                };
                vm.$http.post( url, params, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    emulateJSON: true
                }).then( function (reponse) {
                    // success
                    var returnData = reponse.data;

                    if(returnData.err == 0) {
                        this.children[id] = returnData.extra;
                        console.log(this.children);

                    } else {

                        swal("出错了！", returnData.msg, "error");

                    }
                }, function (reponse) {

                    swal("出错了！", "数据传输错误", "error");
                });
            }
        }
    });

    </script>
</script>

@endsection