@extends('layouts.mobile')

@section('title')Pengajuan Lembur | Smartwork @endsection

@push('addon-style')
<style>
    .no-border { border: none !important; }
    .main-content { overflow: inherit; }
    .child_i { position: absolute; top:-170px; width: 100%; display: block; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important; height:250px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="#" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
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
    <section class="parent">
        <form class="child_i" action="{{ route('overtime.store') }}" method="post" id="myForm">
            <div class="card m-2 rounded-sm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Waktu Awal Lembur <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-calendar-alt"></i></div>
                                <input id="lembur_awal" class="form-control text-dark" type="datetime-local" name="lembur_awal" required />
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Waktu Akhir Lembur <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-calendar-alt"></i></div>
                                <input id="lembur_akhir" class="form-control text-dark" type="datetime-local" name="lembur_akhir" required />
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Judul Lembur <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-pencil"></i></div>
                                <input id="lembur_judul" class="form-control text-dark" name="lembur_judul" type="text" required />
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Keterangan Lembur <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-menu-alt-left"></i></div>
                                <textarea id="lembur_keterangan" class="form-control text-dark" name="lembur_keterangan" cols="3" required></textarea>
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="font-size-11 text-danger">* merupakan field yang tidak boleh kosong</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div style="padding-bottom:1.5rem;" class="fixed-bottom mb-0 card px-2 pt-2 rounded-sm">
                    <button type="submit" class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white rounded-sm">
                        <i class="label-icon fa fa-check-circle me-2"></i>Buat Permohonan Lembur
                    </button>
                </div>
            </div>
        </form>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection

@push('addon-script')
@endpush
