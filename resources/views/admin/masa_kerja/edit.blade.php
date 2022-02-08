@extends('layouts.main')

@section('title')
    Ubah Data Masa Kerja
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
                <li class="breadcrumb-item"><a href="{{ route("masa-kerja.index") }}">Tunjangan</a></li>
                <li class="breadcrumb-item active">Masa Kerja</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Masa Kerja</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('masa-kerja.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Data Masa Kerja</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="masa_kerja" class="font-weight-bolder">Masa Kerja <span class="text-danger">*</span></label>
                                                <input required id="masa_kerja" class="form-control" type="text" name="masa_kerja" value="{{ $data->masa_kerja }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="masa_kerja_tunjangan">Jumlah Tunjangan <span class="text-danger">*</span></label>
                                                <input required id="masa_kerja_tunjangan" class="form-control" type="number" name="masa_kerja_tunjangan" value="{{ $data->masa_kerja_tunjangan }}">
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
