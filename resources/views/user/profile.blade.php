@extends('layouts.mobile')

@section('title')Profil | Smartwork @endsection

@push('addon-style')
<style>
    .no-border { border: none !important; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Informasi Personal</h2>
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
                        <span class="fw-light font-size-12 text-muted">Nama Lengkap</span>
                        <br>
                        <span class="text-dark">{{ $id->nama }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Email</span>
                        <br>
                        <span class="text-dark">@if ($id->email == "") {{ "-" }} @else {{ $id->email }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Jenis Kelamin</span>
                        <br>
                        <span class="text-dark">@if ($id->gender == "") {{ "-" }} @else {{ $id->gender }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Tempat Lahir</span>
                        <br>
                        <span class="text-dark">@if ($id->tempat_lahir == "") {{ "-" }} @else {{ $id->tempat_lahir }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Tanggal Lahir</span>
                        <br>
                        <span class="text-dark">@if ($id->tgl_lahir == "") {{ "-" }} @else {{ tanggalIndo($id->tgl_lahir) }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Nomor Telepon</span>
                        <br>
                        <span class="text-dark">@if ($id->phone == "") {{ "-" }} @else {{ $id->phone }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Status Perkawinan</span>
                        <br>
                        <span class="text-dark">@if ($id->tanggungan == 0) {{ "-" }} @else {{ $id->status_kawin->status_kawin }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Agama</span>
                        <br>
                        <span class="text-dark">@if ($id->agama == "") {{ "-" }} @else {{ $id->agama }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">No. ID</span>
                        <br>
                        <span class="text-dark">@if ($id->nik == "") {{ "-" }} @else {{ $id->nik }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Tipe ID</span>
                        <br>
                        <span class="text-dark">@if ($id->tipe_id == "") {{ "-" }} @else {{ $id->tipe_id }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Alamat KTP</span>
                        <br>
                        <span class="text-dark">@if ($id->alamat_ktp == "") {{ "-" }} @else {{ $id->alamat_ktp }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Alamat Tempat Tinggal</span>
                        <br>
                        <span class="text-dark">@if ($id->alamat == "") {{ "-" }} @else {{ $id->alamat }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Kode Pos</span>
                        <br>
                        <span class="text-dark">@if ($id->kode_pos == "") {{ "-" }} @else {{ $id->kode_pos }} @endif</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="fw-light font-size-12 text-muted">Golongan Darah</span>
                        <br>
                        <span class="text-dark">@if ($id->gol_darah == "") {{ "-" }} @else {{ $id->gol_darah }} @endif</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <section>
        <div class="col-12">
            <div style="padding-bottom:1.5rem;" class="fixed-bottom mb-0 card px-2 pt-2 rounded-sm">
                <a href="{{ route('user.edit') }}" class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white rounded-sm">
                    <i class="label-icon fas fa-pencil-alt me-2"></i>Ubah Profil
                </a>
            </div>
        </div>
    </section>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
        // Swal.fire('Berhasil', '{{ \Session::get('success') }}', 'success')
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
        // Swal.fire('Gagal', '{{ \Session::get('error') }}', 'error')
    </script>
@endif
@endpush
