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
            <h2 class="font-weight-boldest">Riwayat Cuti Pegawai</h2>
            <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            </p>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table rounded" id="myTable">
            <thead class="thead-light">
                <tr>
                    <th class="text-left">Nama</th>
                    <th class="text-center" width="">Tanggal Awal Cuti</th>
                    <th class="text-center" width="">Tanggal Akhir Cuti</th>
                    <th class="text-center" width="">Total Hari Cuti</th>
                    <th class="text-center" width="">Keterangan Cuti</th>
                    <th class="text-center" width="5%">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td>{{ $i->user->nama }}</td>
                        <td class="text-center">{{ $i->cuti_awal }}</td>
                        <td class="text-center">{{ $i->cuti_akhir }}</td>
                        <td class="text-center">{{ $i->cuti_total }} Hari</td>
                        <td class="text-center">{{ $i->cuti_deskripsi }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                    <li><a class="dropdown-item" href='{{ route('cuti.edit', $i->id_cuti) }}'>
                                            <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit
                                        </a></li>
                                    <li>
                                        <form action="{{ route('cuti.destroy', $i->id_cuti) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa fa-times icon-md"></i>
                                                <b>&nbsp;Hapus</b>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('addon-script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [15, 35, 75, 100],
                columnDefs: [
                    { orderable: false, targets: 4 },
                    { orderable: false, searchable: false, targets: 5 },
                  ],
                  order: [[0, 'asc']]
            });
        })
    </script>
@endpush
