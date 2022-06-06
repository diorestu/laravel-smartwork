@extends('layouts.main')

@section('title')
    Ringkasan Absensi Pegawai | Smartwork App
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .f-10 { font-size: 10px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .text-tipis  { font-weight: 300; opacity: 0.5; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("laporan.absensi") }}">Absensi</a></li>
                        <li class="breadcrumb-item active">Ringkasan Absensi Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ringkasan Absensi Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Ringkasan absensi pegawai periode {{ tanggalIndo3($awal) }} sd {{ tanggalIndo3($akhir) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route("pegawai.show", $data_user->id) }}">Lihat Profil</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="{{ $data_user->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $data_user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-1 ms-3">
                            <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $data_user->nama }}</a></h5>
                            <p class="text-muted mb-0">{{ $data_user->divisi->div_title }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-1">
                        <p class="text-muted mb-0"><i class="icon-menu" data-feather="phone-call"></i>
                            {{ $data_user->phone }}</p>
                        <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="mail"></i>
                            {{ $data_user->email }}</p>
                        <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="home"></i>
                            {{ $data_user->cabang->cabang_nama }}</p>
                        <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="map-pin"></i>
                            {{ $data_user->alamat }}</p>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>

        <div class="col-8">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Hari Kerja</p>
                                    <p class="fw-bold">{{ $hari_kerja }} hari</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Hadir Tepat Waktu</p>
                                    <p class="fw-bold">{{ $tepat_waktu }} hari</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i>Hadir Terlambat</p>
                                    <p class="fw-bold">{{ $terlambat }} kali</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Tidak Hadir</p>
                                    <p class="fw-bold">{{ $mangkir }} hari</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Izin</p>
                                    <p class="fw-bold">{{ $cuti }} hari</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Cuti</p>
                                    <p class="fw-bold">{{ $cuti }} hari</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Cuti 1/2 Hari</p>
                                    <p class="fw-bold">n/a</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Unpaid Leave</p>
                                    <p class="fw-bold">n/a</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Bukan Hari Kerja</p>
                                    <p class="fw-bold">{{ $bukan_hari_kerja }} hari</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Sakit</p>
                                    <p class="fw-bold">{{ $sakit }} hari</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Lembur</p>
                                    <p class="fw-bold">{{ $lembur }} jam</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark"><i class="bx bx-unlink font-size-16 align-middle text-danger me-1"></i> Tugas Luar</p>
                                    <p class="fw-bold">n/a</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-warning text-black dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-download"></i>&nbsp; Download Informasi&nbsp; <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <li><a class="dropdown-item" href="#">File PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil','{{ \Session::get('success') }}','success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal','{{ \Session::get('error') }}','error')
        </script>
    @endif
@endpush





