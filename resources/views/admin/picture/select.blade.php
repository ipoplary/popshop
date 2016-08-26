@if(! isset($pictureTypeService))
    @inject('pictureTypeService', 'App\Services\PictureTypeService')
@endif

<div class="modal fade bs-example-modal-lg" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xlg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">选择图片(限制数量：@{{ limit }})</h4>

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
                        <li class="picture-list" v-for="(index, picture) in pictures" data-id="@{{ picture.id }}">
                            <div class="picture-box" v-on:click="selectPicture(index, picture.id, picture.url, picture.name)">
                                {{-- 图片列表 --}}
                                <div v-bind:class="['picture-mask', (picture.checked == 1)? 'checked':'']"></div>
                                <img class="picture-list-img" v-bind:src="picture.url" v-bind:alt="picture.name" />
                            </div>
                            {{-- <a href="javascript:;" class="picture-remove" v-on:click="deletePicture(picture.id)">删除</a> --}}
                            <span class="picture-name">@{{ picture.name }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" v-on:click="confirm">确定</button>
                <button type="button" class="btn btn-default" v-on:click="cancel">取消</button>
            </div>
        </div>
    </div>
</div>

<script>
    var selectVm = new Vue({
        el: "#selectModal",
        data: {
            source: "",  {{-- 选择的来源 --}}
            limit: 0, {{-- 当前来源的图片限制数量 --}}
            pictureType: "",  {{-- 图片类型 --}}
            pictureList: {},  {{-- 获取的图片列表 --}}
            pictures: {},  {{-- 显示的图片 --}}
            selectPictures: [],  {{-- 所选图片 --}}
            selectPictureList: {},  {{-- 所选图片列表（一个页面有多个图片选择） --}}
        },
        methods: {

            {{-- post请求 --}}
            httpPost: function (url, params, type, callback) {
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

                            {{-- 所有图片选中值设为0 --}}
                            $.each(this.pictures, function(i, item) {
                                item.checked = 0;
                            });

                            callback();
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

            {{-- 打开图片选择模态框 --}}
            show: function(options) {
                {{-- 所有图片选中值设为0 --}}
                $.each(this.pictures, function(i, item) {
                    item.checked = 0;
                });

                {{-- source: {1: 商品图片, 2: 商品轮播图, 3: ...} --}}
                source = options.source;
                this.pictureType = options.pictureType;
                this.limit = options.limit;

                {{-- 获取图片 --}}
                this.getPicutures(this.pictureType, 10, function() {


                    {{-- 判断是否存在已选的数组，若数组不存在，则初始化一个空数组 --}}
                    if(typeof(selectVm.selectPictureList[source]) == 'undefined') {
                        selectVm.selectPictureList[source] = [];
                    }

                    {{-- 来源改变时，所选图片应随之进行改变 --}}
                    selectVm.selectPictures = selectVm.selectPictureList[source];

                    $('#selectModal').modal('show');

                    if(selectVm.source != source || typeof(selectVm.selectPictureList[source]) != 'undefined') {

                        selectVm.check(source);
                    }

                    selectVm.source = source;

                    return;
                });
            },

            {{-- 初始化已选图片 --}}
            initSelect: function(source, selectPictures) {
                this.selectPictureList[source] = selectPictures;
            },

            {{-- 勾选已选的图片 --}}
            check: function(source) {
                var select = [];
                $.each(this.selectPictures, function(i, item) {
                    select.push(item.id);
                });

                {{-- 根据数组添加新的已选 --}}
                $.each(this.pictures, function(i, item) {

                    if(select.indexOf(item.id) >= 0) {
                        item.checked = 1;
                    }
                });
            },

            {{-- 隐藏模态框 --}}
            hide: function() {
                $('#selectModal').modal('hide');
                return;
            },

            {{-- 确认选取的图片 --}}
            confirm: function() {
                this.hide();
                return;
            },

            {{-- 取消 --}}
            cancel: function() {
                this.selectPictures = [];
                this.selectPictureList[this.source] = [];
                this.hide();
                return;
            },

            {{-- 从服务端获取图片数据 --}}
            getPicutures: function(type, count, callback) {
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
                    this.httpPost(url, params, type, callback);
                } else {
                    this.pictureType = type;
                }
            },

            {{-- 选择图片 --}}
            selectPicture: function(index, id, url, name) {
                var dom = $("li[data-id='" + id + "']").find("div.picture-mask");
                var arr = this.selectPictureList[this.source];
                var data = {
                    id: id,
                    url: url,
                    name: name
                }

                {{-- 是否已选 --}}
                var isSelected = 0;
                $.each(arr, function(i, item) {

                    if(id == item.id){
                        isSelected = 1;
                        return false;
                    }

                });

                if(isSelected == 0){
                    if(arr.length >= this.limit) {
                        swal("图片数量超过限制", "最多只能选择" + this.limit + "张图片", "error");
                        return;
                    }

                    {{-- 添加元素 --}}
                    arr.push(data);
                    dom.addClass("checked");

                }else {
                    {{-- 删除元素 --}}
                    $.each(arr, function(i, item) {
                        if(item.id == id){
                            arr.splice(i, 1);
                            return false;
                        }
                    });

                    dom.removeClass("checked");
                }
            },
        }
    });
</script>