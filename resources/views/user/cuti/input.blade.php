@extends('layouts.mobile')

@section('title')
Tambah Cuti
@endsection

@section('content')
    <section class="p-0 mb-3">
        <div class="ps-5 pe-4 pb-3 pt-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div>
                    <a href="{{ route('leave.index') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Pengajuan Cuti</h2>
                </div>
                <div class='ms-4'>
                </div>
            </div>
        </div>
    </section>

    <div class="py-4 px-4">
        <form action="{{ route('leave.store') }}" method="post" id="myForm">
            @method('POST')
            @csrf
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Jenis Cuti<span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <select name="id_cuti_jenis" id="cuti_jenis" class="form-select">
                    @foreach ($jenis as $item)
                        <option value="{{ $item->id }}">{{ $item->cuti_nama_jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Tanggal Mulai Cuti <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <input id="my-input" class="form-control" type="date" name="cuti_awal" required>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Tanggal Selesai Cuti <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <input id="my-input" class="form-control" type="date" name="cuti_akhir" required>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Keterangan Cuti <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <textarea class="form-control" name="cuti_deskripsi" id="cuti_deskripsi" cols="10" rows="5" required></textarea>
            </div>
            {{-- <button type="submit" class="btn btn-block btn-danger rounded-sm text-white font-size-h4 font-weight-bolder"></i>Submit Pengajuan</button> --}}
        </form>
        <br>
    </div>

    <div class="fixed-bottom bg-dark py-4 text-center">
        <a class="fw-regular font-size-16 text-white" onclick="event.preventDefault();document.getElementById('myForm').submit();">
            <i class="fa fa-save me-2"></i>Submit Pengajuan
        </a>
    </div>
@endsection

