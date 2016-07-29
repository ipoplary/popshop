@extends('admin.layout')

@section('title', '图片')

@section('app', 'picture')

@if(! isset($pictureService))
    @inject('pictureTypeService', 'App\Services\PictureTypeService')
@endif

@section('content')
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-tabs">

                <li v-on:click="getPicutures(0, 0)" v-bind:class="[type == 0? 'active':'']">
                    <a href="javaScript:;">所有图片</a>
                </li>

                @foreach($pictureTypeService->pictureType() as $pictureType)
                <li v-on:click="getPicutures({{ $pictureType['id'] }}, 0)" v-bind:class="[type == '{{ $pictureType['id'] }}'? 'active':'']">
                    <a href="javaScript:;">{{ $pictureType['name'] }}</a>
                </li>
                @endforeach

                <button class="btn btn-primary col-md-1 pull-right">添加类别</button>
                <button class="btn btn-success col-md-1 pull-right" v-on:click="uploadModal">上传图片</button>

            </ul>

            <div class="tab-content col-md-12">
                <ul>
                    <li class="picture-list" v-for="picture in pictures" data-id="@{{ picture.id }}">
                        <img class="picture-list-img img-responsive" v-bind:src="picture.url" v-bind:alt="picture.name" />
                        <i class="picture-remove glyphicon glyphicon-trash"></i>
                        <span>@{{ picture.name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')

@include('admin.picture.upload')
<script>

    var vm = new Vue({
        el: "#picture",
        data: {
            type: 0,
            pictureList: [],
            pictures: [],
        },
        ready: function() {
            this.pictureList[this.type] = {!! $pictures !!};
            this.pictures = this.pictureList[this.type];
            uploadVm.$watch("pictures", function() {
                vm.pictureList[vm.type] = uploadVm.pictures.concat(vm.pictureList[vm.type]);
                vm.pictures = vm.pictureList[vm.type];
            });
        },
        watch: {
            "type": function() {
                vm.pictures = [];
                vm.pictures = vm.pictureList[vm.type];
            },
        },
        methods: {
            // 请求图片，返回图片列表数据
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
                            // 该类别下无数组，则将返回的数据定义为数组值，否则，将返回的数据添加进原有的数组
                            if(params.offset == 0) {

                                this.pictureList[params.pictureType] = returnData.extra;
                            } else {

                                this.pictureList[params.pictureType] = this.pictureList[params.pictureType].concat(returnData.extra);
                            }

                            this.type = params.pictureType;

                        } else if(type == 2) {
                            swal("删除图片", returnData.msg, "success");
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
            getPicutures: function(type, count) {
                // 获取数值为0 或者 该类别下无数组的情况下去获取数据
                if(count > 0 || typeof(this.pictureList[type]) == 'undefined') {
                    var offset = 0;
                    if(typeof(this.pictureList[type]) != 'undefined') {
                        offset = this.pictureList[type].length;
                    }
                    var url = "{{ url('picture/list') }}";
                    var params = {
                        pictureType: type,
                        offset: offset,
                    };
                    var type = 1;
                    this.httpPost(url, params, type);
                } else {
                    this.type = type;
                }
            },
            uploadModal: function() {
                uploadVm.show();
            },
            deletePicture: function(id) {
                var url = "{{ url('picture/destroy') }}";
                var params = {
                    id: id
                };
                var type = 2;
                var returnData = this.httpPost(url, params, type);
            }
        }
    });

</script>
@endsection
