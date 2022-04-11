@extends('layouts.main')

@section('title')
    Riwayat Aktivitas Pegawai
@endsection

@push('addon-style')
    <!-- DataTables -->
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item active">Aktivitas Pegawai</li>
                    </ol>
                    <h4 class="fw-bold font-size-22 mt-3 mb-3">Riwayat Aktivitas Pegawai</h4>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-warning text-black dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download"></i> &nbsp; Ekspor Data &nbsp; <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Pilih Rentang Waktu
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <form id="formAction" action="#" method="POST">
                                        @method('POST')
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-9 col-md-9">
                                                <div class="form-group mb-4">
                                                    <label for="waktu">Rentang Waktu <span class="text-danger">*</span></label>
                                                    <input required id="waktu" class="form-control daterange" type="text" name="waktu" value="{{ $sesi_aktivitas }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3 mt-2">
                                                <button class="btn btn-primary w-100 mt-3 font-weight-boldest btn-md" type="submit">
                                                    <i class="fas fa-info-circle icon-md"></i> Lihat Data
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="content">
            @if ($data != null)
            <div class="card card-custom gutter-b rounded-sm shadow-sm">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table rounded" id="myTable">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-left">Nama</th>
                                    <th class="text-left">Cabang</th>
                                    <th class="text-left">Judul Aktivitas</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" width="5%">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i)
                                    <tr data-child-value="
                                        <tr>
                                            <td>Nama Pegawai</td>
                                            <td>:</td>
                                            <td width='70%'>{{ $i->user->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Judul Aktivitas</td>
                                            <td>:</td>
                                            <td width='70%'>{{ $i->judul_aktivitas }}</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td width='70%'>{{ $i->aktivitas }}</td>
                                        </tr>
                                        <tr>
                                            <td>Waktu Aktivitas</td>
                                            <td>:</td>
                                            <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->jam_aktivitas }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Diinput Pada</td>
                                            <td>:</td>
                                            <td width='70%'>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>
                                        </tr>
                                        ">
                                        <td>{{ $i->user->nama }}</td>
                                        <td>{{ $i->user->cabang->cabang_nama }}</td>
                                        <td class="text-left">{{ $i->judul_aktivitas }}</td>
                                        <td class="dt-control text-center">
                                            <a class="btn btn-primary btn-sm btn-circle" href="javascript:void(0);"><i class="fas fa-chevron-down"></i></a>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                                    <li><a class="dropdown-item" href='{{ route('aktivitas.edit', $i->id) }}'>
                                                            <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit
                                                    </a></li>
                                                    <li><a class="dropdown-item" href='{{ route('aktivitas.show', $i->id) }}'>
                                                            <span><i class="fas fa-info icon-sm"></i></span>&nbsp; Detail
                                                    </a></li>
                                                    <li><a id="{{ $i->id }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h1><i class="icon-sm fas fa-calendar"></i></h1>
                        <h3>Silahkan Pilih Rentang Waktu</h3>
                        <p>Untuk melihat data, silahkan set rentang waktu lalu klik lihat data.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        function format ( data ) {
            return '<table class="table">'+data+'</table>';
        }
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
                columnDefs: [
                    { searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 0 },
                ],
                order: [[0, 'asc']]
            });
            $('#myTable tbody').on('click', 'td.dt-control', function () {
                var table   = $('#myTable').DataTable();
                var tr      = $(this).closest('tr');
                var row     = table.row( tr );
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child(format(tr.data('child-value'))).show();
                    tr.addClass('shown');
                }
            });
            $('#myTable').on('click', '.remove', function() {
                var table = $('#myTable').DataTable();
                var row_index = table.row($(this).closest('tr'));
                var idAktivitas = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus aktivitas ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('kelola/aktivitas') }}" + '/' + idAktivitas;
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        });
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            beforeSend: function(){
                                Swal.showLoading()
                            },
                            success: function(result)
                            {
                                if (result == "ok") {
                                    row_index.remove().draw();
                                    Swal.fire('Berhasil', 'Berhasil menghapus aktivitas pegawai', 'success')
                                } else {
                                    Swal.fire('Gagal',result,'error')
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            });
        });
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var waktu = $("#waktu").val();
            var formData = new FormData(this);
            if (waktu != "") {
                var url = "{{ url('kelola/data-riwayat-aktivitas') }}";
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    url: url,
                    data: formData,
                    type: 'POST',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang Memproses Data...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false
                        });
                        Swal.showLoading();
                    },
                    success: function(result) {
                        $('#content').html(result);
                    },
                    complete: function(data) {
                        Swal.close();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                Swal.fire('Maaf','Silahkan pilih rentang waktu.','error');
            }
        });
    </script>
@endpush
