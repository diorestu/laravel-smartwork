<!doctype html>
<html lang="en">

<head>
    @include('includes.meta')
    <title>@yield('title')</title>
    <style>
        .parent {
            position: relative;
        }

        .child-float {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .example::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .example {
          -ms-overflow-style: none;  /* IE and Edge */
          scrollbar-width: none;  /* Firefox */
        }
    </style>
    @include('includes.style')
    @stack('addon-style')
    @livewireStyles

</head>

<body data-layout="horizontal" data-key="body" data-layout-mode="light" data-topbar="dark">
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start Content here -->
        <div class="main-content">
            @yield('content')
        </div>
        <!-- End Content here -->
        <!-- ============================================================== -->
    </div>
    @include('includes.script')
    @stack('addon-script')
    @livewireScripts
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
