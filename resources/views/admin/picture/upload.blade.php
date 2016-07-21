@if(! isset($pictureService))
    @inject('pictureService', 'App\Services\PictureService')
@endif

<div class="modal fade bs-example-modal-lg" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">上传图片</h4>
            </div>
            <form>
                {{ csrf_field() }}
                <div class="modal-body form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">图片类别：</label>
                        <div class="controls col-sm-2">
                            <select class="form-control input-xlarge" name="type" v-model="pictureType">
                                @foreach($pictureService->pictureType() as $v)
                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group" v-show="pictureType">
                        <label class="control-label col-sm-3">上传图片：</label>
                        <div class="controls col-sm-9">
                            {{--<div id="fileuploader">选择图片</div>--}}
                            <input type="file" name="files[]" id="fileuploader" multiple="multiple">
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" v-on:click="confirmUpload">上传</button>
                <button type="button" class="btn btn-default" v-on:click="reset">取消</button>
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
            pictures: [],
        },
        ready: function() {
            $('#fileuploader').filer({
                // limit: 3,
                // maxSize: 1,
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
            this.uploadObj = $("#fileuploader").prop("jFiler");
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
            confirmUpload: function() {

                var options = {
                    url:"{{ url('picture/upload') }}",
                    resetForm: true,
                    type: 'POST',
                    dataType:  'json',
                    success: function(reponse, data) {
                        if(reponse.err == 1) {
                            var isExist = 0;
                            $.each(reponse.extra, function(i, item) {
                                if(item.exist == 1) {
                                    isExist = 1;
                                } else {
                                    uploadVm.pictures.unshift(item);
                                }
                            });

                            swal({
                                title: '操作结果',
                                text: isExist == 0? '上传成功！' : '上传成功，部分上传的图片已存在！',
                                type: 'success'
                            });
                            uploadVm.reset();
                        }
                    },
                    error: function() {
                    },
                };


                $('form').ajaxSubmit(options);
                return false;
            },
            reset: function() {
                uploadVm.pictures = [];
                this.pictureType = null;
                this.uploadObj.reset();
                this.hide();
            }
        }
    });
</script>