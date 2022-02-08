@extends('layouts.main')

@section('title')
    Ubah Data Lokasi Kerja
@endsection

@push('addon-style')
    <style>
        .card-header { background: rgb(219,66,66); background: linear-gradient(90deg, rgba(219,66,66,1) 0%, rgba(126,7,30,1) 100%); }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route("cabang.index") }}">Lokasi Kerja</a></li>
                <li class="breadcrumb-item active">Ubah Data Lokasi Kerja</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Lokasi Kerja</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('cabang.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Ubah Data Lokasi Kerja</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label for="cabang_nama">Nama Lokasi Kerja <span class="text-danger">*</span></label>
                                                <input required id="cabang_nama" class="form-control" type="text" name="cabang_nama" value="{{ $data->cabang_nama }}">
                                            </div>
                                            <div class="mb-4">
                                                <label for="cabang_phone">Telepon <span class="text-danger">*</span></label>
                                                <input required id="cabang_phone" class="form-control" type="text" name="cabang_phone" value="{{ $data->cabang_phone }}">
                                            </div>
                                            <div class="mb-4">
                                                <label for="cabang_lat">Kordinat Latitude <span class="text-danger">*</span></label>
                                                <input required id="cabang_lat" class="form-control" type="text" name="cabang_lat" value="{{ $data->cabang_lat }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4 form-group">
                                                <label for="cabang_umk">Nilai Upah <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text" id="my-addon">Rp</span></div>
                                                    <input required class="form-control" type="number" id="cabang_umk" name="cabang_umk" value="{{ $data->cabang_umk }}">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="cabang_email">Email <span class="text-danger">*</span></label>
                                                <input required id="cabang_email" class="form-control" type="email" name="cabang_email" value="{{ $data->cabang_email }}">
                                            </div>
                                            <div class="mb-4">
                                                <label for="cabang_long">Kordinat Longitude <span class="text-danger">*</span></label>
                                                <input required id="cabang_long" class="form-control" type="text" name="cabang_long" value="{{ $data->cabang_long }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-0">
                                                <label for="cabang_alamat">Alamat <span class="text-danger">*</span></label>
                                                <input required id="cabang_alamat" class="form-control" type="text" max="100" name="cabang_alamat" value="{{ $data->cabang_alamat }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-hdd icon-md"></i> &nbsp; Simpan Perubahan
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
