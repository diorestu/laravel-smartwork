@extends('layouts.main')

@section('title')
    Ubah Data Divisi
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
                <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route("divisi.index") }}">Divisi</a></li>
                <li class="breadcrumb-item active">Ubah Data Divisi</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Divisi</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('divisi.update', $data->div_id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Data Divisi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="div_title" class="font-weight-bolder">Divisi <span class="text-danger">*</span></label>
                                                <input required id="div_title" class="form-control" type="text" name="div_title" value="{{ $data->div_title }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="div_desc">Deskripsi Singkat</label>
                                                <input required id="div_desc" class="form-control" type="text" name="div_desc" maxlength="200" value="{{ $data->div_desc }}">
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
