@extends('layouts.main')

@section('title')
    Smartwork Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card card-h-100 rounded-xs">
                <div class="card-body bg-dashboard" style="background-image: url('{{ asset('backend-assets/images/bg_dashboard.png') }}')">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="font-size-20 fw-bold mb-1 d-block text-truncate">Halo, {{ Auth::user()->nama }}</span>
                            <p class="text-muted mb-3">Hari ini, 25 Juni 2022</p>
                            <p class="text-muted mb-3">Semoga pekerjaanmu hari ini jadi lebih ringan ya!</p>
                            <h5 class="mt-4">Shortcut</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-smile label-icon"></i> Primary</button>
                                <button type="button" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-check-double label-icon"></i> Success</button>
                                <button type="button" class="btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-error label-icon"></i> Warning</button>
                                <button type="button" class="btn btn-danger waves-effect btn-label waves-light"><i class="bx bx-block label-icon"></i> Danger</button>
                                <button type="button" class="btn btn-dark waves-effect btn-label waves-light"><i class="bx bx-loader label-icon"></i> Dark</button>
                                <button type="button" class="btn btn-light waves-effect btn-label waves-light"><i class="bx bx-hourglass label-icon"></i> Light</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-3">
            <div class="card card-h-100 rounded-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 d-block text-truncate">Total Pegawai</span>
                            <h4 class="mb-2">
                                <span class="counter-value" data-target="84">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary px-2 py-1">Lihat Semua</span>
                                {{-- <span class="ms-1 text-muted font-size-13">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="card card-h-100 rounded-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 d-block text-truncate">Total Lokasi Kerja</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="3">-10</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary px-2 py-1">Lihat Semua</span>
                                {{-- <span class="ms-1 text-muted font-size-13">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="card card-h-100 rounded-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 d-block text-truncate">Pengajuan Cuti</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="1">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary px-2 py-1">Lihat Semua</span>
                                {{-- <span class="ms-1 text-muted font-size-13">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="card card-h-100 rounded-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 d-block text-truncate">Pengajuan Cuti</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="1">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary px-2 py-1">Lihat Semua</span>
                                {{-- <span class="ms-1 text-muted font-size-13">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card rounded-sm">
                <div class="card-body">
                    <span class="text-muted mb-3 d-block text-truncate">Total Pegawai Per Cabang</span>
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card rounded-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 d-block text-truncate">Total Pegawai</span>
                            <h4 class="mb-2">
                                <span class="counter-value" data-target="84">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary px-2 py-1">Lihat Semua</span>
                                {{-- <span class="ms-1 text-muted font-size-13">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card rounded-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 d-block text-truncate">Total Pegawai</span>
                            <h4 class="mb-2">
                                <span class="counter-value" data-target="84">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary px-2 py-1">Lihat Semua</span>
                                {{-- <span class="ms-1 text-muted font-size-13">Since last week</span> --}}
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
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user"></i> &nbsp;Profil</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user-plus"></i> &nbsp;Tambah Pegawai</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user-plus"></i> &nbsp;Buat Pengumuman</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user-plus"></i> &nbsp;Lihat Jadwal Kerja</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="user-plus"></i> &nbsp;Input Absensi</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="credit-card"></i> &nbsp;Buat Payroll</span>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" class="py-2 px-2 list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="font-size-12"><i class="w-18" data-feather="key"></i> &nbsp;Ubah Kata Sandi</span>
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
                            <img class="d-block img-fluid mx-auto" src="assets/images/small/img-3.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid mx-auto" src="assets/images/small/img-2.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid mx-auto" src="assets/images/small/img-1.jpg" alt="Third slide">
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
                <div class="card-header bg-transparent border-bottom py-3">
                   <h4 class="card-title ms-0">Pengumuman Terbaru</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Peringatan Cuti Bersama PT. Asta Pijar Kreasi</h6>
                            <small>3 days ago</small>
                            </div>
                            <small>Ditujukan kepada divisi IT</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">List group item heading</h6>
                            <small class="text-muted">3 days ago</small>
                            </div>
                            <small class="text-muted">And some muted small print.</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">List group item heading</h6>
                            <small class="text-muted">3 days ago</small>
                            </div>
                            <small class="text-muted">And some muted small print.</small>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <a href="javascript: void(0);" class="card-link">Lihat Semua Pengumuman</a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-custom gutter-b rounded-xs shadow-md">
                <div class="card-header bg-transparent border-bottom py-3">
                   <h4 class="card-title ms-0">Jatah Cuti Tahunan</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <h2>11 Hari</h1>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                </ul>
                <div class="card-footer bg-transparent border-top text-muted">
                    <a href="javascript: void(0);" class="card-link">Lihat Detail</a>
                </div>
            </div>
            <div class="card card-custom gutter-b rounded-xs shadow-md">
                <div class="card-header bg-transparent border-bottom py-3">
                   <h4 class="card-title ms-0">Download Smartwork</h4>
                </div>
                <div class="card-body px-3 py-3">
                    <h2>11 Hari</h1>
                </div>
            </div>
        </div>
    </div>
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
@endsection
