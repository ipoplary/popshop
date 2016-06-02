@extends('admin.authLayout')

@section('title', 'Register')

@section('content')
    <div class="register-box">
        <div class="register-logo">
            <b>Pop</b>Shop
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new admin</p>

            {!! Form::open(['url' => 'register']) !!}

                <div class="form-group has-feedback">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Retype password']) !!}
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                    </div>

                    <div class="col-xs-4">
                        {!! Form::submit('Register', ['class' => 'btn btn-primary btn-block btn-flat']) !!}
                    </div>

                </div>

            {!! Form::close() !!}

            <a href="{{ url('login') }}" class="text-center">I already have a membership</a>
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
