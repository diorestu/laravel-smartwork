@extends('layouts.mobile-navbar')

@section('title')Profil Saya | Smartwork @endsection

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Akun Saya</h2>
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
            <h5 class="mb-2">Info Personal</h5>
            <a href="{{ route('user.data') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-user-circle icon-profil text-primary"></i>
                        <span>Informasi Personal</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('user.infoPegawai') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-user-rectangle icon-profil text-info"></i>
                        <span>Informasi Pegawai</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('user.infoPayroll') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-dollar-circle icon-profil text-danger"></i>
                        <span>Informasi Payroll</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('schedule.index') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-calendar icon-profil text-success"></i>
                        <span class="">Jadwal Kerja</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="{{ route('payslip.index') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-wallet icon-profil text-warning"></i>
                        <span class="">Slip Gaji</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <hr>
            <h5>Pengaturan</h5>
            <a href="{{ route('user.pass') }}" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-lock icon-profil" style="color:#a238d6;"></i>
                        <span class="">Ubah Kata Sandi</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="#" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-info-circle icon-profil text-danger"></i>
                        <span class="">Bantuan</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="#" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bx-question-mark icon-profil text-dark"></i>
                        <span class="">FAQ</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <a href="#" class="text-dark text-decoration-none w-100">
                <div class="d-flex justify-content-between align-items-center py-1 mb-2">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-message-square-dots icon-profil text-success"></i>
                        <span class="">Hubungi Admin</span>
                    </div>
                    <span><i class="fa fa-chevron-right"></i></span>
                </div>
            </a>
            <hr>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="bg-transparent border-0 d-flex justify-content-between align-items-center ps-0 pe-2 py-2 mb-1 w-100" type="submit">
                    <div class="d-flex justify-content-between">
                        <i class="bx bxs-log-out icon-profil text-danger"></i>
                        <span class="fw-semibold text-danger">Keluar</span>
                    </div>
                </button>
            </form>
            <br>
            <p class="text-center fw-light text-primary">Smartwork App Versi 2.1001 (Dev)</p>
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
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
        // Swal.fire('Berhasil', '{{ \Session::get('success') }}', 'success')
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
        // Swal.fire('Gagal', '{{ \Session::get('error') }}', 'error')
    </script>
@endif
@endpush
