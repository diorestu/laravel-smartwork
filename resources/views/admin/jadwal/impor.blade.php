@extends('layouts.main')

@section('title')
    Impor Jadwal Kerja Pegawai
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css"/>
    <style>
        .main-content { overflow: visible !important; }
        .topnav { margin-top: 0px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Jadwal Kerja</a></li>
                        <li class="breadcrumb-item active">Impor Jadwal Kerja Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Impor Jadwal Kerja Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Impor data jadwal kerja pegawai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="{{ route("jadwal.uploadAdd") }}" method="POST" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <div class="form-group">
                                    <label for="jadwal">File Jadwal Kerja <span class="text-danger">*</span></label>
                                    <input type="file" name="jadwal" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 d-flex align-items-end">
                                <button class="btn btn-warning text-black w-100 mt-1 font-weight-boldest btn-md" type="submit">
                                    <i class="fas fa-upload icon-md"></i> Impor Data Jadwal
                                </button>
                            </div>
                            <div class="col-md-12 py-2">
                                <button class="btn btn-sm btn-default" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fas fa-download"></i> &nbsp; Download Template Jadwal Kerja Disini</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="collapse multi-collapse hidden" id="multiCollapseExample2">
            <div class="col-12">
                <div class="card card-custom rounded-sm shadow-md">
                    <div class="card-body px-4 py-4">
                        <form id="formAction" action="{{ route("jadwal.downloadtemplate") }}" method="POST">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="staff">Pilih Lokasi Kerja <span class="text-danger">*</span></label>
                                        <select required id="cabang" class="form-select" name="id_cabang">
                                            @php
                                                $q_cabang = App\Models\Cabang::where('id_admin', auth()->user()->id)->get();
                                            @endphp
                                            @foreach ($q_cabang as $r_cabang)
                                            <option value='{{ $r_cabang->id }}'>{{ $r_cabang->cabang_nama }}</option>
                                            @endforeach
                                            <option value='all'>Semua Lokasi Kerja</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                        <select required id="tahun" class="form-select" name="tahun">
                                            @for ($t=2021;$t<=2030;$t++)
                                            <option value='{{ $t }}'>{{ $t }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                        <select required id="bulan" class="form-select" name="bulan">
                                            @for ($b=1;$b<=12;$b++)
                                            <option value='{{ $b }}'>{{ $b.": ".Bulan($b) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 d-flex align-items-end">
                                    <button class="btn btn-success w-100 mt-1 font-weight-boldest btn-md" type="submit">
                                        <i class="fas fa-download icon-md"></i> Download Template CSV
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        const elementCabang = document.querySelector('#cabang');
        const choices = new Choices(elementCabang);
        const elementTahun = document.querySelector('#bulan');
        const choices2 = new Choices(elementTahun);
        const elementBulan = document.querySelector('#tahun');
        const choices3 = new Choices(elementBulan);
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





