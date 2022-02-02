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
          -ms-overflow-style: none;  /* IE and Edge */
          scrollbar-width: none;  /* Firefox */
        }
    </style>
    @include('includes.style')
    @stack('addon-style')

</head>

<body data-layout="horizontal" data-key="body" data-layout-mode="light" data-topbar="dark">
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start Content here -->
        <div class="main-content">
            @yield('content')
            <div class="card fixed-bottom shadow mb-0">
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <a href='{{ route('user.home') }}' class=" text-muted d-flex flex-column align-items-center">
                            <span class='mb-2 {{ request()->is('user') ? 'text-danger' : '' }}'><i data-feather='home'></i></span>
                            <span class="{{ request()->is('user') ? 'text-danger' : 'text-muted' }}">Home</span>
                        </a>
                        <a href='{{ route('absen.index') }}' class=" text-muted d-flex flex-column align-items-center">
                            <span class='mb-2 {{ request()->is('user/absen*') ? 'text-danger' : '' }}'><i data-feather='clock'></i></span>
                            <span class="{{ request()->is('user/absen*') ? 'text-danger' : 'text-muted' }}">Absen</span>
                        </a>
                        <a href='{{ route('kegiatan.index') }}' class=" text-muted d-flex flex-column align-items-center">
                            <span class='mb-2 {{ request()->is('user/aktif*') ? 'text-danger' : '' }}'><i data-feather='activity'></i></span>
                            <span class="{{ request()->is('user/aktif*') ? 'text-danger' : 'text-muted' }}">Aktivitas</span>
                        </a>
                        <a href='{{ route('cuti.index') }}' class=" text-muted d-flex flex-column align-items-center">
                            <span class='mb-2 {{ request()->is('user/cuti*') ? 'text-danger' : '' }}'><i data-feather='calendar'></i></span>
                            <span class="{{ request()->is('user/cuti*') ? 'text-danger' : 'text-muted' }}">Cuti</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content here -->
        <!-- ============================================================== -->
    </div>
    @include('includes.script')
    @stack('addon-script')
</body>

</html>
