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
                    <div class="controls col-sm-6">
                        <div id="fileuploader">选择图片</div>
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
            this.uploadObj = $("#fileuploader").uploadFile({
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
                    if(response.err == 0)
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