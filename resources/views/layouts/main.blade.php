<!doctype html>
<html lang="en">

<head>
    @include('includes.meta')
    <title>@yield('title')</title>
    @include('includes.style')
    @stack('addon-style')
    <style>
        .img-cropped {
            object-fit: cover;
            object-position: center center;
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body data-layout="horizontal" data-key="body" data-layout-mode="{{ auth()->user()->config->layout_mode == 'dark' ? 'dark' : 'light'  }}" data-topbar="dark">
    <div id="layout-wrapper">
        @include('includes.header')
        @include('includes.navigation')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('includes.footer')
        </div>
    </div>
    @include('includes.script')
    @stack('addon-script')
</body>

</html>
