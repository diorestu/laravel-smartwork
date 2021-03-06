@extends('layouts.main')

@section('title')
    Data Pegawai
@endsection

@push('addon-style')
    <!-- DataTables -->
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
                        <li class="breadcrumb-item active">Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Berikut adalah daftar semua data diri pegawai Anda</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group mx-2" role="group">
                            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download icon-sm"></i> Ekspor Data <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                <a class="dropdown-item" href="{{ route("pegawai.ekspor") }}">File Excel</a>
                            </div>
                        </div>
                        <button {{ $btn ? 'disabled' : '' }} type="button" class="btn btn-warning waves-effect waves-light text-black" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="btnModal">
                            <i class="fa fa-plus icon-sm text-black"></i>
                            Tambah Pegawai&nbsp;
                        </button>
                        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('pegawai.store') }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div data-scroll="true" data-height="400">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="my-input">Nomor Identitas (KTP / SIM) <span class="text-danger">*</span></label>
                                                            <input id="my-input" class="form-control" type="text" name="nik">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Nomor Induk Pegawai <span class="text-danger">*</span></label>
                                                            <input id="my-input" class="form-control" type="text" name="nip">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Nama Pegawai <span class="text-danger">*</span></label>
                                                            <input id="my-input" class="form-control" type="text" name="nama">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="cabang" class="font-weight-bolder">Lokasi Absensi Kantor <span class="text-danger">*</span></label>
                                                            <select id="cabang" class="form-select" name="id_cabang">
                                                                @php $query = App\Models\Cabang::where('id_admin', auth()->user()->id)->get(); @endphp
                                                                @foreach ($query as $r)
                                                                <option value='{{ $r->id }}'>{{ $r->cabang_nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group mb-4">
                                                            <label for="cabang" class="font-weight-bolder">Tipe Identitas <span class="text-danger">*</span></label>
                                                            <select id="cabang" class="form-select" name="tipe_id">
                                                                <option value='KTP'>KTP</option>
                                                                <option value='SIM'>SIM</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="phone" class="font-weight-bolder">No. HP <span class="text-danger">*</span></label>
                                                            <input class='form-control' type="text" name="phone" id="phone" value="">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Username <span class="text-danger">*</span></label>
                                                            <input id="my-input" class="form-control" type="text" name="username">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Kata Sandi <span class="text-danger">*</span></label>
                                                            <input id="my-input" class="form-control" type="text" name="password">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success btn-block w-100 font-weight-bolder"><i class="fa fa-plus icon-sm"></i> Tambah Data Pegawai</button>
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
                <style>
                    th, td { white-space: nowrap; }
                    div.dataTables_wrapper {
                        margin: 0 auto;
                    }
                </style>
                <table class="table table-hover" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="40" style="z-index: 99 !important;">NIP</th>
                            <th width="220" style="z-index: 99 !important;">Nama Lengkap</th>
                            <th width="50">Usia</th>
                            <th width="50">Agama</th>
                            <th width="120">Lokasi</th>
                            <th width="30">Kelamin</th>
                            <th width="50">Gol. Darah</th>
                            <th width="50">No. HP</th>
                            <th width="50">Username</th>
                            <th width="50">Status</th>
                            <th width="120">TMT</th>
                            <th width="">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td class='bg-light text-primary font-weight-bolder'>{{ $i->nip }}</td>
                                <td class="bg-light">{{ $i->nama }}</td>
                                <td>{{ Carbon\Carbon::now()->diffInYears($i->tgl_lahir) }} th</td>
                                <td>{{ $i->agama }}</td>
                                <td><span class="font-weight-boldest">{{ $i->cabang->cabang_nama }}</span></td>
                                <td>{{ $i->gender }}</td>
                                <td>{{ $i->gol_darah }}</td>
                                <td>{{ $i->phone }}</td>
                                <td>{{ $i->username }}</td>
                                <td>
                                    @if ($i->status == 'active')
                                    &nbsp; <span><i class="fas text-success fa-check-circle icon-sm"></i></span> Aktif
                                    @else
                                    &nbsp; <span><i class="fas text-warning fa-exclamation-circle icon-sm"></i></span> Non Aktif
                                    @endif
                                </td>
                                <td>{{ $i->tanggal_mulaiKerja }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" href='{{ route('pegawai.show', $i->id) }}'>
                                                <span><i class="fas fa-info-circle icon-sm"></i></span>&nbsp;
                                                Detail
                                            </a></li>
                                            <li><a id="{{ $i->id }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
                                            {{-- <li><form action="{{ route('pegawai.destroy', $i->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa fa-trash text-danger me-2"></i>
                                                    <b>Hapus</b>
                                                </button>
                                            </form></li> --}}
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
        const element2 = document.querySelector('#cabang');
        const choices2 = new Choices(element2);
    </script>
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
                columnDefs: [
                    { searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 10 },
                    { orderable: false, searchable: false, targets: 11 },
                ],
                scrollY:        "500px",
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns: { left: 2, right: 0 },
                order: [[0, 'asc']],
                // rowGroup: {
                //     dataSrc: 4
                // }
            });
            $('#myTable').on('click', '.remove', function() {
                var table = $('#myTable').DataTable();
                var row_index = table.row($(this).closest('tr'));
                var idStaff = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus pegawai ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('master/pegawai') }}" + '/' + idStaff;
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
                                    Swal.fire('Berhasil', 'Berhasil menghapus staff', 'success')
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
