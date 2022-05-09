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
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Lembur</a></li>
                        <li class="breadcrumb-item active">Laporan Lembur Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Laporan Lembur Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Lihat laporan Lembur pegawai dengan waktu tertentu</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="{{ route('ekspor.laporan.lembur') }}" method="POST">
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
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-sm">
                <div class="card-body px-4 py-4" id="content">
                    <div class="table-responsive">
                        <table class="table rounded" id="">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-left">In</th>
                                    <th class="text-center">Shift</th>
                                    <th class="text-left">Out</th>
                                    <th class="text-center">Jam Kerja</th>
                                    <th class="text-center">Jam Lembur</th>
                                    <th class="text-left">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <th colspan="6" class="text-left">
                                            <h5>Damasius Wikaryana Utama</h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="text-center">17 September 2022 09:00</td>
                                        <td class="text-center">Shift Pagi</td>
                                        <td class="text-left">17 September 2022 19:00</td>
                                        <td class="text-center">10 h</td>
                                        <td class="text-center">1 h</td>
                                        <td class="text-left"><b>Rp. 1.000</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">17 September 2022 09:00</td>
                                        <td class="text-center">Shift Pagi</td>
                                        <td class="text-left">17 September 2022 19:00</td>
                                        <td class="text-center">10 h</td>
                                        <td class="text-center">1 h</td>
                                        <td class="text-left"><b>Rp. 1.000</b></td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-end">Total Lembur :</th>
                                        <th class="text-center">2 h</th>
                                        <th class="text-left">Rp. 2.000</th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" class="text-left">
                                            <h5>Damasius Wikaryana Utama</h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="text-center">17 September 2022 09:00</td>
                                        <td class="text-center">Shift Pagi</td>
                                        <td class="text-left">17 September 2022 19:00</td>
                                        <td class="text-center">10 h</td>
                                        <td class="text-center">1 h</td>
                                        <td class="text-left"><b>Rp. 1.000</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">17 September 2022 09:00</td>
                                        <td class="text-center">Shift Pagi</td>
                                        <td class="text-left">17 September 2022 19:00</td>
                                        <td class="text-center">10 h</td>
                                        <td class="text-center">1 h</td>
                                        <td class="text-left"><b>Rp. 1.000</b></td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-end">Total Lembur :</th>
                                        <th class="text-center">2 h</th>
                                        <th class="text-left">Rp. 2.000</th>
                                    </tr>
                            </tbody>
                        </table>
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
        function format ( data ) {
            return '<table class="table">'+data+'</table>';
        }
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [10, 30, 45, 100],
                columnDefs: [
                    { searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 1 },
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





