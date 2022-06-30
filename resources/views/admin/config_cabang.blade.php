@extends('layouts.main')

@section('title')
    Pengaturan Sistem | Smartwork App
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('backend-assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <style>
        .f-10 { font-size: 10px !important; }
        .card-header { background:#B0141C !important; }
        .filter_wp span { font-weight: bold; margin-bottom: 10px; display:block; }
        .text-tipis  { font-weight: 300; opacity: 0.5; }
        .main-content { overflow: visible !important; }
        .topnav { margin-top: 0px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 150px; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .pro-text { letter-spacing: 0.3px; background: linear-gradient(120deg,#ff725c,#dbb118); -webkit-background-clip: text; color: transparent !important; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Left sidebar -->
            <div class="email-leftbar card">
                <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                    <div>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pengaturan</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pengaturan Lokasi Kerja</a></li>
                        </ol>
                        <h5 class="fw-bold font-size-18 mt-3">{{ $data->cabang_nama }}</h5>
                    </div>
                </div>
                <div class="mail-list mt-1">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false">Absensi</a>
                        <a id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Payroll</a>
                        <a id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Komponen Gaji</a>
                        <a id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="true">Perhitungan Pajak</a>
                    </div>
                </div>
            </div>
            <div class="email-rightbar mb-3">
                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                    {{-- pengaturan absensi --}}
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Absensi</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch form-switch-lg mb-3 py-1">
                                    <label class="form-check-label" for="customSwitchsizemd">Validasi GPS di Kantor</label>
                                    <input id="mode" name="mode" type="checkbox" class="form-check-input layout-mode-switch">
                                </div>
                                <form>
                                    <div class="row mb-4">
                                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Radius Validasi GPS</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="number" max="1000" class="form-control" id="horizontal-firstname-input" placeholder="1 s/d 1000 meter">
                                                <span class="input-group-text">meter</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-sm-9">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- pengaturan payroll --}}
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Payroll</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch form-switch-lg mb-3 py-3">
                                    <label class="form-check-label" for="customSwitchsizemd">Dark Mode</label>
                                    <input id="mode" name="mode" {{ auth()->user()->config->layout_mode == 'dark' ? 'checked' : ''  }} type="checkbox" class="form-check-input layout-mode-switch">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- komponen gaji --}}
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Komponen Gaji</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3 py-0">
                                        <label class="col-form-label">Pilih Kompenen Gaji</label>
                                        <select class="form-control" name="choices-multiple-remove-button"
                                            id="choices-multiple-remove-button"
                                            placeholder="This is a placeholder" multiple>
                                            <option value="Choice 1" selected>Choice 1</option>
                                            <option value="Choice 2">Choice 2</option>
                                            <option value="Choice 3">Choice 3</option>
                                            <option value="Choice 4">Choice 4</option>
                                        </select>
                                    </div>
                                    <div class="row justify-content-end mt-4">
                                        <div class="col-sm-12">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- perhitungan pajak --}}
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Perhitungan Pajak</h5>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-3 py-0">
                                        <label class="col-form-label">Pilih Metode Perhitungan</label>
                                        <select id="pajak" class="form-select" name="m_pajak">
                                            <option value="GROSS">GROSS</option>
                                            <option value="GROSS UP">GROSS UP</option>
                                            <option value="NETT">NETT</option>
                                        </select>
                                    </div>
                                    <div class="row justify-content-end mt-4">
                                        <div class="col-sm-12">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        new Choices("#choices-multiple-remove-button", {
            removeItemButton: !0,
        });
        const elementPajak = document.querySelector('#pajak');
        const choices = new Choices(elementPajak);
        });
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil','{{ \Session::get('success') }}','success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal','{{ \Session::get('error') }}','error')
        </script>
    @endif
@endpush
