@extends('layouts.mobile-navbar')

@section('title')
    Profil Saya
@endsection

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Profil Saya</h2>
                </div>
                <div class=''>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="col-xl-12 col-sm-12">
            <div class="card mb-1">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="{{ $id->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $data_user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-1 ms-3">
                            <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $id->nama }}</a></h5>
                            <p class="text-muted mb-0">@if ($id->id_jabatan != null) {{ $id->jabatan->jabatan_title }} @endif</p>
                            <p class="text-muted mb-0"><small>{{ $id->company }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="p-4">
            <h5 class="mb-3">Info Personal</h5>
            <a href="{{ route('user.data') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-0">
                    <div>
                        <i class="mdi mdi-account-box icon-profil" style="color: #d63c3c;"></i>
                        <span class="">Informasi Personal</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('user.jadwal') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-0">
                    <div>
                        <i class="mdi mdi-calendar-clock icon-profil" style="color: #8213ba;"></i>
                        <span class="">Jadwal Kerja</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('user.gaji') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-0">
                    <div>
                        <i class="mdi mdi-wallet icon-profil" style="color: #1874d6;"></i>
                        <span class="">Slip Gaji</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <hr>
            <h5>Pengaturan</h5>
            <a href="{{ route('user.pass') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-0">
                    <div>
                        <i class="mdi mdi-account-key icon-profil" style="color: #1abd69;"></i>
                        <span class="">Ubah Kata Sandi</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="/" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-0">
                    <div>
                        <i class="mdi mdi-information icon-profil" style="color: #ffc400;"></i>
                        <span class="">Bantuan</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="/" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-0">
                    <div>
                        <i class="mdi mdi-account-question icon-profil" style="color: #bf411b;"></i>
                        <span class="">FAQ</span>
                    </div>
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
