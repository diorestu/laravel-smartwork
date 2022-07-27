@extends('layouts.mobile')

@section('title')Edit Profil | Smartwork @endsection

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
    <section class="parent">
        <form class="child_i" action="{{ route('user.save') }}" method="post" id="myForm">
            <div class="card m-2 rounded-sm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Nama Lengkap</span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-user"></i></div>
                                <input id="nama" class="form-control text-dark" type="text" name="nama" value="{{ $id->nama }}" required>
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Email</span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-envelope"></i></div>
                                <input id="email" class="form-control text-dark" type="email" name="email" value="{{ $id->email }}" required>
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Nomor Telepon</span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-phone"></i></div>
                                <input id="phone" class="form-control text-dark" type="text" name="phone" value="{{ $id->phone }}" required>
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Alamat KTP</span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-map"></i></div>
                                <textarea class="form-control text-dark" id="alamat_ktp" name="alamat_ktp" id="" cols="10"
                                rows="2" required>{{ $id->alamat_ktp }}</textarea>
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Alamat Tempat Tinggal</span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-map"></i></div>
                                <textarea class="form-control text-dark" id="alamat" name="alamat" id="" cols="10"
                                rows="2" required>{{ $id->alamat }}</textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div style="padding-bottom:1.5rem;" class="fixed-bottom mb-0 card px-2 pt-2 rounded-sm">
                    <button type="submit" class="btn btn-lg btn-primary waves-effect btn-label waves-light fw-regular font-size-16 text-white rounded-sm">
                        <i class="label-icon fa fa-check-circle me-2"></i>Update Personal Info
                    </button>
                </div>
            </div>
        </form>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
