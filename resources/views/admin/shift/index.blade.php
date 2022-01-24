@extends('layouts.main')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
            <div class="d-flex justify-content-between align-items-center mx-2">
                <div>
                    <h2 class="font-weight-boldest">Data Jadwal Kerja</h2>
                    <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
                </div>
                <div>
                    <a href="{{ route('get.shift.user') }}" class="btn btn-soft-primary ms-2">
                        <i class="me-1 fa fa-layer-group icon-sm text-dark"></i>
                        Atur per Pegawai&nbsp;
                    </a>
                    <a href="{{ route('get.shift.cabang') }}" class="btn btn-soft-primary ms-2">
                        <i class="me-1 fa fa-layer-group icon-sm text-dark"></i>
                        Atur per Cabang&nbsp;
                    </a>
                    <a href="{{ route('shift.create') }}" class="btn btn-primary ms-2">
                        <i class="me-1 fa fa-plus icon-sm text-white"></i>
                        Tambah Jam Kerja&nbsp;
                    </a>
                </div>
            </div>
            <hr>

            <div class="row">
                @foreach (App\Models\Cabang::where('id_admin', auth()->user()->id)->get() as $item)
                <div class="col-3">
                    <div class="card rounded-sm">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ $item->cabang_nama }}</h5>
                                {{-- <span><i class="fa fa-check"></i></span> --}}
                            </div>
                            <p class="card-text">{{ $item->cabang_alamat }}</p>
                            <div class="d-flex justify-content-end align-self-end">
                                <a class="btn btn-soft-secondary btn-sm"><i class="fa fa-eye me-2"></i>Lihat Jadwal Kerja</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
