@extends('layouts.main')

@section('title')
    Ubah Data Pegawai
@endsection

@section('content')
<div class="row px-4">
    <div class="col-12">
        <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
            <div class="mb-3">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                    <li class="breadcrumb-item active">Pegawai</li>
                </ol>
                <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Pegawai</h4>
            </div>
        </div>
        <div id="alert">
            @if (Session::has('success'))
            <div class="alert alert-success py-4 fade-message alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                <i class="fa fa-info-circle"></i>
                <strong>Berhasil!</strong> - {{ \Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

                <script>
                $(function(){
                    setTimeout(function() {
                        $('.fade-message').close();
                    }, 2000);
                });
                </script>
            @endif
        </div>
        <div class="d-flex flex-column flex-column-fluid" id="kt_content"">
            <div class="mx-10 card card-custom gutter-b">
                <div class="card-body">
                    <form action="{{ route('pegawai.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Nama Lengkap</label>
                                    <input class='form-control' type="text" name="nama" id="" value="{{ $data->nama }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Nomor Induk Pegawai</label>
                                    <input class='form-control' type="text" name="nip" id="" value="{{ $data->nip }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">No. HP</label>
                                    <input class='form-control' type="text" name="phone" id="" value="{{ $data->phone }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Email</label>
                                    <input class='form-control' type="text" name="email" id="" value="{{ $data->email }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Jenis Kelamin</label>
                                    <select id="gender" class="form-select" name="gender">
                                        <option value='Laki-Laki'>Laki-Laki</option>
                                        <option value='Perempuan'>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Username</label>
                                    <input class='form-control' type="text" name="username" id="" value="{{ $data->username }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Status Akun</label>
                                    <select id="status" class="form-select" name="status">
                                        <option value='active'>Aktif</option>
                                        <option value='not active'>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Lokasi Kantor</label>
                                    <select id="cabang" class="form-select" name="id_cabang">
                                        <option value='{{ $data->id_cabang }}' disabled selected>{{ $data->cabang->cabang_nama }}</option>
                                        @php
                                            $query = App\Models\Cabang::where('id_admin', auth()->user()->id)->get();
                                        @endphp
                                        @foreach ($query as $r)
                                        <option value='{{ $r->id }}'>{{ $r->cabang_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Company</label>
                                    <input class='form-control' type="text" name="company" id="" value="{{ $data->company }}">
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-4">

                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Status Perkawinan</label>
                                    <select id="tanggungan" class="form-select" name="tanggungan">
                                        <option value='{{ $data->tanggungan }}' selected>{{ $data->tanggungan }}</option>
                                        <option value='TK/0'>TK/0</option>
                                        <option value='K/0'>K/0</option>
                                        <option value='K/1'>K/1</option>
                                        <option value='K/2'>K/2</option>
                                        <option value='K/3'>K/3</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">BPJS Kesehatan</label>
                                    <select id="bpjs_kes" class="form-select" name="bpjs_kes">
                                        <option value='y'>Ya</option>
                                        <option value='n'>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-input">Tanggal Mulai Kerja</label>
                                    <input id="my-input" class="form-control" type="date" name="tanggal_mulaiKerja" value="{{ $data->tanggal_mulaiKerja }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="my-select" class="font-weight-bolder">Alamat</label>
                                    <textarea id="my-textarea" class="form-control" name="alamat" rows="3">{{ $data->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                            <i class="fas fa-hdd icon-md"></i> &nbsp; Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
    {{-- <script src="{{ asset('backend-assets/js/pages/form-advanced.init.js') }}"></script> --}}
    <script>
        const element = document.querySelector('#tanggungan');
        const choices = new Choices(element);
        const element2 = document.querySelector('#cabang');
        const choices2 = new Choices(element2);
        const element3 = document.querySelector('#gender');
        const choices3 = new Choices(element3);
        const element4 = document.querySelector('#status');
        const choices4 = new Choices(element4);
        const element5 = document.querySelector('#bpjs_kes');
        const choices5 = new Choices(element5);
    </script>
@endpush
