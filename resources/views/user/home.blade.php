@extends('layouts.mobile-navbar')

@section('title')
    Halaman Beranda Pengguna
@endsection

@push('addon-style')
    <style>
        .rounded-top-sm{
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    </style>
@endpush

@section('content')
    {{-- @php
    if ($absen ?? '' == 'Nihil' || !$absen ?? '') {
        $hadir  = '-';
        $pulang = '-';
    }elseif(!$absen ?? ''->jam_pulang){
        $hadir  = TampilJamMenit($absen ?? ''->jam_hadir);
        $pulang = '-';
    }else{
        $hadir  = TampilJamMenit($absen ?? ''->jam_hadir);
        $pulang = TampilJamMenit($absen ?? ''->jam_pulang);
    }
    @endphp --}}
    <section class="p-0">
        <div class="ps-5 pe-4 pb-5 pt-3" style="background-color: #B0141C !important;">
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
        <div class="parent mb-10">
            <div class="child-float rounded mt-5 px-4">
                <div class="card rounded-sm">
                    <div class="card-body py-3">
                        <div class="text-center mb-4">
                            <b class="fw-bold font-size-h3">{{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</b>
                        </div>
                        <div class="d-flex justify-content-between text-white px-4">
                            <div class="rounded text-center">
                                <a class="btn btn-primary px-4">Hadir</a>
                                {{-- <span class='font-size-18 fw-bold'>07.00</span> --}}
                            </div>
                            <div class="rounded text-center">
                                <a class="btn btn-primary px-4">Pulang</a>
                                {{-- <span class='font-size-18 fw-bold'>07.00</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="ms-4 mt-4" data-aos="fade-right" data-aos-duration="700">
        <div class="d-flex flex-row flex-nowrap overflow-auto example">
            {{-- <div class="card rounded-sm me-3" style="min-height: 70px; min-width:150px;">
                <img class="card-img-top img-fluid rounded-top-sm" src="{{ asset('backend-assets/images/small/img-2.jpg') }}"
                    alt="Card image cap">
                <div class="card-body">
                    <h3 class="fw-bold me-3">Izin</h3>
                    <span class="dispsay-3 font-weight-boldest">0</span>
                </div>
            </div> --}}
            <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <h3 class="fw-bold font-size-16 mt-1">Cuti</h3>
                    <span class="font-size-22 fw-black">0</span>
                </div>
            </div>
            <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <h3 class="fw-bold font-size-16 mt-1">Izin</h3>
                    <span class="font-size-22 fw-black">0</span>
                </div>
            </div>
            <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <h3 class="fw-bold font-size-16 mt-1">Sakit</h3>
                    <span class="font-size-22 fw-black">0</span>
                </div>
            </div>
        </div>
    </div>

    <section class="px-4">
        <div class="mt-3">
            <style>
                .menu{
                    min-height: 95px !important;
                }
            </style>
            <h4 class="mb-3 fw-bold">Menu Utama</h4>
            {{-- <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i class="fa fa-chevron-right icon-xs text-peimary fw-bold"></i></a> --}}
            <div class="row">
                <div class="col-4 px-2">
                    <a href="{{ route('user.profil') }}" class="card rounded-sm text-muted">
                        <div class="card-body px-2 py-3 d-flex flex-column align-items-center">
                            <span class='mb-2'><i data-feather='user'></i></span>
                            <span class="badge badge-soft-primary">Profil Saya</span>
                        </div>
                    </a>
                </div>
                <div class="col-4 px-2">
                    <a href="{{ route('user.pass') }}" class="card rounded-sm text-muted">
                        <div class="card-body px-2 py-3 d-flex flex-column align-items-center">
                            <span class='mb-2'><i data-feather='lock'></i></span>
                            <span class="badge badge-soft-danger">Ganti Kata Sandi</span>
                        </div>
                    </a>
                </div>
                <div class="col-4 px-2">
                    <a href="{{ route('absen.index') }}" class="card rounded-sm text-muted">
                        <div class="card-body px-2 py-3 d-flex flex-column align-items-center">
                            <span class='mb-2'><i data-feather='clock'></i></span>
                            <span class="badge badge-soft-primary">Absensi</span>
                        </div>
                    </a>
                </div>
                <div class="col-4 px-2">
                    <div class="card rounded-sm text-muted">
                        <div class="card-body px-2 py-3 d-flex flex-column align-items-center">
                            <span class='mb-2'><i data-feather='calendar'></i></span>
                            <span class="badge badge-soft-primary">Cuti & Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-4 px-2">
                    <div class="card rounded-sm text-muted">
                        <div class="card-body px-2 py-3 d-flex flex-column align-items-center">
                            <span class='mb-2'><i data-feather='activity'></i></span>
                            <span class="badge badge-soft-success">Aktivitas</span>
                        </div>
                    </div>
                </div>
                <div class="col-4 px-2">
                    <div class="card rounded-sm text-muted">
                        <div class="card-body px-2 py-3 d-flex flex-column align-items-center">
                            <span class='mb-2'><i data-feather='file-minus'></i></span>
                            <span class="badge badge-soft-success">Slip Gaji</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="px-4">
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-baseline">
                <h4 class="mb-3">Aktivitas Saya</h4>
                <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div>
                <div class="alert alert-secondary alert-top-border fade show mb-2" role="alert">
                    <i class="fa fa-info-circle text-primary align-middle me-3"></i><strong>22/12/2022</strong> - Absen Hadir
                </div>
                <div class="alert alert-secondary alert-top-border fade show mb-2" role="alert">
                    <i class="fa fa-info-circle text-primary align-middle me-3"></i><strong>22/12/2022</strong> - Absen Hadir
                </div>
                <div class="alert alert-secondary alert-top-border fade show mb-2" role="alert">
                    <i class="fa fa-info-circle text-primary align-middle me-3"></i><strong>22/12/2022</strong> - Absen Hadir
                </div>
            </div>
        </div>
    </section> --}}
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    {{-- <div class="px-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img class="card-img img-fluid" src="{{ asset('backend-assets/images/small/img-2.jpg') }}" alt="Card image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('addon-script')
<script>
    $(function(){
        $('#btn-logout').click(function(){
            if(confirm('Anda akan keluar dari Aplikasi, lanjutkan?')) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
                return false;
        });
    });
</script>
@endpush

