@extends('admin.layout')

@section('title', '图片')

@section('app', 'picture')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-tabs">
                <li v-on:click="getPicutures(0)" v-bind:class="[type == 0? 'active':'']">
                     <a href="javaScript:;">所有图片</a>
                </li>
                @foreach($pictureTypes as $pictureType)
                <li v-on:click="getPicutures({{ $pictureType->id }})" v-bind:class="[type == '{{ $pictureType->id }}'? 'active':'']">
                     <a href="javaScript:;">{{ $pictureType->name }}</a>
                </li>
                @endforeach

                <button class="btn btn-primary col-md-1 pull-right">添加类别</button>
                <button class="btn btn-success col-md-1 pull-right">上传图片</button>

            </ul>

            <div class="tab-content col-md-11">
                <ul>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                    <li class="picture-list">
                        <img class="picture-list-img" src="{{ asset('upload/img/product/test1.jpg') }}" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    var vm = new Vue({
        el: "#picture",
        data: {
            type: 0,
            pictureList: [],
        },
        ready: function() {

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
        }
    });

</script>
@endsection