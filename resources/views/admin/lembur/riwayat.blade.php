@extends('layouts.main')

@section('title')
    Lembur Disetujui - Bulan {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Lembur Pegawai</a></li>
                        <li class="breadcrumb-item active">Lembur Disetujui Bulan Ini</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Lembur Disetujui Bulan {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}</h4>
                    <p class="text-muted mt-1 text-opacity-50">Data lembur pegawai yang disetujui periode {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn-soft-primary waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp;Impor/Ekspor Data</a>
                        <a href="{{ route('lembur.index') }}" class="btn btn-warning waves-effect waves-light text-black">
                            <i class="fa fa-clock icon-sm text-black"></i> Lihat Permohonan Lembur Pegawai&nbsp;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom gutter-b rounded-sm shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table rounded" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Cabang</th>
                            <th class="text-left">Lembur</th>
                            <th class="text-center">Jam Lembur</th>
                            <th class="text-center">Detail</th>
                            <th class="text-center" width="5%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr data-child-value="
                                <tr>
                                    <td>Judul</td>
                                    <td>:</td>
                                    <td width='70%'>{{ $i->lembur_judul }}</td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td width='70%'>{{ $i->lembur_keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lembur</td>
                                    <td>:</td>
                                    <td width='70%'>{{ tanggalIndoWaktuLengkap($i->lembur_awal)." - ".tanggalIndoWaktuLengkap($i->lembur_akhir) }}</td>
                                </tr>
                                <tr>
                                    <td>Jam Kerja</td>
                                    <td>:</td>
                                    <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->jam_kerja }} jam</span></td>
                                </tr>
                                <tr>
                                    <td>Jam Lembur</td>
                                    <td>:</td>
                                    <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->jam_lembur }} jam</span></td>
                                </tr>
                                <tr>
                                    <td>Status Lembur</td>
                                    <td>:</td>
                                    @if ($i->lembur_status == 'DITERIMA')
                                    <td width='70%'><span class='badge rounded-pill badge-soft-success text-success'>{{ $i->lembur_status }}</span></td>
                                    @elseif($i->lembur_status == 'PENGAJUAN')
                                    <td width='70%'><span class='badge rounded-pill badge-soft-primary text-primary'>{{ $i->lembur_status }}</span></td>
                                    @else
                                    <td width='70%'><span class='badge rounded-pill badge-soft-danger text-danger'>{{ $i->lembur_status }}</span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Diajukan Pada</td>
                                    <td>:</td>
                                    <td width='70%'>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>
                                </tr>
                                ">
                                <td>{{ $i->user->nama }}</td>
                                <td>{{ $i->user->cabang->cabang_nama }}</td>
                                <td class="text-left">{{ tanggalIndo3($i->cuti_awal) }} - {{ tanggalIndo3($i->cuti_akhir) }}</td>
                                <td class="text-center">{{ $i->jam_lembur }} jam</td>
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
                                            <li><a class="dropdown-item" href='{{ route('lembur.edit', $i->id) }}'><span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit</a></li>
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
        function format ( data ) {
            return '<table class="table">'+data+'</table>';
        }
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
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
                var idLembur = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus lembur ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('kelola/lembur') }}" + '/' + idLembur;
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
                                    Swal.fire('Berhasil', 'Berhasil menghapus lembur pegawai', 'success')
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
