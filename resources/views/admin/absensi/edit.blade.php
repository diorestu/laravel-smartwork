@extends('layouts.main')

@section('title')
    Ubah Data Absensi Pegawai | Smartwork App
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-header-custom { background:#B0141C !important; }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Manajemen</a></li>
                <li class="breadcrumb-item"><a href="{{ route("absensi.index") }}">Absensi Pegawai</a></li>
                <li class="breadcrumb-item active">Ubah Absensi Pegawai</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Absensi Pegawai</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('absensi.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header card-header-custom">
                                    <h5 class="card-title text-white mb-0">Ubah Absensi Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label for="tgl_hadir">Tanggal Absen Datang <span class="text-danger">*</span></label>
                                                <input required id="tgl_hadir" class="form-control datepicker" type="text" name="tgl_hadir" value="{{ TampilTanggal($data->jam_hadir) }}">
                                            </div>
                                            <div class="mb-4">
                                                <label for="jam_hadir">Waktu Absen Datang <span class="text-danger">*</span></label>
                                                <input required id="jam_hadir" class="form-control" type="time" name="jam_hadir" value="{{ TampilJamMenit($data->jam_hadir) }}">
                                            </div>
                                            <div class="mb-4">
                                                <label for="ket_hadir">Keterangan Absen Datang <span class="text-danger">*</span></label>
                                                <input required id="ket_hadir" class="form-control" type="text" name="ket_hadir" value="{{ $data->ket_hadir }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label for="tgl_pulang">Tanggal Absen Pulang</label>
                                                <input id="tgl_pulang" class="form-control datepicker" type="text" name="tgl_pulang" value="@if($data->jam_pulang != null){{ TampilTanggal($data->jam_pulang) }}@endif">
                                            </div>
                                            <div class="mb-4">
                                                <label for="jam_pulang">Waktu Absen Pulang</label>
                                                <input id="jam_pulang" class="form-control" type="time" name="jam_pulang" value="@if($data->jam_pulang != null){{ TampilJamMenit($data->jam_pulang) }}@endif">
                                            </div>
                                            <div class="mb-4">
                                                <label for="ket_pulang">Keterangan Absen Pulang</label>
                                                <input id="ket_pulang" class="form-control" type="text" name="ket_pulang" value="{{ $data->ket_pulang }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-check icon-md"></i> &nbsp; Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel">
                        <div class="card">
                            <div class="card-header card-header-custom">
                                <h5 class="card-title text-white mb-0">Upload Foto Absen Datang</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('absensi.uploadimages', ['tipe' => "datang", 'id' => $data->id]) }}" enctype="multipart/form-data" class="dropzone">
                                    @method('post')
                                    @csrf
                                    <div class="fallback"><input name="file" type="file" multiple="multiple"></div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3"><i class="display-4 text-muted bx bx-cloud-upload"></i></div>
                                        <h5>Drop files here or click to upload.</h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel">
                        <div class="card">
                            <div class="card-header card-header-custom">
                                <h5 class="card-title text-white mb-0">Upload Foto Absen Pulang</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('absensi.uploadimages', ['tipe' => "pulang", 'id' => $data->id]) }}" enctype="multipart/form-data" class="dropzone">
                                    @method('post')
                                    @csrf
                                    <div class="fallback"><input name="file" type="file" multiple="multiple"></div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3"><i class="display-4 text-muted bx bx-cloud-upload"></i></div>
                                        <h5>Drop files here or click to upload.</h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/dropzone/min/dropzone.min.js') }}"></script>
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
