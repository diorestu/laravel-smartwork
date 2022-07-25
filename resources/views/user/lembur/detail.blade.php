@extends('layouts.mobile')

@section('title')Detail Lembur | Smartwork @endsection

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
                    <h2 class="fw-bold font-size-18 text-white mb-0">Detail Lembur</h2>
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
            @if ($data->lembur_status == "DITOLAK")
            <div class="card-header bg-danger py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-block-helper me-2 font-size-20"></i><h6 class="my-0 text-white">LEMBUR DITOLAK</h6>
            </div>
            @elseif($data->lembur_status == "DITERIMA")
            <div class="card-header bg-success py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-check-circle me-2 font-size-20"></i><h6 class="my-0 text-white">LEMBUR DITERIMA</h6>
            </div>
            @else
            <div class="card-header bg-primary py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-cached me-2 font-size-20"></i><h6 class="my-0 text-white">PROSES PENGAJUAN LEMBUR</h6>
            </div>
            @endif
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text text-muted mb-1">{{ $data->user->cabang->cabang_nama }}</p>
                        <h5 class="card-title mb-1">{{ $data->user->nama }}</h5>
                        <p class="fw-light card-text text-muted">{{ $data->user->jabatan->jabatan_title }}</p>
                    </div>
                    <div>
                        <img src="{{ $data->user->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $data->user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card mx-2 rounded mb-3">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Judul Lembur</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->lembur_judul }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Periode Lembur</span>
                            </div>
                            <div class="col-8 px-1">
                                @php
                                    $awal   = tglIndo4($data->lembur_awal);
                                    $akhir  = tglIndo4($data->lembur_akhir);
                                @endphp
                                <span>
                                @if ($awal!=$akhir)
                                    {{ tglIndo4($data->lembur_awal) }} - {{ tglIndo4($data->lembur_akhir) }}
                                @else
                                    {{ tglIndo4($data->lembur_awal) }}
                                @endif
                                </span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Waktu Lembur</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ TampilJamMenit($data->lembur_awal) }} - {{ TampilJamMenit($data->lembur_akhir) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Jam Lembur</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->jam_lembur }} jam</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Deskripsi</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->lembur_keterangan }}</span>
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
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Status Lembur</span>
                            </div>
                            <div class="col-8 px-1">
                                @if ($data->lembur_status == "DITOLAK")
                                    <p class="fw-regular font-size-12 text-danger mb-1">{{ $data->lembur_status }}</p>
                                @elseif($data->lembur_status == "DITERIMA")
                                    <p class="fw-regular font-size-12 text-success mb-1">{{ $data->lembur_status }}</p>
                                @else
                                    <p class="fw-regular font-size-12 text-primary mb-1">{{ $data->lembur_status }}</p>
                                @endif
                            </div>
                        </div>
                    </li>
                    @if ($data->approve_date != null)
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Disetujui pada</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ tanggalIndo($data->approve_date) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Disetujui Oleh</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ namaUser($data->approve_by) }}</span>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        @if ($data->approve_date == null)
        <div class="card mx-2 mt-0 mb-3">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <form action="{{ route('overtime.destroy', $data->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger text-white waves-effect btn-label waves-light fw-bold w-100">
                            <i class="label-icon fa fa-ban"></i>
                            &nbsp; Batalkan Permohonan Lembur
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="timeline">
            <div class="timeline-container">
                <div class="timeline-continue p-0">
                    <div class="row timeline-right">
                        <div class="col-md-6">
                            <div class="timeline-box mt-0 p-3">
                                <div class="timeline-date bg-primary text-center rounded">
                                    <h3 class="text-white mb-0 font-size-16">{{ TanggalOnly($data->created_at) }}</h3>
                                    <p class="mb-0 text-white-50">{{ BulanOnly($data->created_at) }}</p>
                                </div>
                                <div class="event-content">
                                    <div class="timeline-text">
                                        <h3 class="font-size-14 mb-0">Pengajuan lembur</h3>
                                        <p class="font-size-11 mb-0 mt-1 pt-0 text-muted">
                                            Lembur diajukan oleh {{ $data->user->nama }} pada hari {{ tanggalIndo($data->created_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($data->approve_date != null)
                    <div class="row timeline-right">
                        <div class="col-md-6">
                            <div class="timeline-box mt-3 p-3">
                                <div class="timeline-date bg-success text-center rounded">
                                    <h3 class="text-white mb-0 font-size-16">{{ TanggalOnly($data->approve_date) }}</h3>
                                    <p class="mb-0 text-white-50">{{ BulanOnly($data->approve_date) }}</p>
                                </div>
                                <div class="event-content">
                                    <div class="timeline-text">
                                        <h3 class="font-size-14 mb-0">Lembur <span class="text-lowercase">{{ $data->lembur_status }}</span></h3>
                                        <p class="font-size-11 mb-0 mt-1 pt-0 text-muted">
                                            Lembur <span class="text-lowercase">{{ $data->lembur_status }}</span> oleh {{ namaUser($data->approve_by) }} pada hari {{ tanggalIndo($data->approve_date) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
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
