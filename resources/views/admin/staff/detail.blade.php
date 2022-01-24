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
                                        <h5 class="font-size-16 mb-1">{{ $data->nama }} - ({{ $data->nip }})</h5>
                                        <p class="text-muted font-size-13 mb-2 pb-2">{{ $data->cabang->cabang_nama }}</p>
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
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#post" role="tab"
                                        aria-selected="false">Data Personalia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#post" role="tab"
                                        aria-selected="false">Lokasi Tugas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">About</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>:</td>
                                                    <td>{{ $data->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td>NIP</td>
                                                    <td>:</td>
                                                    <td>{{ $data->nip }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pengguna</td>
                                                    <td>:</td>
                                                    <td>{{ $data->username }}</td>
                                                </tr>
                                                <tr>
                                                    <td>No. HP</td>
                                                    <td>:</td>
                                                    <td>{{ $data->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>{{ $data->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>:</td>
                                                    <td>{{ $data->alamat }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="post" role="tabpanel">
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Skills</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 font-size-16">
                                <a href="#" class="badge badge-soft-primary">Photoshop</a>
                                <a href="#" class="badge badge-soft-primary">illustrator</a>
                                <a href="#" class="badge badge-soft-primary">HTML</a>
                                <a href="#" class="badge badge-soft-primary">CSS</a>
                                <a href="#" class="badge badge-soft-primary">Javascript</a>
                                <a href="#" class="badge badge-soft-primary">Php</a>
                                <a href="#" class="badge badge-soft-primary">Python</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
