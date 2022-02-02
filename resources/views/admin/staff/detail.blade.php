@extends('layouts.main')

@section('title')
    Detail Informasi Pegawai
@endsection

@section('content')
    <div class="main-content mx-0">
        <div class="page-content mt-0 pt-0">
            <div class="row">
                <div class="col-xl-12">
                    <div class="profile-user"></div>
                </div>
            </div>

            <div class="row">
                <div class="profile-content">
                    <div class="row align-items-end">
                        <div class="col-sm">
                            <div class="d-flex align-items-end mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xxl me-3">
                                        <img src="{{ $data->company_logo == '' ? asset('backend-assets/images/no-image.png') : asset('storage/logo/' . Auth::user()->company_logo) }}"
                                            alt="" class="img-fluid rounded-circle d-block img-thumbnail">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h3 class="font-size-25 mb-1">
                                            {{ $data->nama }}
                                            @if ($data->status == 'active')
                                                &nbsp; <span><i class="fas text-primary fa-check-circle icon-sm"></i></span>
                                            @else
                                                &nbsp; <span><i class="fas text-warning fa-exclamation-circle icon-sm"></i></span>
                                            @endif
                                        </h3>
                                        <p class="text-muted font-size-13 mb-2 pb-2">NIP : {{ $data->nip }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                                <div>
                                    <a href="{{ route('pegawai.edit', $data->id) }}" class="btn btn-soft-primary me-2"><i data-feather="edit-3"
                                            class="me-1"></i> Edit Data</a>
                                    <a href="{{ route('pegawai.nonactive', $data->id) }}" class="btn btn-danger"><i data-feather="x-circle" class="font-size-14 me-1"></i>
                                        Nonaktifkan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (Session::has('success'))
                <div id="alert" class="mt-5">
                    <div class="alert alert-success py-4 fade-message alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                        <i class="fa fa-check-circle"></i>
                        <strong>Berhasil!</strong> - {{ \Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <script>
                    $(function(){
                        setTimeout(function() {$('.fade-message').close();}, 2000);
                    });
                    </script>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab"
                                        aria-selected="true">Data Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#akun" role="tab"
                                        aria-selected="false">Data Akun</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#asuransi" role="tab"
                                        aria-selected="false">Data Asuransi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#tunjangan" role="tab"
                                        aria-selected="false">Data Tunjangan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Data Diri Pegawai</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 15%;">Nama</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>{{ $data->nama }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>NIP</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->nip }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->gender }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>No. HP</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->phone }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->email }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->alamat }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="akun" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Data Akun Pegawai</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 15%;">Username</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>{{ $data->username }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Lokasi Kantor</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->cabang->cabang_nama }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Company</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->company }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Akun</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->status }}</b></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
