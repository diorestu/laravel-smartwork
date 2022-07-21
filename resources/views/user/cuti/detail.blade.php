@extends('layouts.mobile')

@section('title')Detail Cuti | Smartwork @endsection

@push('addon-style')
@endpush

@section('content')
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Detail Cuti</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2 m-0">
        <div class="card mb-0">
            @if ($data->cuti_status == "DITOLAK")
            <div class="card-header bg-danger py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-block-helper me-2 font-size-20"></i><h6 class="my-0 text-white">CUTI DITOLAK</h6>
            </div>
            @elseif($data->cuti_status == "DITERIMA")
            <div class="card-header bg-success py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-check-circle me-2 font-size-20"></i><h6 class="my-0 text-white">CUTI DITERIMA</h6>
            </div>
            @else
            <div class="card-header bg-primary py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-cached me-2 font-size-20"></i><h6 class="my-0 text-white">PROSES PENGAJUAN</h6>
            </div>
            @endif
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text text-muted mb-1">PT. Asta Pijar Kreasi</p>
                        <h5 class="card-title mb-1">Ni Komang Karina Wardani</h5>
                        <p class="fw-light card-text text-muted">Staff Marketing</p>
                    </div>
                    <div>
                        <img src="{{ asset('backend-assets/images/no-staff.jpg') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card mx-2 rounded">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Jenis Cuti</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->cutiJenis->cuti_nama_jenis }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Periode Cuti</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ tglIndo4($data->cuti_awal) }} - {{ tglIndo4($data->cuti_akhir) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Hari Cuti</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>Tipe</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Deskripsi</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->cuti_deskripsi }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Diajukan Pada</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ tanggalIndo($data->created_at) }}</span>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </section>
@endsection

@push('addon-script')
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
    </script>
@endif
@endpush
