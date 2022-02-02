@extends('layouts.main')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css"/>
@endpush

@section('content')
        <div class="d-flex justify-content-between">
            <div>
                <h2 class="font-weight-boldest">Proses Penggajian Pegawai</h2>
                <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
        </div>

        <div class="card card-custom rounded-sm shadow-md">
            <div class="card-body px-4 py-5">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="font-weight-boldest">Lengkapi Data Berikut</h6>
                        <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        </p>
                    </div>
                </div>
                <form action="{{ route('payroll.store') }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="my-select">Kode Penggajian</label>
                                <input class='form-control form-control-solid font-weight-bolder' type="text" name="pay_code" id="" value="ASTA-{{ date('m-Y') }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="my-select">Pilih Cabang</label>
                                <select id="my-select" class="form-control" name="id_cabang">
                                    @foreach ($data as $item)
                                    <option value='{{ $item->id }}'>{{ $item->cabang_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="my-select">Pilih Bulan</label>
                                <select id="my-select" class="form-control" name="pay_bulan">
                                    <option value='01'>Januari</option>
                                    <option value='02'>Februari</option>
                                    <option value='03'>Maret</option>
                                    <option value='04'>April</option>
                                    <option value='05'>Mei</option>
                                    <option value='06'>Juni</option>
                                    <option value='07'>Juli</option>
                                    <option value='08'>Agustus</option>
                                    <option value='09'>September</option>
                                    <option value='10'>Oktober</option>
                                    <option value='11'>November</option>
                                    <option value='12'>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <div class="form-group">
                                <label for="my-select">Pilih Tahun</label>
                                <input class='form-control form-control-solid font-weight-bolder' type="text" name="pay_tahun" id="" value="{{ date('Y') }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <div class="form-group">
                                <label for="my-select">Keterangan Penggajian</label>
                                <input class='form-control' type="text" name="pay_description" id="">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger w-100 mt-3 font-weight-boldest btn-lg" type="submit">
                        <i class="fas fa-hdd icon-md"></i>Submit Proses Penggajian
                    </button>
                </form>
            </div>
        </div>
@endsection





