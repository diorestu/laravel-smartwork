@extends('layouts.mobile')

@section('title')Cuti | Smartwork @endsection

@push('addon-style')
<style>
    .no-border td { border: none; }
    .damas { background-color: #f2f2f2; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Cuti</h2>
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
    <section class="p-2">
        <div class="card bg-light text-white text-center p-2 mb-2">
            <blockquote class="card-blockquote font-size-14 mb-0">
                <p class="mb-0 text-muted">Cuti Tahunan</p>
                <h2>11 Hari</h2>
                <span class="text-dark font-size-12 mb-0">
                    <i class="fa fa-calendar-alt"></i>&nbsp; 2 hari terpakai
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <i class="fa fa-calendar-alt"></i>&nbsp; 10 hari sisa
                </span>
            </blockquote>
        </div>

        <div class="card mb-2">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <input class="form-control" type="month" value="{{ "2019-08" }}" id="example-month-input">
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <a href="{{ route("cuti.create") }}" class="btn btn-primary waves-effect btn-label waves-light fw-light w-100"><i class="label-icon fa fa-plus-circle"></i>&nbsp; Request Cuti</a>
                </div>
            </div>
        </div>


        <div class="ms-4" data-aos="fade-right" data-aos-duration="700">
            <div class="d-flex flex-row flex-nowrap overflow-auto example">
                <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                    <div class="card-body py-2 px-3">
                        <h3 class="fw-bold font-size-16 mt-1">Cuti</h3>
                        <span class="font-size-22 fw-black">{{ $cuti }}</span>
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
                        <span class="font-size-22 fw-black">{{ $sakit }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <section class="px-4">
        <div class="">
            <div class="d-flex justify-content-between align-items-baseline">
                <h4 class="mb-3">Cuti Saya</h4>
                <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i
                        class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div>
                @forelse($data as $item)
                    <div class="alert alert-secondary alert-top-border fade show mb-3" role="alert">
                        <div class="d-flex align-items-center justify-content-start">
                            <i class="fa fa-info-circle fa-lg text-primary align-middle me-3"></i>
                            <div>
                                <strong>{{ tglIndo2($item->cuti_awal) }} - {{ tglIndo2($item->cuti_akhir) }}</strong>
                                <br>
                                <span class="">{{ $item->cuti_deskripsi }}</span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="card rounded py-5 rounded">
                        <div class="d-flex justify-content-center align-self-center">
                            <div class="text-center">
                                <a class="text-muted">Tidak ada riwayat pengajuan</a>
                                <br>
                                <a class="fw-bold btn btn-primary py-1 mt-2" href="{{ route('cuti.create') }}">Tambah
                                    Pengajuan Cuti</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
