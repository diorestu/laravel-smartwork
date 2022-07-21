@extends('layouts.main')

@section('title')
    Smartwork Dashboard
@endsection

@push('addon-style')
    <style>
        .card-header-merah { background:#B0141C !important; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card card-h-100 rounded-xs">
                <div class="card-body bg-dashboard" style="background-image: url('{{ asset('backend-assets/images/bg_dashboard2.png') }}')">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="font-size-20 fw-bold mb-1 d-block text-truncate">Halo, {{ Auth::user()->nama }}</span>
                            <p class="text-muted mb-3">Hari ini, 25 Juni 2022</p>
                            <p class="text-muted mb-3"><em>Semoga pekerjaanmu hari ini jadi lebih ringan ya!</em></p>
                            <h5 class="mt-4">Shortcut</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-time label-icon"></i> Lihat Absensi</button>
                                <button type="button" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-check-double label-icon"></i> Lihat Lembur</button>
                                <button type="button" class="btn btn-danger waves-effect btn-label waves-light"><i class="bx bx-calendar label-icon"></i> Lihat Cuti</button>
                                <button type="button" class="btn btn-dark waves-effect btn-label waves-light"><i class="bx bx-money label-icon"></i> Lihat Penggajian</button>
                                <button type="button" class="btn btn-light waves-effect btn-label waves-light"><i class="bx bx-menu label-icon"></i> Proses Rekrutmen</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Pegawai</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $user }}">0</span> pegawai
                            </h4>
                            <div class="text-nowrap">
                                <a href="{{ route('pegawai.index') }}" class="badge bg-soft-success text-success">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Lokasi Kerja</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $cabang }}">0</span> lokasi kerja
                            </h4>
                            <div class="text-nowrap">
                                <a href="{{ route('cabang.index') }}" class="badge bg-soft-warning text-warning">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Pengajuan Cuti</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $cuti }}">0</span> pengajuan
                            </h4>
                            <div class="text-nowrap">
                                <a href="{{ route('cuti.index') }}" class="badge bg-soft-danger text-danger">Lihat Detail</a>
                                <span class="ms-1 text-muted font-size-13">pengajuan hari ini</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Permohonan Lembur</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $lembur }}">0</span> permohonan
                            </h4>
                            <div class="text-nowrap">
                                <a href="{{ route('lembur.index') }}" class="badge bg-soft-primary text-primary">Lihat Detail</a>
                                <span class="ms-1 text-muted font-size-13">permohonan hari ini</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="card card-custom gutter-b rounded-xs shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                   <h4 class="card-title ms-0">Menu Cepat</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <div class="list-group list-group-flush mb-3">
                        <a href="{{ route('admin.profile') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user"></i> &nbsp;&nbsp;Profil</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('pegawai.index', '#btnModal') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user-plus"></i> &nbsp;&nbsp;Tambah Pegawai</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('pengumuman.create') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="bell"></i> &nbsp;&nbsp;Buat Pengumuman</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('jadwal.index') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="calendar"></i> &nbsp;&nbsp;Lihat Jadwal Kerja</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('absensi.create') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="clock"></i> &nbsp;&nbsp;Input Absensi</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('absensi.index') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="clock"></i> &nbsp;&nbsp;Absensi Hari Ini</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('payroll.create') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="credit-card"></i> &nbsp;&nbsp;Buat Payroll</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('config.index') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="settings"></i> &nbsp;&nbsp;Pengaturan</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.ubahPassword') }}" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="key"></i> &nbsp;&nbsp;Ubah Kata Sandi</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-custom gutter-b rounded-xs shadow-sm">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <div class="d-flex">
                                <img class="d-block img-fluid" height="166px" src="{{ asset("backend-assets/images/dashboard/ewa.png") }}" alt="Earn Wage Access">
                                <div class="my-4">
                                    <h3 class="mt-0 mb-2">Aktifkan Earn Wage Access</h3>
                                    <span>Akses gaji fleksibel untuk hilangkan stres finansial pegawai</span>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex">
                                <img class="d-block img-fluid" height="166px" src="{{ asset("backend-assets/images/dashboard/dark.png") }}" alt="Earn Wage Access">
                                <div class="my-4">
                                    <h3 class="mt-0 mb-2">Mode Gelap Kini Sudah Hadir</h3>
                                    <span>Untuk menghilangkan dan memanjakan mata Anda</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="card card-custom gutter-b rounded-xs shadow-sm">
                <div class="card-header card-header-merah border-bottom py-3">
                   <h4 class="card-title text-white mb-0 ms-0">Pengumuman Terbaru</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <div class="list-group">
                        @forelse ($notif as $n)
                            <a href="{{ route('pengumuman.show', $n->id) }}" class="list-group-item list-group-item-action" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $n->judul_pengumuman }}</h6>
                                    <small>{{ Carbon\Carbon::parse($n->created_at)->diffForHumans(now()) }}</small>
                                </div>
                                <small>{!! $n->desc_pengumuman !!}</small>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <a href="{{ route('pengumuman.index') }}" class="card-link">Lihat Semua Pengumuman</a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-custom gutter-b rounded-xs shadow-md">
                <div class="card-header bg-transparent border-bottom py-3">
                   <h4 class="card-title ms-0">Jatah Cuti Tahunan</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <h2 class="mb-0">11 Hari</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{ route('cuti.create') }}" class="card-link btn btn-danger btn-sm"><i class="fa fa-paper-plane me-2"></i> Ajukan Cuti</a>
                    </li>
                </ul>
                <div class="card-footer bg-transparent border-top text-muted">
                    <a href="{{ route('cuti.index') }}" class="card-link fw-bold"><i class="fa fa-info-circle me-1"></i> Lihat Detail</a>
                </div>
            </div>
            <div class="card card-custom gutter-b rounded-xs shadow-md">
                <div class="card-header bg-transparent border-bottom py-3">
                   <h4 class="card-title ms-0">Download Smartwork</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <div class="col-8 mx-auto">
                        <img class="d-block w-100 img-responsive" src="{{ asset("backend-assets/images/mobile/playstore.png") }}" alt="">
                    </div>
                    <div class="col-8 mx-auto">
                        <img class="d-block w-100 img-responsive" src="{{ asset("backend-assets/images/mobile/appstore.png") }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
