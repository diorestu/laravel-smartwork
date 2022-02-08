@extends('layouts.main')

@section('title')
    Data Divisi
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .f-10 { font-size: 10px !important; }
    </style>
@endpush

@section('content')
    <div class="row px-4">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("divisi.index") }}">Divisi</a></li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Divisi</h4>
                    <p class="text-muted mt-1 text-opacity-50">Berikut adalah daftar semua data divisi</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn-soft-primary waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp;Impor/Ekspor Data</a>
                        {{-- <a class="btn btn-soft-success waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp; Data</a> --}}
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fa fa-plus icon-sm text-white"></i>
                            Tambah Divisi&nbsp;
                        </button>
                        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('divisi.store') }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Divisi</h5>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div data-scroll="true" data-height="400">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="div_title">Nama Divisi <span class="text-danger">*</span></label>
                                                            <input required id="div_title" class="form-control" type="text" name="div_title">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="div_desc">Deskripsi Singkat</label>
                                                            <input required id="div_desc" class="form-control" type="text" maxlength="200" name="div_desc">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success font-weight-bolder">
                                                <i class="fa fa-plus icon-sm"></i>
                                                Tambah Data Divisi</button>
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
                            <th>Nama Divisi</th>
                            <th>Deskripsi Singkat</th>
                            <th width="5%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class='font-weight-bolder'>{{ $i->div_title }}</td>
                                <td class="f-10"><i>{{ $i->div_desc }}</i></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" href='{{ route('divisi.edit', $i->div_id) }}'>
                                                <span><i class="fas fa-edit icon-sm"></i></span>&nbsp;
                                                Edit
                                            </a></li>
                                            <li><a id="{{ $i->div_id }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
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
                    text: 'Apakah Anda yakin ingin menghapus divisi ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('master/divisi') }}" + '/' + idStaff;
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
                                    Swal.fire('Berhasil', 'Berhasil menghapus data divisi', 'success')
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
