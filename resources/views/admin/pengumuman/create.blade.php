@extends('layouts.main')

@section('title')
    Buat Pengumuman Baru | Smartwork App
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
                <li class="breadcrumb-item"><a href="{{ route("pengumuman.index") }}">Pengumuman</a></li>
                <li class="breadcrumb-item active">Buat Pengumuman Baru</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Buat Pengumuman Baru</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('pengumuman.store') }}" method="post" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Buat Pengumuman Baru</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group mb-4">
                                                <label for="staff">Tujuan Pengumuman <span class="text-danger">*</span></label>
                                                <select required id="divisi" class="form-select" name="id_divisi">
                                                    @php
                                                        $q_div = App\Models\Divisi::where('id_admin', auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_div as $r_div)
                                                    <option value='{{ $r_div->div_id }}'>{{ $r_div->div_title }}</option>
                                                    @endforeach
                                                    <option value='0'>Semua Divisi</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="judul_pengumuman" class="font-weight-bolder">Judul Pengumuman <span class="text-danger">*</span></label>
                                                <input required id="judul_pengumuman" class="form-control" type="text" name="judul_pengumuman">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="deskripsi_pengumuman" class="font-weight-bolder">Keterangan Pengumuman <span class="text-danger">*</span></label>
                                                <textarea name="deskripsi_pengumuman" id="ckeditor-classic"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-plus icon-md"></i> &nbsp; Buat Pengumuman Baru
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
    <script src="{{ asset('backend-assets/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('backend-assets/js/pages/form-editor.init.js') }}"></script>
    <script>
        const elementDivisi      = document.querySelector('#divisi');
        const choicesDivisi      = new Choices(elementDivisi);
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
