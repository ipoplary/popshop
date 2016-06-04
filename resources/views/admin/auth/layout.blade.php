<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Popshop | @yield('title')</title>

    {{-- Tell the browser to be responsive to screen width --}}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {{-- admin.css--}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

</head>

<body class="hold-transition login-page">

    @yield('content')

    {{-- admin.js --}}
    <script src="{{ asset('assets/js/admin.js') }}"></script>

    {{-- sweetalert.min.js --}}
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    @yield('script')
</body>
</html>
