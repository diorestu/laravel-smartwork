@extends('layouts.admin')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css"/>
@endpush

@section('content')
<div class="d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="py-5 px-10">
        <div class="px-4 d-flex justify-content-between">
            <div>
                <h2 class="font-weight-boldest">Tambah Upah Karyawan</h2>
                <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
        </div>

        <div class="card card-custom rounded-lg shadow-md">
            <div class="card-body p-10">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="font-weight-boldest">Lengkapi Data Berikut</h6>
                        <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        </p>
                    </div>
                </div>
                <form action="{{ route('upah.store') }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="my-select">Pilih Cabang</label>
                                <select id="my-select" class="form-control" name="id_cabang">
                                    @foreach ($data as $item)
                                    <option value='{{ $item->id }}'>{{ $item->cabang_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="my-input">Masukkan Nilai Upah</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="my-addon">Rp</span>
                                    </div>
                                    <input class="form-control" type="number" name="gaji_pokok" placeholder="Jumlah Gaji Pokok">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-block font-weight-boldest btn-lg" type="submit">
                        <i class="fas fa-hdd icon-md"></i>Submit Upah
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection





