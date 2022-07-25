@extends('layouts.mobile')

@section('title')Catat Aktivitas | Smartwork @endsection

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Input Aktivitas</h2>
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
        <div class="col=12">
            <div class="card p-4">
                <form action="{{ route('kegiatan.store') }}" method="post" id="myForm">
                    @method('POST')
                    @csrf
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="judul">Judul Aktivitas</label>
                        <input id="judul" class="form-control text-dark" type="text" name="judul_aktivitas" value="">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="keterangan">Keterangan</label>
                        <textarea id="keterangan" class="form-control text-dark" name="aktivitas"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="waktu">Waktu Aktivitas</label>
                        <input id="waktu" class="form-control text-dark" type="time" name="jam_aktivitas" value="">
                    </div>
                </form>
            </div>

            <div class="fixed-bottom mb-0 card p-2">
                <a class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white" onclick="event.preventDefault();document.getElementById('myForm').submit();">
                    <i class="label-icon fa fa-check-circle me-2"></i>Catat Aktivitas
                </a>
            </div>
        </div>
    </section>
@endsection

