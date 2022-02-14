@extends('layouts.main')

@section('title')
    Buat Jadwal Kerja Baru
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="px-0 d-flex justify-content-between">
        <div>
            <h2 class="font-weight-boldest">Buat Jadwal Kerja</h2>
            <p class="text-muted">Buat jadwal kerja baru untuk pegawai Anda</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card mb-0 mb-sm-10">
                <form action="{{ route('shift.store') }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="card-body p-4">
                        <div class="form-group mb-3">
                            <label for="nama_shift">Kode Shift <span class="text-danger">*</span></label>
                            <input required id="nama_shift" class="form-control" type="text" name="nama_shift">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_shift">Nama Shift <span class="text-danger">*</span></label>
                            <input required id="nama_shift" class="form-control" type="text" name="ket_shift">
                        </div>
                        <div class="row mb-0">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="hadir_shift">Jam Hadir <span class="text-danger">*</span></label>
                                    <input id="hadir_shift" class="form-control" type="time" name="hadir_shift">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="pulang_shift">Jam Hadir <span class="text-danger">*</span></label>
                                    <input id="pulang_shift" class="form-control" type="time" name="pulang_shift">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success btn-block w-100 btn-md mt-5" type="submit">
                            <i class="fas fa-plus-circle icon-md"></i>&nbsp;Buat Jam Kerja Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="card gutter-b card-stretch p-4">
                <div>
                    <table class="table table-hover" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <td>Kode</td>
                                <td>Nama Shift</td>
                                <td width="20%" align="center">Clock In</td>
                                <td width="20%" align="center">Clock Out</td>
                                <td width="5%" align="center">Opsi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->nama_shift }}</td>
                                <td>{{ $item->ket_shift }}</td>
                                <td align="center">{{ Carbon\Carbon::parse($item->hadir_shift)->format('H:i') }}</td>
                                <td align="center">{{ Carbon\Carbon::parse($item->pulang_shift)->format('H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEdit" data-bs-remote="false" href='{{ url('shift', $item->id) }}/edit'>
                                                <span><i class="fas fa-pen icon-sm"></i></span>&nbsp;
                                                Ubah
                                            </a></li>
                                            <li><a id="{{ $item->id }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
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
    </div>

    <div class="modal fade" id="modalEdit" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $("#modalEdit").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("href"));
        });
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
                columnDefs: [
                    { searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 0 },
                  ],
                  order: [[0, 'desc']]
            });
            $('#myTable').on('click', '.remove', function() {
                var table = $('#myTable').DataTable();
                var row_index = table.row($(this).closest('tr'));
                var idStaff = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus shift ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('shift') }}" + '/' + idStaff;
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
                                    Swal.fire('Berhasil', 'Berhasil menghapus shift', 'success')
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
