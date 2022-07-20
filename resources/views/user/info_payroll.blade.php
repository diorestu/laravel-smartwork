@extends('layouts.mobile')

@section('title')Info Payroll | Smartwork @endsection

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
                    <h2 class="fw-bold font-size-18 text-white mb-0">Informasi Payroll</h2>
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
                        <span class="text-muted">NPWP</span>
                        <br>
                        <span>@if ($id->npwp == null) {{ "-" }} @else {{ $id->npwp }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">BPJS Ketenagakerjaan</span>
                        <br>
                        <span>@if ($asuransi->nomor_naker == null) {{ "-" }} @else {{ $asuransi->nomor_naker }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">BPJS Kesehatan</span>
                        <br>
                        <span>@if ($asuransi->nomor_nakes == null) {{ "-" }} @else {{ $asuransi->nomor_nakes }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Bank</span>
                        <br>
                        <span>@if ($id->npwp == null) {{ "-" }} @else {{ $id->npwp }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Nomor Rekening</span>
                        <br>
                        <span>@if ($id->no_rek == null) {{ "-" }} @else {{ $id->no_rek }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Nama Akun</span>
                        <br>
                        <span>@if ($id->no_rek == null) {{ "-" }} @else {{ $id->no_rek }} @endif</span>
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
