@extends('layouts.main')

@section('title')
    Data Cuti
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mx-2 mt-3">
        <div>
            <h2 class="font-weight-boldest">Data Cuti Pegawai</h2>
            <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            </p>
        </div>
        <div>
            <a href="{{ route('cuti.riwayat') }}" class="btn btn-soft-primary ms-2">
                <i class="me-1 fa fa-download icon-sm text-dark"></i>
                Lihat Riwayat Cuti Pegawai&nbsp;
            </a>
            <a href="{{ route('get.shift.user') }}" class="btn btn-soft-primary ms-2">
                <i class="me-1 fa fa-download icon-sm text-dark"></i>
                Rekap Cuti Pegawai&nbsp;
            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        @forelse ($data as $item)
            <div class="col-sm-6 col-md-3">
                <div class="card">
                    <img class="card-img-top img-fluid" src="{{ asset('backend-assets/images/small/img-2.jpg') }}"
                        alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">{{ $item->user->nama }}</h4>
                        <p class="card-text">{{ $item->cuti_deskripsi }}</p>
                        <p class="card-text">{{ $item->cuti_total }} hari</p>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <a href="{{ route('cuti.terima', $item->id_cuti) }}" class="card-link text-success"><i class="fa fa-check me-2"></i>Terima</a>
                        <a href="{{ route('cuti.tolak', $item->id_cuti) }}" class="card-link text-danger"><i class="fa fa-times me-2"></i>Tolak</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center">
                    <h4></h4>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@push('addon-script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        })
    </script>
@endpush
