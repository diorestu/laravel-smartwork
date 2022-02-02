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
                    <div class="card rounded-sm">
                        @php
                            $id = Auth::user()->id;
                            $data = App\Models\User::where('id_admin', $id)
                                ->where('roles', 'user')
                                ->get();
                            $cabang = App\Models\Cabang::where('id_admin', $id)->get();
                            $shift = App\Models\Shift::where('id_admin', $id)->get();
                        @endphp
                        <form action="{{ route('jadwal.store') }}" method="post">
                            @method('POST')
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="cabang">Pilih Lokasi Kerja</label>
                                    <select id="cabang" class="form-select" name="id_cabang">
                                        @foreach ($cabang as $c)
                                            <option value="{{ $c->id }}">{{ $c->cabang_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama">Pilih Nama Pegawai</label>
                                    <select id="nama" class="form-select" name="id_user">
                                        {{-- @foreach ($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="shift">Jam Kerja</label>
                                    <select id="shift" class="form-select" name="nama_shift">
                                        @foreach ($shift as $i)
                                            <option value="{{ $i->id }}">{{ $i->nama_shift }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Set Jam Kerja</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card p-3 rounded-sm">
                        <div class="d-flex justify-content-end mb-4">
                            <a class="btn btn-success btn-sm font-weight-bold" data-bs-toggle="modal"
                                data-bs-target="#crudModal"><i class="fa fa-upload icon-sm text-white"></i>Impor Data</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <td>Nama Shift</td>
                                        <td width="30%" align"center">Jam Hadir</td>
                                        <td width="30%" align="center">Jam Pulang</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->nama_shift }}</td>
                                        <td align="center">{{ $item->hadir_shift }}</td>
                                        <td align="center">{{ $item->pulang_shift }}</td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal-->
            <div class="modal fade" id="crudModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-modal="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('post.shift.user') }}" method="post" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Impor Jadwal Kerja</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-5">
                                {{-- <input type="file" name="excel" id="" class="form-control"> --}}
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="excel" required />
                                    <label class="custom-file-label" for="customFile">Pilih File Excel</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-soft-danger"
                                    data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success fw-bold">
                                    <i class="fa fa-plus icon-sm"></i>
                                    Import Excel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cabang').select2();
            $('#nama').select2();
            $('#shift').select2();
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#cabang').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '/getCabang/' + categoryID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data != []) {
                                $('#nama').empty();
                                $('#nama').append(
                                '<option hidden disabled>Pilih Unit Bertugas</option>');
                                $.each(data, function(key, unit) {
                                    $('#nama').append('<option value="' +
                                        unit.id + '">' + unit.nama + '</option>');
                                });
                            } else {
                                $('#nama').empty();
                            }
                        }
                    });
                } else {
                    $('#nama').empty();
                    $('#nama').append('<option hidden>Tidak Ada Data</option>');

                }
            });
        });
    </script>
@endpush
