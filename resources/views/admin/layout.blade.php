<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>PopShop | @yield('title')</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ elixir('assets/css/admin.css') }}">

    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        {{-- Site wrapper --}}
        <div class="wrapper">
            <header class="main-header">
                {{-- Logo --}}
                <a href=" {{ url('home') }} " class="logo">

                    {{-- logo for regular state and mobile devices --}}
                    <span class="logo-lg"><b>Pop</b>Shop</span>
                </a>
                {{-- Header Navbar: style can be found in header.less --}}
                <nav class="navbar navbar-static-top">
                    {{-- Sidebar toggle button--}}
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            {{-- User Account: style can be found in dropdown.less --}}
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="hidden-xs">{{ isset(Auth::admin()->user()->name)? Auth::admin()->user()->name: '' }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    {{-- Menu Footer--}}
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href=" {{ url('logout') }} " class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>


            {{-- =============================================== --}}

            {{-- Left side column. contains the sidebar --}}
            <aside class="main-sidebar">
                {{-- sidebar: style can be found in sidebar.less --}}
                <section class="sidebar">
                    {{-- sidebar menu: : style can be found in sidebar.less --}}
                    <ul class="sidebar-menu">
                        <li class="header">导航</li>
                        <li>
                            <a href=" {{ url('home') }} ">
                                <i class="fa fa-home"></i> <span>主页</span>
                            </a>
                        </li>
                        <li>
                            <a href=" {{ url('category') }} ">
                                <i class="fa fa-tags"></i> <span>类别</span>
                            </a>
                        </li>
                        <li>
                            <a href=" {{ url('product') }} ">
                                <i class="fa fa-gift"></i> <span>商品</span>
                            </a>
                        </li>
                        <li>
                            <a href=" {{ url('order') }} ">
                                <i class="fa fa-reorder"></i> <span>订单</span>
                            </a>
                        </li>
                        <li>
                            <a href=" {{ url('user') }} ">
                                <i class="fa fa-user"></i> <span>用户</span>
                            </a>
                        </li>
                    </ul>
                </section>
                {{-- /.sidebar --}}
            </aside>

            {{-- =============================================== --}}

            {{-- Content Wrapper. Contains page content --}}
            <div class="content-wrapper">
                {{-- Content Header (Page header) --}}
                <section class="content-header">
                    <h1>
                        @yield('title')
                    </h1>
                </section>
                {{-- Main content --}}
                <section class="content">
                   {{-- Default box --}}
                    <div class="box">

                        <div class="box-body" id="@yield('app')">
                            @yield('content')
                        </div>
                        {{-- /.box-body --}}
                    </div>
                    {{-- /.box --}}
                </section>
                {{-- /.content --}}
            </div>

        <div class="control-sidebar-bg"></div>
    </div>
    {{-- ./wrapper --}}

    {{-- js --}}
    <script src=" {{ elixir('assets/js/admin.js') }} "></script>


    @yield('script')
  </body>
</html>