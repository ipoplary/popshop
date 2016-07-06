@inject('pictureService', 'App\Services\PictureService')

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">上传图片</h4>
            </div>

            <div class="modal-body form-horizontal">

                <div class="form-group">
                    <label class="control-label col-sm-3">图片类别：</label>
                    <div class="controls col-sm-6">
                        <select class="form-control input-xlarge" v-model="pictureType">
                            @foreach($pictureService->pictureType() as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3"></div>
                </div>

                <div class="form-group" v-show="pictureType">
                    <label class="control-label col-sm-3">上传图片：</label>
                    <div class="controls col-sm-9">
                        {{--<div id="fileuploader">选择图片</div>--}}
                        <input type="file" name="files[]" id="fileuploader" multiple="multiple">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>

<script>
    var uploadVm = new Vue({
        el: "#uploadModal",
        data: {
            pictureType: null,
            uploadObj: null,
        },
        ready: function() {
            /*this.uploadObj = $("#fileuploader").uploadFile({
                url:"{{ url('upload/picture') }}",
                fileName: 'picture',
                returnType: 'json',
                autoSubmit: true,
                dragDrop: false,
                showPreview: true,
                multiple: true,
                accept: "image/*",
                previewWidth: '50%',
                showFileSize: true,
                dynamicFormData: function() {
                    var data = {
                        'dir': uploadVm.pictureType,
                        '_token': "{{ csrf_token() }}"
                    };
                    return data;
                },
                showStatusAfterSuccess: true,
                allowedTypes: "jpg,png,gif,jpeg",
                onSuccess: function(files,data,xhr,pd) {
                    var response = xhr.responseJSON;
                    if(response.err == 1)
                        swal("上传成功！", data.msg, "success");
                    else
                        swal("上传失败！", errMsg, "error");
                    return ;
                },
                onError: function(files,status,errMsg,pd) {
                    swal("上传失败！", errMsg, "error");
                    return ;
                },
                afterUploadAll: function(obj) {
                    swal("上传成功！", data.msg, "success");
                }

            });*/
            $('#fileuploader').filer({
                // limit: 3,
                maxSize: 3,
                extensions: ['jpg', 'jpeg', 'png', 'gif'],
                changeInput: true,
                showThumbs: true,
                addMore: true,
                templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name | limitTo: 25}}</b></span>\
                                            <span class="jFiler-item-others">@{{fi-size2}}</span>\
                                        </div>\
                                        @{{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left"></ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',

                itemAppendToEnd: false,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    remove: '.jFiler-item-trash-action'
                }
            },
            });
        },
        methods: {
            show: function() {
                $('#uploadModal').modal('show');
                return;
            },
            hide: function() {
                $('#uploadModal').modal('hide');
                return;
            },
            toggle: function() {
                $('#uploadModal').modal('toggle');
                return;
            },
        }
    });
</script>