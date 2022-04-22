@extends('layouts.mobile')

@section('title')
Tambah Cuti
@endsection

@section('content')
    <section class="p-0 mb-3">
        <div class="ps-5 pe-4 pb-3 pt-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div>
                    <a href="{{ route('overtime.index') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Pengajuan Lembur</h2>
                </div>
                <div class='ms-4'>
                </div>
            </div>
        </div>
    </section>

    <div class="py-4 px-4">
        <form action="{{ route('overtime.store') }}" method="post" id="myForm">
            @method('POST')
            @csrf
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Jam Hadir <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <input id="my-input" class="form-control" type="datetime-local" name="lembur_awal" required>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Jam Pulang <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <input id="my-input" class="form-control" type="datetime-local" name="lembur_akhir" required>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Judul Kegiatan <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <input class="form-control" name="lembur_judul" id="lembur_judul" type="text" required></input>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Keterangan Lembur <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <textarea class="form-control" name="lembur_keterangan" id="lembur_keterangan" cols="10" rows="5" required></textarea>
            </div>
        </form>
        <br>
    </div>

    <div class="fixed-bottom bg-dark py-4 text-center">
        <a class="fw-regular font-size-16 text-white" onclick="event.preventDefault();document.getElementById('myForm').submit();">
            <i class="fa fa-save me-2"></i>Submit Pengajuan
        </a>
    </div>
@endsection

