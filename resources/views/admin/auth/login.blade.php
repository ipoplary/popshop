@extends('admin.auth.layout')

@section('title', 'Log in')

@section('content')
    <div class="login-box" id="login">

        <div class="login-logo">
            <b>Pop</b>Shop
        </div>
        {{-- /.login-logo --}}

        <div class="login-box-body">

            <p class="login-box-msg">Sign in to start your session</p>

            {!! Form::open(['url' => 'login']) !!}

                <div class="form-group has-feedback">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div>
                            <label>
                                {!! Form::checkbox('remember') !!}
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        {!! Form::submit('Sign In', ['class' => 'btn btn-primary btn-block btn-flat']) !!}
                    </div>
                    {{-- /.col --}}
                </div>

            {!! Form::close() !!}

            {{-- <a href="#">I forgot my password</a><br>  --}}
            <a href=" {{ url('register') }} " class="text-center">Register a new membership</a>

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
            created: function() {
                @if(isset($err) && $err !== 0)
                    swal("{{ $msg }}", "请输入正确的账号密码！", "warning");
                @endif
            }
        });
    </script>
@endsection
