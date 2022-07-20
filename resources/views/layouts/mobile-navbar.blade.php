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
        .swal2-container .swal2-title {
            font-size: 13px !important;
        }
        .swal2-popup {
            max-width: 15em !important;
        }
        .swal2-icon {
            width: 4em !important;
            height: 4em !important;
        }
    </style>
    @include('includes.style')
    @stack('addon-style')
</head>
<body data-layout="horizontal" data-key="body" data-layout-mode="light" data-topbar="dark">
    <div id="layout-wrapper">
        <div class="main-content">
            @yield('content')
            <livewire:navbar>
        </div>
    </div>
    @include('includes.script')
    @stack('addon-script')
</body>
</html>
