@extends('admin.layout')

@section('title', '图片')

@section('app', 'picture')

@if(! isset($pictureService))
    @inject('pictureService', 'App\Services\PictureService')
@endif

@section('content')
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-tabs">

                <li v-on:click="getPicutures(0)" v-bind:class="[type == 0? 'active':'']">
                    <a href="javaScript:;">所有图片</a>
                </li>

                @foreach($pictureService->pictureType() as $pictureType)
                <li v-on:click="getPicutures({{ $pictureType->id }})" v-bind:class="[type == '{{ $pictureType->id }}'? 'active':'']">
                    <a href="javaScript:;">{{ $pictureType->name }}</a>
                </li>
                @endforeach

                <button class="btn btn-primary col-md-1 pull-right">添加类别</button>
                <button class="btn btn-success col-md-1 pull-right" v-on:click="uploadModal">上传图片</button>

            </ul>

            <div class="tab-content col-md-11">
                <ul>
                    <li class="picture-list" v-for="picture in pictures">
                        <img class="picture-list-img img-responsive" v-bind:src="picture.url" v-bind:alt="picture.name" />
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
            pictures: {!! $pictures !!},
            extraPictures: uploadVm.pictures,
        },
        ready: function() {

        },
        watch: {
            'extraPictures': function(val, oldVal) {
                console.log(pictures);

                console.log(extraPictures);
                // vm.pictures.push(val);
            }
        },
        methods: {
            // 请求图片，返回图片列表数据
            httpPost: function (url, params) {
                this.$http.post( url, params, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    emulateJSON: true
                }).then( function (reponse) {

                    var returnData = reponse.data;

                    if(returnData.err == 1) {

                        return returnData.extra;

                    } else {

                        swal("出错了！", returnData.msg, "error");

                    }
                }, function (reponse) {

                    swal("出错了！", "数据传输错误", "error");
                });
            },
            getPicutures: function(type) {
                this.type = type;
            },
            uploadModal: function() {
                uploadVm.show();
            }
        }
    });

</script>
@endsection
