@extends('layouts.main')

@section('title')
    Buat Payroll Baru
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
                        <li class="breadcrumb-item"><a href="{{ route("payroll.index") }}">Payroll</a></li>
                        <li class="breadcrumb-item active">Buat Payroll Baru</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Buat Penggajian Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Buat proses penggajian pegawai baru dengan payroll</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <h5 class="fw-bold font-size-18 mt-2 mb-5">Tahap 1</h5>
                    <form id="formAction" action="{{ route("payroll.store") }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="pay_code">Kode Penggajian <span class="text-danger">*</span></label>
                                    <input class='form-control form-control-solid font-weight-bolder' type="text" name="pay_code" id="pay_code" value="ASTA-{{ date('m-Y') }}">
                                </div>
                            </div>
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
                            <div class="col-sm-12 col-md-2">
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
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="pay_description">Remark <span class="text-danger">*</span></label>
                                    <input class='form-control' type="text" name="pay_description" id="pay_description" maxlength="20">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 my-3">
                                <button class="btn text-black btn-warning w-100 mt-1 font-weight-boldest btn-md" type="submit">
                                    Lanjut ke Tahap Berikutnya <i class="fas fa-chevron-right icon-md"></i>
                                </button>
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




