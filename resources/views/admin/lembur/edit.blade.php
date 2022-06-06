@extends('layouts.main')

@section('title')
    Edit Data Lembur Pegawai | Smartwork App
@endsection

@push('addon-style')
    <style>
        .card-header { background:#B0141C !important; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Kelola</a></li>
                <li class="breadcrumb-item"><a href="{{ route("lembur.index") }}">Lembur Pegawai</a></li>
                <li class="breadcrumb-item active">Edit Data Lembur</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Edit Data Lembur Pegawai</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('lembur.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Edit Data Lembur</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="staff">Pegawai <span class="text-danger">*</span></label>
                                                <select required id="staff" class="form-select" name="id_staff">
                                                    @php
                                                        $q_staff = App\Models\User::where('id_admin', auth()->user()->id)->where('id','!=',auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_staff as $r_staff)
                                                    <option @if($r_staff->id==$data->id_user) {{ 'selected' }} @endif value='{{ $r_staff->id }}'>{{ $r_staff->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="lembur_status">Status Lembur <span class="text-danger">*</span></label>
                                                <select required id="lembur_status" class="form-select" name="lembur_status">
                                                    <option @if($data->lembur_status == "PENGAJUAN") {{ 'selected' }} @endif value='PENGAJUAN'>PENGAJUAN</option>
                                                    <option @if($data->lembur_status == "DITERIMA") {{ 'selected' }} @endif value='DITERIMA'>DITERIMA</option>
                                                    <option @if($data->lembur_status == "DITOLAK") {{ 'selected' }} @endif value='DITOLAK'>DITOLAK</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="mb-4 form-group">
                                                <label for="lembur_awal_tanggal">Tanggal Lembur Awal <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                    <input type="text" class="form-control datepicker" id="lembur_awal_tanggal" name="lembur_awal_tanggal" value="{{ TampilTanggal($data->lembur_awal) }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 form-group">
                                                <label for="lembur_akhir_tanggal">Tanggal Lembur Akhir <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                    <input type="text" class="form-control datepicker" id="lembur_akhir_tanggal" name="lembur_akhir_tanggal" value="{{ TampilTanggal($data->lembur_akhir) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="lembur_awal_waktu">Jam Lembur Awal <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                    <input type="time" class="form-control" id="lembur_awal_waktu" name="lembur_awal_waktu" value="{{ TampilJamMenit($data->lembur_awal) }}">
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="lembur_akhir_waktu">Jam Lembur Akhir <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                    <input type="time" class="form-control" id="lembur_akhir_waktu" name="lembur_akhir_waktu" value="{{ TampilJamMenit($data->lembur_akhir) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="lembur_judul" class="font-weight-bolder">Judul Lembur <span class="text-danger">*</span></label>
                                                <input required id="lembur_judul" class="form-control" type="text" name="lembur_judul" value="{{ $data->lembur_judul }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="lembur_keterangan" class="font-weight-bolder">Keterangan Lembur</label>
                                                <input id="lembur_keterangan" class="form-control" type="text" name="lembur_keterangan" value="{{ $data->lembur_keterangan }}">
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
        </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        const elementStaff      = document.querySelector('#staff');
        const choicesStaff      = new Choices(elementStaff);
        const elementLemburStatus           = document.querySelector('#lembur_status');
        const choiceselementLemburStatus    = new Choices(elementLemburStatus);
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
