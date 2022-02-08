@extends('layouts.main')

@section('title')
    Data Lokasi Kerja
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
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('cabang.index') }}">Lokasi Kerja</a></li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Lokasi Kerja</h4>
                <p class="text-muted mt-1 text-opacity-50">Berikut adalah daftar semua lokasi kerja pegawai Anda</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn-soft-primary waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp;Impor/Ekspor Data</a>
                        {{-- <a class="btn btn-soft-success waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp; Data</a> --}}
                        <button type="button" class="btn btn-warning waves-effect waves-light text-black" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="fa fa-plus icon-sm text-black"></i>
                            Tambah Lokasi&nbsp;
                        </button>
                        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('cabang.store') }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Lokasi Kerja</h5>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div data-scroll="true" data-height="400">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="cabang_nama">Nama Lokasi Kerja <span class="text-danger">*</span></label>
                                                            <input required id="cabang_nama" class="form-control" type="text" name="cabang_nama">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="cabang_phone">Telepon <span class="text-danger">*</span></label>
                                                            <input required id="cabang_phone" class="form-control" type="text" name="cabang_phone">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="cabang_lat">Kordinat Latitude <span class="text-danger">*</span></label>
                                                            <input required id="cabang_lat" class="form-control" type="text" name="cabang_lat">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-4 form-group">
                                                            <label for="cabang_umk">Nilai Upah <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text" id="my-addon">Rp</span></div>
                                                                <input required class="form-control" type="number" id="cabang_umk" name="cabang_umk">
                                                            </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="cabang_email">Email <span class="text-danger">*</span></label>
                                                            <input required id="cabang_email" class="form-control" type="email" name="cabang_email">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="cabang_long">Kordinat Longitude <span class="text-danger">*</span></label>
                                                            <input required id="cabang_long" class="form-control" type="text" name="cabang_long">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-0">
                                                            <label for="cabang_alamat">Alamat <span class="text-danger">*</span></label>
                                                            <input required id="cabang_alamat" class="form-control" type="text" max="100" name="cabang_alamat">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-block w-100 btn-success"><i class="fa fa-plus icon-sm"></i> Tambah Lokasi Kerja Baru</button>
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
    <div class="card card-custom gutter-b rounded-sm shadow-md">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Lokasi Kerja</th>
                            <th>Alamat E-Mail</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="5%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td class='text-primary font-weight-bolder'>{{ $i->cabang_nama }}</td>
                                <td>{{ $i->cabang_email }}</td>
                                <td>{{ $i->cabang_phone }}</td>
                                <td>{{ $i->cabang_alamat }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" href='{{ route('cabang.show', $i->id) }}'>
                                                <span><i class="fas fa-info-circle icon-sm"></i></span>&nbsp; Detail
                                            </a></li>
                                            <li><a class="dropdown-item" href='{{ route('cabang.edit', $i->id) }}'>
                                                <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Update
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
    {{-- <script src="{{ asset('backend-assets/js/pages/form-advanced.init.js') }}"></script> --}}
    <script>
        // const element2 = document.querySelector('#cabang');
        // const choices2 = new Choices(element2);
    </script>
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
                columnDefs: [
                    { searchable: true, targets: 0 },
                    { orderable: true, searchable: true, targets: 0 },
                ],
                order: [[0, 'asc']]
            });
            $('#myTable').on('click', '.remove', function() {
                var table = $('#myTable').DataTable();
                var row_index = table.row($(this).closest('tr'));
                var idStaff = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus lokasi kerja ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('master/cabang') }}" + '/' + idStaff;
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
                                    Swal.fire('Berhasil', 'Berhasil menghapus lokasi kerja', 'success')
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
