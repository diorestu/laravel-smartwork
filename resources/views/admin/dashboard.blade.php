@extends('layouts.main')

@section('title')
    Smartwork Dashboard
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-1">
        <span class="font-size-20 fw-bold mb-3 d-block text-truncate">Hi, {{ Auth::user()->nama }}</span>
        <span class="text-muted mb-3 d-block text-truncate"></span>
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
        <div class="col-md-8 col-sm-12">
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
    </div>
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
@endsection
