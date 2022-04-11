@extends('layouts.main')

@section('title')
    Laporan Absensi Pegawai
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .f-10 { font-size: 10px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .text-tipis  { font-weight: 300; opacity: 0.5; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Absensi</a></li>
                        <li class="breadcrumb-item active">Laporan Abensi Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Laporan Abensi Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Lihat laporan absensi pegawai dengan waktu tertentu</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="#" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <div class="form-group">
                                    <label for="waktu">Pilih Rentang Waktu <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                        <input type="text" class="form-control daterange" id="waktu" name="waktu" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 d-flex align-items-end">
                                <button class="btn btn-warning w-100 mt-1 font-weight-boldest btn-md text-black" type="submit">
                                    <i class="fas fa-info-circle icon-md"></i> Lihat Data
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex" id="content">
            <div class="col-6 px-2">
                <div class="card shadow rounded-sm">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex justify-content-between">
                            <h4>Ringkasan Absensi</h4>
                            <div class="row" id="userstable_filter"></div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover" id="myTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Lokasi Kerja</th>
                                        <th width="5%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>Damas</td>
                                            <td>Asta Pijar</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="#">
                                                        <li><a class="dropdown-item" href='{{ route('laporan.detail_absensi') }}'>
                                                            <span><i class="fas fa-info-circle icon-sm"></i></span>&nbsp;Lihat Detail
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 px-2">
                <div class="card shadow rounded-sm">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex justify-content-between">
                            <h4>Pegawai Terajin</h4>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover" id="myTable2">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Lokasi Kerja</th>
                                        <th>Tepat Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr class="f-10">
                                            <td>
                                                Damas<br>
                                                <span class="text-tipis">Asta Pijar</span>
                                            </td>
                                            <td>Asta Pijar</td>
                                            <td>3</td>
                                        </tr>
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
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable2').DataTable({
                lengthMenu: [30, 60, 120, 240],
                order: [[0, 'asc']]
            });
            $('#myTable').DataTable({
                initComplete: function () {
                    this.api().columns([2]).every( function (jud) {
                        var theadname       = $("#myTable th").eq([jud]).text();
                        var column          = this;
                        const wrapper       = document.createElement('div');
                        wrapper.className   = 'filter_wp input-group';
                        wrapper.innerHTML   = '<div class="input-group-text"><i class="fa fa-filter"></i></div>';
                        var ss              = document.getElementById('userstable_filter').appendChild(wrapper);
                        var select          = '<select class="form-control"><option value="">Semua '+theadname+'</option></select>';
                        var damas           = $(select).appendTo(ss);
                        damas.on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            var ssss = column.search( val ? '^'+val+'$' : '', true, false ).draw();
                            // console.log();
                        });
                        @php $q_cabang = App\Models\Cabang::where('id_admin', auth()->user()->id)->get(); @endphp
                        @foreach ($q_cabang as $r_cabang)
                            damas.append( '<option value="{{ $r_cabang->cabang_nama }}">{{ $r_cabang->cabang_nama }}</option>' )
                        @endforeach
                    });
                },
                lengthMenu: [30, 60, 120, 240],
                order: [[0, 'asc']]
            });
        });
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var hari = $("#waktu").val();
            var formData = new FormData(this);
            if (hari != "") {
                var url = "{{ url('laporan/data-absensi') }}";
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
                Swal.fire('Maaf','Silahkan pilih rentang waktu terlebih dahulu.','error');
            }
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





