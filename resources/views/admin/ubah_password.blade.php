@extends('layouts.main')

@section('title')
    Ubah Kata Sandi | Smartwork App
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/croppie/croppie.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-header { background:#B0141C !important; }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active">Ubah Kata Sandi</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Kata Sandi</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-5 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                <i class="bx bx-dots-horizontal-rounded"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route("admin.profile") }}">Lihat Profil</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ $data_user->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $data_user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                            </div>
                            <div class="flex-1 ms-3">
                                <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $data_user->nama }}</a></h5>
                                <p class="text-muted mb-0">{{ "@".$data_user->username }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-1">
                            <p class="text-muted mb-0"><i class="icon-menu" data-feather="phone-call"></i>
                                {{ $data_user->phone }}</p>
                            <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="mail"></i>
                                {{ $data_user->email }}</p>
                            <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="award"></i>
                                {{ $data_user->roles }}</p>
                            <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="globe"></i>
                                {{ $data_user->company }}</p>
                            <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="log-in"></i>
                                {{ tanggalIndoWaktuLengkap($data_user->created_at) }}</p>
                            <p class="text-muted mb-0 mt-3"><i class="icon-menu" data-feather="map-pin"></i>
                                {{ $data_user->alamat }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <form action="{{ route('admin.newPassword') }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <!-- DATA DIRI -->
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Ubah Kata Sandi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group mb-4">
                                                <label for="old-pass" class="font-weight-bolder">Kata Sandi Lama <span class="text-danger">*</span></label>
                                                <input required class='form-control @error("old-password")
                                                    is-invalid
                                                @enderror' type="password" name="old-password" id="old-pass" value="">
                                                @error('old-password')
                                                    <span>{{ $errors }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="new-pass" class="font-weight-bolder">Kata Sandi Baru <span class="text-danger">*</span></label>
                                                <input required class='form-control @error("new-password")
                                                    is-invalid
                                                @enderror' type="password" name="new-password" id="new-pass" value="">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="cnew-pass" class="font-weight-bolder">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                                                <input required class='form-control
                                                @error("cnew-password")
                                                    is-invalid
                                                @enderror' type="password" name="cnew-password" id="cnew-pass" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-check-circle icon-md"></i>&nbsp; Update Kata Sandi
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

