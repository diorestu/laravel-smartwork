@extends('layouts.mobile')

@section('title')Pengajuan Lembur | Smartwork @endsection

@push('addon-style')
<style>
    .no-border { border: none !important; }
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
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Pengajuan Lembur</h2>
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
    <section>
        <form action="{{ route('overtime.store') }}" method="post" id="myForm">
            <div class="card m-2 rounded-sm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Waktu Awal Lembur <span class="text-danger">*</span></span>
                            <input id="lembur_awal" class="form-control text-dark mt-1" type="datetime-local" name="lembur_awal" required />
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Waktu Akhir Lembur <span class="text-danger">*</span></span>
                            <input id="lembur_akhir" class="form-control text-dark mt-1" type="datetime-local" name="lembur_akhir" required />
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Judul Lembur <span class="text-danger">*</span></span>
                            <input id="lembur_judul" class="form-control text-dark mt-1" name="lembur_judul" type="text" required />
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Keterangan Lembur <span class="text-danger">*</span></span>
                            <textarea id="lembur_keterangan" class="form-control text-dark mt-1" name="lembur_keterangan" cols="3" required></textarea>
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="font-size-11 text-danger">* merupakan field yang tidak boleh kosong</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col=12">
                <div class="fixed-bottom mb-0 card p-2">
                    <button type="submit" class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white">
                        <i class="label-icon fa fa-check-circle me-2"></i>Buat Permohonan Lembur
                    </button>
                </div>
            </div>
        </form>
    </section>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
@endpush
