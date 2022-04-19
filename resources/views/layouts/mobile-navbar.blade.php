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

        .child {
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translate(-50%, -30%);
            width: 100%;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .example::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .example {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

    </style>
    @livewireStyles
    @include('includes.style')
    @stack('addon-style')

    @livewireScripts
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
    data-turbolinks-eval="false" data-turbo-eval="false"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</head>

<body data-layout="horizontal" data-key="body" data-layout-mode="light" data-topbar="dark">
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start Content here -->
        <div class="main-content">
            @yield('content')
            <livewire:navbar>
        </div>
        <!-- End Content here -->
        <!-- ============================================================== -->
    </div>
    @include('includes.script')
    @stack('addon-script')
</body>

</html>
