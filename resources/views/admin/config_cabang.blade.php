@extends('layouts.main')

@section('title')
    Pengaturan Sistem | Smartwork App
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('backend-assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <style>
        .f-10 {
            font-size: 10px !important;
        }

        .card-header {
            background: #B0141C !important;
        }

        .filter_wp span {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        .text-tipis {
            font-weight: 300;
            opacity: 0.5;
        }

        .main-content {
            overflow: visible !important;
        }

        .topnav {
            margin-top: 0px !important;
        }

        .row_sticky {
            justify-content: space-around;
            align-items: flex-start;
        }

        .div_sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 150px;
        }

        .choices__list--dropdown .choices__item {
            font-size: 11px !important;
        }

        .pro-text {
            letter-spacing: 0.3px;
            background: linear-gradient(120deg, #ff725c, #dbb118);
            -webkit-background-clip: text;
            color: transparent !important;
        }
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
                        <a class="active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">Absensi</a>
                        <a id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab"
                            aria-controls="v-pills-profile" aria-selected="false">Payroll</a>
                        <a id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab"
                            aria-controls="v-pills-messages" aria-selected="false">Komponen Gaji</a>
                        <a id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab"
                            aria-controls="v-pills-settings" aria-selected="true">Perhitungan PPH21</a>
                    </div>
                </div>
            </div>
            <div class="email-rightbar mb-3">
                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                    {{-- pengaturan absensi --}}
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Absensi</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('config.absen') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_cabang" value="{{ $data->id }}">
                                    <div class="form-check form-switch form-switch-lg mb-3 py-1">
                                        <label class="form-check-label" for="customSwitchsizemd">Validasi GPS di
                                            Kantor</label>
                                        <input id="mode" name="is_radius" type="checkbox"
                                            class="form-check-input layout-mode-switch"
                                            @isset($detail->is_radius) checked @endisset>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Radius
                                            Validasi GPS</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="number" max="1000" class="form-control"
                                                    @isset($detail->is_radius) @else disabled @endisset
                                                    id="horizontal-firstname-input" placeholder="1 s/d 1000 meter"
                                                    name="radius_max"
                                                    @isset($detail) value="{{ $detail->radius_max }}" @endisset>
                                                <span class="input-group-text">meter</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch form-switch-lg mb-3 py-1">
                                        <label class="form-check-label" for="customSwitchsizemd">Lampirkan Foto
                                            Presensi</label>
                                        <input id="mode" name="is_photo_enabled" type="checkbox"
                                            class="form-check-input layout-mode-switch"
                                            @isset($detail->is_photo_enabled) {{ $detail->is_photo_enabled ? 'checked' : '' }} @endisset>
                                    </div>
                                    <div class="form-check form-switch form-switch-lg mb-3 py-1">
                                        <label class="form-check-label" for="customSwitchsizemd">Menggunakan Shift</label>
                                        <input id="mode" name="is_using_shift" type="checkbox"
                                            class="form-check-input layout-mode-switch"
                                            @isset($detail->is_using_shift) {{ $detail->is_using_shift ? 'checked' : '' }} @endisset>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="jatah_cuti" class="col-sm-3 col-form-label">Jatah Cuti Tahunan</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="number" class="form-control"
                                                    id="jatah_cuti"
                                                    name="jatah_cuti"
                                                    @isset($detail) value="{{ $detail->jatah_cuti }}" @endisset>
                                                <span class="input-group-text">hari</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-sm-9">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i
                                                        class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    var input = document.getElementById('horizontal-firstname-input');
                                    var toggle = document.getElementById('mode');

                                    // create a listener for both input fields(on change)
                                    toggle.addEventListener('change', toggleDisable);

                                    // evaluate input fields when either one changes (invoked by listeneres above)
                                    function toggleDisable() {
                                        // alert('coba');
                                        if (toggle.checked == false) {
                                            input.disabled = true;
                                        } else {
                                            input.disabled = false;
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    {{-- pengaturan payroll --}}
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Payroll</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('config.payroll') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_cabang" value="{{ $data->id }}">
                                    <div class="mb-3 py-0">
                                        <label class="col-form-label">Bank Pembayaran</label>
                                        <select class="form-control" name="bank_type" id="bank_type"
                                            placeholder="Pilih salah satu">
                                            @isset($detail->bank_type)
                                                <option value="Bank BCA"
                                                    {{ $detail->bank_type == 'Bank BCA' ? 'selected' : '' }}>Bank BCA</option>
                                                <option value="Mandiri"
                                                    {{ $detail->bank_type == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                <option value="BNI" {{ $detail->bank_type == 'BNI' ? 'selected' : '' }}>
                                                    BNI</option>
                                                <option value="BRI" {{ $detail->bank_type == 'BRI' ? 'selected' : '' }}>
                                                    BRI</option>
                                                <option value="Permata"
                                                    {{ $detail->bank_type == 'Permata' ? 'selected' : '' }}>Permata</option>
                                            @else
                                                <option value="Bank BCA">Bank BCA</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="Permata">Permata</option>
                                            @endisset
                                        </select>
                                    </div>

                                    <div class="mb-3 py-0">
                                        <label class="col-form-label">Tanggal Tutup Buku</label>
                                        <input type="number" name="date_closed" id="date_closed" class="form-control"
                                            @isset($detail) value="{{ $detail->tgl_tutup }}"
                                        @else
                                        value="" @endisset>
                                    </div>
                                    <div class="row justify-content-end mt-4">
                                        <div class="col-sm-12">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i
                                                        class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- komponen gaji --}}
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab">
                        <div class="card">
                            @php
                                if (empty($detail->komponen_gaji)) {
                                    $komponen = [];
                                } else {
                                    $komponen = explode(',', $detail->komponen_gaji);
                                }
                            @endphp
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Komponen Gaji</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('config.komponen') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_cabang" value="{{ $data->id }}">
                                    <div class="mb-3 py-0">
                                        <label class="col-form-label">Pilih Kompenen Gaji</label>
                                        <select class="form-control" name="komponen[]" id="komponen"
                                            placeholder="Pilih salah satu" multiple>

                                            <option value="Tunjangan Jabatan"
                                                {{ in_array('Tunjangan Jabatan', $komponen) ? 'selected' : '' }}>
                                                Tunjangan Jabatan</option>
                                            <option value="Tunjangan Masa Kerja"
                                                {{ in_array('Tunjangan Masa Kerja', $komponen) ? 'selected' : '' }}>
                                                Tunjangan Masa Kerja</option>
                                            <option value="Tunjangan Sertifikasi"
                                                {{ in_array('Tunjangan Sertifikasi', $komponen) ? 'selected' : '' }}>
                                                Tunjangan Sertifikasi</option>
                                            <option value="Tunjangan Status Kawin"
                                                {{ in_array('Tunjangan Status Kawin', $komponen) ? 'selected' : '' }}>
                                                Tunjangan Status Kawin</option>
                                            <option value="BPJS Kesehatan"
                                                {{ in_array('BPJS Kesehatan', $komponen) ? 'selected' : '' }}>BPJS
                                                Kesehatan</option>
                                            <option value="BPJS Tenaga Kerja"
                                                {{ in_array('BPJS Tenaga Kerja', $komponen) ? 'selected' : '' }}>BPJS
                                                Tenaga Kerja</option>
                                            <option value="Potongan Absen"
                                                {{ in_array('Potongan Absen', $komponen) ? 'selected' : '' }}>Potongan
                                                Absen</option>
                                            <option value="Potongan Kasbon"
                                                {{ in_array('Potongan Kasbon', $komponen) ? 'selected' : '' }}>Potongan
                                                Kasbon</option>
                                            <option value="PPH21" {{ in_array('PPH21', $komponen) ? 'selected' : '' }}>
                                                PPH21</option>
                                        </select>
                                    </div>
                                    <div class="row justify-content-end mt-4">
                                        <div class="col-sm-12">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i
                                                        class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- perhitungan pajak --}}
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-white mb-0">Pengaturan Perhitungan Pajak</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('config.pph21') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_cabang" value="{{ $data->id }}">
                                    <div class="mb-3 py-0">
                                        <label class="col-form-label">Pilih Metode Perhitungan</label>
                                        <select id="pajak" class="form-select" name="m_pajak">
                                            @isset($detail->pph21)
                                                <option value="GROSS" {{ $detail->pph21 == 'GROSS' ? 'selected' : '' }}>
                                                    GROSS</option>
                                                <option value="GROSS UP"
                                                    {{ $detail->pph21 == 'GROSS UP' ? 'selected' : '' }}>GROSS UP</option>
                                                <option value="NETT" {{ $detail->pph21 == 'NETT' ? 'selected' : '' }}>NETT
                                                </option>
                                            @else
                                                <option value="GROSS">GROSS</option>
                                                <option value="GROSS UP">GROSS UP</option>
                                                <option value="NETT">NETT</option>
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="row justify-content-end mt-4">
                                        <div class="col-sm-12">
                                            <div><button type="submit" class="btn btn-warning text-black w-lg"><i
                                                        class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                            </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            new Choices("#komponen", {
                removeItemButton: !0,
            });
            new Choices("#bank_type", {
                removeItemButton: !0,
            });
            const elementPajak = document.querySelector('#pajak');
            const choices = new Choices(elementPajak);

        });
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil', '{{ \Session::get('success') }}', 'success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal', '{{ \Session::get('error') }}', 'error')
        </script>
    @endif
@endpush
