@extends('layouts.main')

@section('title')
    Riwayat Payroll
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
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Payroll</a></li>
                        <li class="breadcrumb-item active">Riwayat Payroll</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Riwayat Payroll</h4>
                    <p class="text-muted mt-1 text-opacity-50">Lihat riwayat payroll gaji pegawai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="{{ route("payroll.cari") }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                    <select required id="tahun" class="form-select" name="tahun">
                                        @for ($t=2021;$t<=2030;$t++)
                                        <option value='{{ $t }}'>{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                    <select required id="bulan" class="form-select" name="bulan">
                                        @for ($b=1;$b<=12;$b++)
                                        <option value='{{ $b }}'>{{ $b.": ".Bulan($b) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex align-items-end">
                                <button class="btn btn-primary w-100 mt-1 font-weight-boldest btn-md" type="submit">
                                    <i class="fas fa-info-circle icon-md"></i> Lihat Data
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12" id="content">
            <div class="card shadow rounded-sm">
                <div class="card-body px-4 py-4">
                    <div class="text-center">
                        <h1><i class="icon-sm fas fa-filter"></i></h1>
                        <h3>Silahkan Pilih Filter Diatas</h3>
                        <p>Untuk melihat data, silahkan tahun dan bulan lalu klik lihat data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
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





