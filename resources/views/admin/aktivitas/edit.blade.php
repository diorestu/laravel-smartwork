@extends('layouts.main')

@section('title')
    Ubah Aktivitas Pegawai | S
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-header-custom { background:#B0141C !important; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Kelola</a></li>
                <li class="breadcrumb-item"><a href="{{ route("aktivitas.index") }}">Aktivitas Pegawai</a></li>
                <li class="breadcrumb-item active">Ubah Data Aktivitas</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Aktivitas Pegawai</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('aktivitas.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header card-header-custom">
                                    <h5 class="card-title text-white mb-0">Ubah Aktivitas Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="staff">Pegawai <span class="text-danger">*</span></label>
                                                <select required id="staff" class="form-select" name="id_staff">
                                                    @php
                                                        $q_staff = App\Models\User::where('id_admin', auth()->user()->id)->where('id','!=',auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_staff as $r_staff)
                                                    <option @if($r_staff->id == $data->id_user) selected @endif value='{{ $r_staff->id }}'>{{ $r_staff->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="judul_aktivitas" class="font-weight-bolder">Judul Aktivitas <span class="text-danger">*</span></label>
                                                <input required id="judul_aktivitas" class="form-control" type="text" name="judul_aktivitas" value="{{ $data->judul_aktivitas }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb-4 form-group">
                                                <label for="jam_aktivitas">Waktu Aktivitas <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                    <input type="time" class="form-control" id="jam_aktivitas" name="jam_aktivitas" value="{{ $data->jam_aktivitas }}">
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="aktivitas" class="font-weight-bolder">Keterangan Aktivitas <span class="text-danger">*</span></label>
                                                <input required id="aktivitas" class="form-control" type="text" name="aktivitas" value="{{ $data->aktivitas }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-check-circle icon-md"></i>&nbsp; Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-12 col-lg-12 p-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel">
                        <div class="card">
                            <div class="card-header card-header-custom">
                                <h5 class="card-title text-white mb-0">Upload Foto Aktivitas</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('aktivitas.uploadimages', ['id' => $data->id]) }}" enctype="multipart/form-data" class="dropzone">
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
    <script>
        const elementStaff      = document.querySelector('#staff');
        const choicesStaff      = new Choices(elementStaff);
        const elementTotcuti    = document.querySelector('#cuti_total');
        const choicesTotcuti    = new Choices(elementTotcuti);
        const elementJCuti      = document.querySelector('#id_cuti_jenis');
        const choicesJCuti      = new Choices(elementJCuti);
        const elementCutiStatus = document.querySelector('#cuti_status');
        const choicesCutiStatus = new Choices(elementCutiStatus);
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
