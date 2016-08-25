@extends('admin.auth.layout')

@section('title', '注册')

@section('content')
    <div class="register-box">
        <div class="register-logo">
            <b>Pop</b>Shop
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">注册管理账户</p>

            <form method="POST" action="{{ url('register') }}">

                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="账号" name="name" type="text">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="邮箱" name="email" type="email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="密码" name="password" type="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input class="form-control" placeholder="重复密码" name="password_confirmation" type="password">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                    </div>

                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-block btn-flat" type="submit" value="确认">
                    </div>

                </div>

            </form>

            <a href="{{ url('login') }}" class="text-center">已有账号，跳至登录</a>
        </div>
        {{-- /.form-box --}}

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
    {{-- /.register-box --}}
@endsection

@section('script')
    <script>
        $(function () {
        });
    </script>
@endsection
