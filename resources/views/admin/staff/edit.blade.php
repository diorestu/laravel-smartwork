@extends('layouts.main')

@section('title')
    Ubah Data Pegawai
@endsection

@section('content')
<div class="d-flex flex-column flex-column-fluid" id="kt_content"">
    <div class="mx-10 card card-custom gutter-b">
        <div class="card-body">
            <form action="{{ route('pegawai.update', $data->id) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group mb-5">
                            <label for="my-select" class="font-weight-bolder">Nama Lengkap</label>
                            <input class='form-control' type="text" name="nama" id="" value="{{ $data->nama }}">
                        </div>
                        <div class="form-group mb-5">
                            <label for="my-select" class="font-weight-bolder">Nama Pengguna</label>
                            <input class='form-control' type="text" name="username" id="" value="{{ $data->username }}">
                        </div>
                        <div class="form-group mb-5">
                            <label for="my-select" class="font-weight-bolder">Email</label>
                            <input class='form-control' type="text" name="email" id="" value="{{ $data->email }}">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="my-select" class="font-weight-bolder">Nama Perusahaan</label>
                            <input class='form-control' type="text" name="company" id="" value="{{ $data->company }}">
                        </div>
                        <div class="form-group">
                            <label for="my-select" class="font-weight-bolder">Alamat Perusahaan</label>
                            <textarea id="my-textarea" class="form-control" name="alamat" rows="5">{{ $data->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group mb-5">
                            <label for="my-select" class="font-weight-bolder">Lokasi Bertugas</label>
                            <select id="my-select" class="custom-select" name="id_cabang">
                                <option value='{{ $data->id_cabang }}' disabled selected>{{ $data->cabang->cabang_nama }}</option>
                                @php
                                    $query = App\Models\Cabang::where('id_admin', auth()->user()->id)->get();
                                @endphp
                                @foreach ($query as $r)
                                <option value='{{ $r->id }}'>{{ $r->cabang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-5">
                            <label for="my-select" class="font-weight-bolder">Status Perkawinan</label>
                            <select id="my-select" class="custom-select" name="tanggungan">
                                <option value='{{ $data->tanggungan }}' selected>{{ $data->tanggungan }}</option>
                                <option value='TK/0'>TK/0</option>
                                <option value='K/0'>K/0</option>
                                <option value='K/1'>K/1</option>
                                <option value='K/2'>K/2</option>
                                <option value='K/3'>K/3</option>
                            </select>
                        </div>
                        <div class="form-group mb-5">
                            <label for="my-select" class="font-weight-bolder">No. HP</label>
                            <input class='form-control' type="text" name="phone" id="" value="{{ $data->phone }}">
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger btn-block btn-lg mt-5" type="submit">
                    <i class="fas fa-hdd icon-md"></i>Simpan Profil
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
