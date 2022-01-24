@extends('layouts.admin')

@section('title')
    smartwork
@endsection

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
                <form action="{{ route('upah.update', $data->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="my-input">Nama</label>
                                <input id="my-input" class="form-control" type="text" name="" value='{{ $data->nama }}'>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="my-input">Gaji Pokok</label>
                                <input id="my-input" class="form-control" type="number" name="gaji_pokok" value='{{ $data->gaji_pokok }}'>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-danger btn-block font-weight-boldest btn-lg" type="submit">
                        <i class="fas fa-pen icon-md"></i>Simpan Perubahan Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection





