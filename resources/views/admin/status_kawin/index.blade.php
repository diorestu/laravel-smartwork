@extends('layouts.main')

@section('title')
    Data Status Kawin
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-header, .modal-header { background: rgb(219,66,66); background: linear-gradient(90deg, rgba(219,66,66,1) 0%, rgba(126,7,30,1) 100%); }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("status-kawin.index") }}">Tunjangan</a></li>
                        <li class="breadcrumb-item active">Status Kawin</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Status Kawin</h4>
                    <p class="text-muted mt-1 text-opacity-50">Berikut adalah daftar semua data status kawin</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group mx-2" role="group">
                            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download icon-sm"></i> Ekspor Data <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                <a class="dropdown-item" href="{{ route("statusKawin.ekspor") }}">File Excel</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning waves-effect waves-light text-black" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fa fa-plus icon-sm text-black"></i>
                            Tambah Status Kawin&nbsp;
                        </button>
                        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('status-kawin.store') }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Status Kawin</h5>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div data-scroll="true" data-height="400">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="status_kawin">Status Kawin <span class="text-danger">*</span></label>
                                                            <input required id="status_kawin" class="form-control" type="text" name="status_kawin">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-4 form-group">
                                                            <label for="status_kawin_tunjangan">Jumlah Tunjangan <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text" id="my-addon">Rp</span></div>
                                                                <input required class="form-control" type="number" id="status_kawin_tunjangan" name="status_kawin_tunjangan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success btn-block w-100 font-weight-bolder"><i class="fa fa-plus icon-sm"></i> Tambah Data Status Kawin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-custom gutter-b rounded-sm shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="">No</th>
                            <th>Status Kawin</th>
                            <th>Jumlah Tunjangan</th>
                            <th width="5%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class='text-primary font-weight-bolder'>{{ $i->status_kawin }}</td>
                                <td>{{ rupiah($i->status_kawin_tunjangan) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" href='{{ route('status-kawin.edit', $i->id) }}'>
                                                <span><i class="fas fa-edit icon-sm"></i></span>&nbsp;
                                                Edit
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
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
                columnDefs: [
                    { searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 1 },
                    { orderable: false, searchable: false, targets: 1 },
                  ],
                  order: [[0, 'asc']]
            });
            $('#myTable').on('click', '.remove', function() {
                var table = $('#myTable').DataTable();
                var row_index = table.row($(this).closest('tr'));
                var idStaff = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus status kawin ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('master/tunjangan/status-kawin') }}" + '/' + idStaff;
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
                                    Swal.fire('Berhasil', 'Berhasil menghapus data status kawin', 'success')
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
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil','{{ \Session::get('success') }}','success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal','{{ \Session::get('error') }}','error')
        </script>
    @endif
@endpush
