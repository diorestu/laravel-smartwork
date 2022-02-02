@extends('layouts.main')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')

            <div class="px-4 d-flex justify-content-between">
                <div>
                    <h2 class="font-weight-boldest">Penggajian Pegawai</h2>
                    <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    </p>
                </div>
                <div>
                    <div class="btn-group btn-group-toggle " data-toggle="buttons">
                        <a href='{{ route('payroll.create') }}' class="btn btn-outline-dark btn-shadow">
                            <i class="fa fa-plus-circle icon-md text-danger"></i>
                            Proses Penggajian
                            <i class="fa fa-chevron-right icon-xs text-danger"></i>
                        </a>
                        <a href='/' class="btn btn-outline-dark btn-shadow">
                            <i class="fa fa-eye icon-md text-danger"></i>
                            Lihat Data Upah
                            <i class="fa fa-chevron-right icon-xs text-danger"></i>
                        </a>
                    </div>
                </div>
            </div>

            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show py-5" role="alert">
                <h3 class="font-weight-boldest alert-heading">Berhasil!</h3>
                <span>Proses penggajian telah selesai ditambahkan, silahkan lihat detail untuk melihat lebih lengkap data penggajian!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            @endif

            <div class="card card-custom gutter-b rounded-lg shadow-md">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Kode Payroll</th>
                                    <th>Keterangan</th>
                                    <th width="">Jumlah</th>
                                    <th width="10%">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i)
                                    <tr>
                                        <td>{{ $i->pay_code }}</td>
                                        <td>{{ $i->pay_description }}</td>
                                        <td>Rp {{ number_format($i->total) }}</td>
                                        <td>
                                            <a href="{{ route('payroll.show', $i->pay_code) }}">
                                                <span class="text-primary fw-regular font-size-10">
                                                    <i class="fa fa-info-circle text-muted me-1"></i>Detail
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
