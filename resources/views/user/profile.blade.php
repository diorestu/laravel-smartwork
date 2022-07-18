@extends('layouts.mobile')

@section('title')Edit Profil | Smartwork @endsection

@push('addon-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Personal Info</h2>
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
                <form action="{{ route('user.save') }}" method="post" id="myForm">
                    @method('POST')
                    @csrf
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="nama">Nama Lengkap</label>
                        <input id="nama" class="form-control text-dark" type="text" name="nama" value="{{ $id->nama }}">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="email">Email</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ $id->email }}">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="phone">Nomor HP</label>
                        <input id="phone" class="form-control" type="text" name="phone" value="{{ $id->phone }}">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="no_rek">Nomor Rekening</label>
                        <input id="no_rek" class="form-control" type="text" name="no_rek" value="{{ $id->no_rek }}">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" id="" cols="10"
                            rows="5">{{ $id->alamat }}</textarea>
                    </div>
                </form>
            </div>

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
    <br>
    <br>
@endsection

@push('addon-script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#my-select').select2();
        });
    </script> --}}
    <script>
        $(function() {
            $('#btn-logout').click(function() {
                if (confirm('Anda akan keluar dari Aplikasi, lanjutkan?')) {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                }
                return false;
            });
        });
    </script>
@endpush
