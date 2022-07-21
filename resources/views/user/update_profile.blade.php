@extends('layouts.mobile')

@section('title')Edit Profil | Smartwork @endsection

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
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Update Profil</h2>
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
        <div class="card m-2 rounded-sm">
            <form action="{{ route('user.save') }}" method="post" id="myForm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Nama Lengkap</span>
                            <input id="nama" class="form-control text-dark mt-1" type="text" name="nama" value="{{ $id->nama }}">
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Email</span>
                            <input id="email" class="form-control text-dark mt-1" type="email" name="email" value="{{ $id->email }}">
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Nomor Telepon</span>
                            <input id="phone" class="form-control text-dark mt-1" type="text" name="phone" value="{{ $id->phone }}">
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Alamat KTP</span>
                            <textarea class="form-control text-dark mt-1" id="alamat" name="alamat" id="" cols="10"
                            rows="2">{{ $id->alamat }}</textarea>
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Alamat Tempat Tinggal</span>
                            <textarea class="form-control text-dark mt-1" id="alamat" name="alamat" id="" cols="10"
                            rows="2">{{ $id->alamat }}</textarea>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="col=12">
            <div class="fixed-bottom mb-0 card p-2">
                <a class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white" onclick="event.preventDefault();document.getElementById('myForm').submit();">
                    <i class="label-icon fa fa-check-circle me-2"></i>Update Personal Info
                </a>
            </div>
        </div>
    </section>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
@endpush
