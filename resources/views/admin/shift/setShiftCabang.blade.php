@extends('layouts.main')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="pt-10 px-20">
            <div class="px-4 d-flex justify-content-between">
                <div>
                    <h2 class="font-weight-boldest">Buat Jadwal Kerja</h2>
                    <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="card gutter-b card-stretch ">
                        <form action="{{ route('shift.store') }}" method="post">
                            @method('POST')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="my-input">Nama Shift</label>
                                    <input id="my-input" class="form-control" type="text" name="nama_shift">
                                </div>
                                <div class="form-group">
                                    <label for="my-input">Keterangan Shift</label>
                                    <input id="my-input" class="form-control" type="text" name="ket_shift">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="my-input">Jam Hadir</label>
                                            <input id="my-input" class="form-control" type="time" name="hadir_shift">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="my-input">Jam Hadir</label>
                                            <input id="my-input" class="form-control" type="time" name="pulang_shift">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger btn-block">Set Jam Kerja</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card gutter-b card-stretch p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Nama Shift</td>
                                        <td width="30%" align"center">Jam Hadir</td>
                                        <td width="30%" align="center">Jam Pulang</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->nama_shift }}</td>
                                        <td align="center">{{ $item->hadir_shift }}</td>
                                        <td align="center">{{ $item->pulang_shift }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
