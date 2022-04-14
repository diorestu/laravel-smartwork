@extends('layouts.mobile')

@section('title')
 Profil Saya
@endsection

@push('addon-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4 pb-3 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Hai, {{ $id->nama }}</h2>
                    <p class="text-white-50 fw-light font-size-12">{{ $id->company }}</p>
                </div>
                <div class=''>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                    <a class='btn ms-3 text-white' id="btn-logout"><i data-feather="log-out"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="p-4">
            <form action="{{ route('user.save') }}" method="post" id="myForm">
                @method('POST')
                @csrf
                <h4 class="text-muted mb-2">Data Diri</h4>
                <div class="mb-3">
                    <label for="my-input">Nama Lengkap</label>
                    <input id="my-input" class="form-control" type="text" name="nama" value="{{ $id->nama }}">
                </div>
                <div class="mb-3">
                    <label for="my-input">Email</label>
                    <input id="my-input" class="form-control" type="text" name="email" value="{{ $id->email }}">
                </div>
                <div class="mb-3">
                    <label for="my-input">Nomor HP</label>
                    <input id="my-input" class="form-control" type="text" name="phone" value="{{ $id->phone }}">
                </div>
                <div class="mb-3">
                    <label for="my-input">Nomor Rekening</label>
                    <input id="my-input" class="form-control" type="text" name="no_rek" value="{{ $id->no_rek }}">
                </div>
                <div class="mb-3">
                    <label for="my-input">Alamat</label>
                    <textarea class="form-control" id="my-input" name="alamat" id="" cols="10"
                        rows="5">{{ $id->alamat }}</textarea>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                {{-- <div class="form-group">
                    <label for="select">Cabang</label>
                    <select id="my-select" class="form-control" name="">
                        <option value="{{ $id->id_cabang }}">{{ $id->cabang->cabang_nama }}</option>
                    </select>
                </div> --}}
            </form>
        </div>
    </section>
    <div class="fixed-bottom bg-dark py-4 text-center">
        <a class="fw-regular font-size-16 text-white" onclick="event.preventDefault();document.getElementById('myForm').submit();">
            <i class="fa fa-save me-2"></i>Simpan Profil
        </a>
    </div>
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
