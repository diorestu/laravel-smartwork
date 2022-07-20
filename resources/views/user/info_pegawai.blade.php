@extends('layouts.mobile')

@section('title')Info Pegawai | Smartwork @endsection

@push('addon-style')
@endpush

@section('content')
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Informasi Pegawai</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div>
        <div class="card m-2 rounded-sm">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-2">
                        <span class="text-muted">ID Pegawai</span>
                        <br>
                        <span>{{ $id->nip }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Nama Perusahaan</span>
                        <br>
                        <span>{{ $company->company_name }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Nama Cabang</span>
                        <br>
                        <span>{{ $id->cabang->cabang_nama }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Divisi</span>
                        <br>
                        <span>@if ($id->id_divisi != null) {{ $id->divisi->div_title }} @else {{ "-" }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Jabatan</span>
                        <br>
                        <span>@if ($id->id_jabatan != null) {{ $id->jabatan->jabatan_title }} @else {{ "-" }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Tanggal Mulai Kerja</span>
                        <br>
                        <span>@if ($id->tanggal_mulaiKerja != "0000-00-00") {{ tanggalIndo($id->tanggal_mulaiKerja) }} @else {{ "-" }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Masa Kerja</span>
                        <br>
                        <span>@if ($id->tanggal_mulaiKerja != "0000-00-00") {{ masaKerja($id->tanggal_mulaiKerja) }} @else {{ "-" }} @endif</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
    </script>
@endif
@endpush
