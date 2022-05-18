@extends('layouts.mobile')

@section('title')
Tambah Kegiatan
@endsection

@section('content')
    <section class="p-0 mb-3">
        <div class="ps-5 pe-4 pb-3 pt-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div>
                    <a href="{{ route('kegiatan.index') }}" class="text-white"><i class="fa fa-chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Catat Aktivitas</h2>
                </div>
                <div class='ms-4'>
                </div>
            </div>
        </div>
    </section>

    <div class="px-4">
        <form action="{{ route('kegiatan.store') }}" method="post" id="myForm">
            @method('POST')
            @csrf
            <div class="mb-3">
                <label for="title_kgt">Kategori Kegiatan<span class="text-danger fw-light font-size-sm">*</span></label>
                {{-- <input id="my-input" class="form-control" type="text" name="title_kgt" required> --}}
                <select name="title_kgt" id="title_kgt" class="form-select">
                    @foreach ($data as $i)
                        <option value="{{ $i->id }}">{{ $i->kpi_master }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Waktu Kegiatan<span class="text-danger fw-light font-size-sm">* </span></label>
                <input id="my-input" class="form-control" type="time" name="waktu_kgt" required>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Deskripsi Kegiatan <span class="text-danger fw-light font-size-sm">*</span></label>
                <textarea class="form-control" name="desc_kgt" id="" cols="10" rows="5" required></textarea>
            </div>
            {{-- <div class="mb-3
            pb-0 rounded-sm px-3 pt-3 bg-white" style="border-style: dashed; border-width: 1px; border-color: green">
                <input id="avatar" type="file" name="avatar" class="filepond" />
            </div> --}}
            <button type="submit" class="btn w-100 btn-primary rounded text-white py-3">Catat Aktivitas</button>
        </form>

        <br>
    </div>
@endsection

