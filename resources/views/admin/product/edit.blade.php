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

                        <!-- File Upload -->
                        <div class="controls col-sm-1">
                            <div id="icon"></div>
                            <div id="image-banner"></div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary" v-on:click="startUpload(1)">上传</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">商品轮播图</label>
                        <!-- File Upload -->
                        <div class="controls col-sm-1">
                            <div id="banner"></div>
                            <div id="image-banner"></div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary" v-on:click="startUpload(2)">上传</button>
                            </div>
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
            uploadIcon: '',
            uploadBanner: '',
        },
        ready: function() {
            // 编辑器
            $('#desc').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: false
            });

            this.uploadFiles('icon', 'icon', 1);
        },
        methods: {
            uploadFiles: function(id, fileName, maxCount) {
                // 上传图片
                var upload = $("#" + id).uploadFile({
                    url: "{{ url('upload/image') }}",
                    fileName: fileName,
                    returnType: 'json',
                    autoSubmit: false,
                    dragDrop: false,
                    accept: "image/*",
                    showPreview: true,
                    previewWidth: '50%',
                    maxFileCount: maxCount,
                    showFileSize: true,
                    dynamicFormData: function() {
                        var data = {
                            'dir': 'product',
                            '_token': "{{ csrf_token() }}"
                        };
                        return data;
                    },
                    showStatusAfterSuccess: false,
                    allowedTypes: "jpg,png,gif,jpeg",
                    onSuccess: function(files,data,xhr,pd) {
                        alert(1);

                        console.log(files,data,xhr,pd);
                        return true;
                        vm.image = data.extra.picId;
                        vm.imageUrl = data.extra.url;
                        var imgHtml = '<img data-id="' + vm.image + '" src="' + vm.imageUrl + '" class="icon"/>';
                        $("#image").html(imgHtml);
                    },
                    onError: function(files,status,errMsg,pd) {
                        alert(2);
                        console.log(files,status,errMsg,pd);
                        return true;
                    },
                    afterUploadAll:function(obj)
                    {
                        alert(3);
                    }

                });
                if(id == 'icon')
                    this.uploadIcon = upload;
                else
                    this.uploadBanner = upload;
                console.log(this.uploadIcon);
                return;
            },
            startUpload: function(type) {
                alert(typeof(this.uploadIcon));
                console.log(this.uploadIcon);
                if(type == 1)
                    this.uploadIcon.startUpload();
                else if(type == 2)
                    this.uploadBanner.startUpload();
            },
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