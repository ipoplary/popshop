@extends('admin.auth.layout')

@section('title', '登录')

@section('content')
    <div class="login-box" id="login">

        <div class="login-logo">
            <b>Pop</b>Shop
        </div>
        {{-- /.login-logo --}}

        <div class="login-box-body">

            <p class="login-box-msg">管理员登录</p>

            <form method="POST" action="{{ url('login') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="账号" name="name" type="text">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="密码" name="password" type="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div>
                            <label>
                                <input name="remember" type="checkbox">
                                记住我
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-block btn-flat" type="submit" value="登录">
                    </div>
                    {{-- /.col --}}
                </div>

            </form>

            {{-- <a href="#">I forgot my password</a><br>
            <a href=" {{ url('register') }} " class="text-center">注册</a>  --}}

        </div>
        {{-- /.login-box-body --}}

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    {{-- /.login-box --}}
@endsection

@section('script')
    <script>

        var vm = new Vue({
            el: "#login",
            ready: function() {
                @if(isset($err) && $err !== 0)
                    swal("{{ $msg }}", "请输入正确的账号密码！", "warning");
                @endif
            }
        });
    </script>
@endsection
