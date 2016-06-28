@extends('admin.layout')

@section('title', 'Product')

@section('app', 'product')

@section('content')

    <div class="row" id="app">
        <div class="col-md-12">
            <form class="form-horizontal">
                <fieldset>
                    <div>
                        <legend class="">添加商品</legend>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品名</label>
                        <div class="controls col-sm-3">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">SKU</label>
                        <div class="controls col-sm-3">
                            <input type="text" class="form-control" disabled="disabled" v-model="sku">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">类别</label>
                        <div class="controls col-sm-1">
                            <select class="form-control input-xlarge">
                                <option>Enter</option>
                                <option>Your</option>
                                <option>Options</option>
                                <option>Here!</option>
                            </select>
                        </div>
                        <div class="controls col-sm-1">
                            <select class="form-control input-xlarge">
                                <option>Enter</option>
                                <option>Your</option>
                                <option>Options</option>
                                <option>Here!</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">原价格</label>
                        <div class="controls col-sm-3">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">优惠价格</label>
                        <div class="controls col-sm-3">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品库存</label>
                        <div class="controls col-sm-3">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品简介</label>
                        <div class="controls col-sm-3">
                            <input type="text" class="form-control">
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
                        <label class="control-label col-sm-2">商品图片</label>
                        <div class="controls col-sm-3">
                            <input name="icon" id="upload-icon" type="file" class="file" data-preview-file-type="text"  value>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品轮播图</label>
                        <div class="controls col-sm-3">
                            <input name="banner" id="upload-banner" type="file" class="file" data-preview-file-type="text"  value>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="controls col-sm-3">
                            <input type="button" class="btn btn-primary" value="提交">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

@endsection

@section('script')
<script>
    var vm = new Vue({
        el: "#app",
        data: {
            name: "{{ $name or '' }}",
            sku: "{{ $sku }}",
        },
        ready: function() {
            // 编辑器
            $('#desc').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: false
            });

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
        }
    });
</script>
@endsection