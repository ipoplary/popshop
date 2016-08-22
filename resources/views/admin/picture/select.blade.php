@if(! isset($pictureTypeService))
    @inject('pictureTypeService', 'App\Services\PictureTypeService')
@endif

<div class="modal fade bs-example-modal-lg" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xlg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">选择图片</h4>

                <ul class="nav nav-tabs">

                    <li v-on:click="getPicutures(0, 0)" v-bind:class="[pictureType == 0? 'active':'']">
                        <a href="javaScript:;">所有图片</a>
                    </li>

                    {{-- 图片类型列表 --}}
                    @foreach($pictureTypeService->pictureType() as $pictureType)
                        <li v-on:click="getPicutures({{ $pictureType['id'] }}, 0)" v-bind:class="[pictureType == '{{ $pictureType['id'] }}'? 'active':'']">
                            <a href="javaScript:;">{{ $pictureType['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content col-md-12">
                    <ul>
                        <li class="picture-list" v-for="picture in pictures" data-id="@{{ picture.id }}">
                            <div v-on:click="selectPicture(picture.id)">
                                {{-- 图片列表 --}}
                                <img class="picture-list-img" v-bind:src="picture.url" v-bind:alt="picture.name" />
                                {{-- <a href="javascript:;" class="picture-remove" v-on:click="deletePicture(picture.id)">删除</a> --}}
                                <span class="picture-name">@{{ picture.name }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" v-on:click="confirm">确定</button>
                <button type="button" class="btn btn-default" v-on:click="hide">取消</button>
            </div>
        </div>
    </div>
</div>

<script>
    var selectVm = new Vue({
        el: "#selectModal",
        data: {
            pictureType: "",  {{-- 图片类型 --}}
            pictureList: [],  {{-- 获取的图片列表 --}}
            pictures: [],  {{-- 显示的图片 --}}
            selectPictures: [],  {{-- 所选图片 --}}
        },
        ready: function() {

        },
        watch: {

        },
        methods: {
            {{-- post请求 --}}
            httpPost: function (url, params, type) {
                this.$http.post( url, params, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    emulateJSON: true
                }).then( function (reponse) {

                    var returnData = reponse.data;
                    if(returnData.err == 1) {

                        if(type == 1) {
                            {{-- type为1，获取图片数据。该类别下无数组，则将返回的数据定义为数组值，否则，将返回的数据添加进原有的数组 --}}
                            if(params.offset == 0) {

                                this.pictureList[params.pictureType] = returnData.extra;
                            } else {

                                this.pictureList[params.pictureType] = this.pictureList[params.pictureType].concat(returnData.extra);
                            }

                            this.pictureType = params.pictureType;

                            this.pictures = this.pictureList[this.pictureType];

                        }

                    } else {

                        swal("出错了！", returnData.msg, "error");
                        return false;

                    }
                }, function (reponse) {

                    swal("出错了！", "数据传输错误", "error");
                    return false;
                });
            },
            {{-- 打开模态框 --}}
            show: function(source, pictureType) {
                {{-- source:
                    1:商品图片
                    2:商品轮播图
                    3:
                    4:
                    5:
                 --}}
                this.pictureType = pictureType;

                this.getPicutures(pictureType, 10);

                $('#selectModal').modal('show');
                return;
            },
            {{-- 隐藏模态框 --}}
            hide: function() {
                $('#selectModal').modal('hide');
                return;
            },
            {{-- 确认选取的图片 --}}
            confirm: function() {
                return;
            },
            {{-- 从服务端获取图片数据 --}}
            getPicutures: function(type, count) {
                {{-- 获取数值为0 或者 该类别下无数组的情况下去获取数据 --}}
                if(count > 0 || typeof(this.pictureList[type]) == 'undefined') {
                    var offset = 0;
                    if(typeof(this.pictureList[type]) != 'undefined') {
                        offset = this.pictureList[type].length;
                    }
                    var url = "{{ url('picture/list') }}";
                    var params = {
                        pictureType: type,  {{-- 图片类型 --}}
                        offset: offset,  {{-- 偏移量 --}}
                        count: count,  {{-- 获取数量 --}}
                    };
                    var type = 1;
                    this.httpPost(url, params, type);
                } else {
                    this.pictureType = type;
                }
            },
        }
    });
</script>