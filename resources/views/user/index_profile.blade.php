@extends('layouts.mobile-navbar')

@section('title')
    Profil Saya
@endsection
{{--
@push('addon-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush --}}

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4 pb-3 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Hai, {{ $id->nama }}</h2>
                    <p class="text-white-50 fw-light font-size-12">{{ $id->company }}</p>
                </div>
                <div class=''>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                    <a class='btn ms-3 text-white' id="btn-logout"><i data-feather="log-out"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="p-4">
            <a href="{{ route('user.data') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">Ubah Profil</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('user.pass') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">Pengaturan Akun</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="/" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">Jadwal Kerja</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('user.gaji') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">Slip Gaji</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <hr>
            <a href="/" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">Bantuan</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="/" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">FAQ</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="/" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                    <span class="fw-semibold">Lend App</span>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <hr>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="bg-transparent border-0 d-flex justify-content-between align-items-center ps-0 pe-2 py-2 mb-1 w-100" type="submit">
                    <span class="fw-semibold text-danger">Keluar</span>
                    <span><i class="fa fa-sign-out-alt text-danger"></i></span>
                </button>
            </form>
        </div>
    </section>
@endsection

@push('addon-script')
    <script>
        $(function() {
            $('#btn-logout').click(function() {
                if (confirm('Anda akan keluar dari Aplikasi, lanjutkan?')) {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                }
                return false;
            });
        });
    </script>
@endpush
