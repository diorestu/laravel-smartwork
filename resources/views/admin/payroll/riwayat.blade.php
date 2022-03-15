@extends('layouts.main')

@section('title')
    Riwayat Payroll
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .main-content { overflow: visible !important; }
        .topnav { margin-top: 0px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Payroll</a></li>
                        <li class="breadcrumb-item active">Riwayat Payroll</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Riwayat Payroll</h4>
                    <p class="text-muted mt-1 text-opacity-50">Lihat riwayat payroll gaji pegawai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="{{ route("payroll.cari") }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                    <select required id="tahun" class="form-select" name="tahun">
                                        @for ($t=2021;$t<=2030;$t++)
                                        <option @if($t == $tahun) selected @endif value='{{ $t }}'>{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                    <select required id="bulan" class="form-select" name="bulan">
                                        @for ($b=1;$b<=12;$b++)
                                        <option @if($b == $bulan) selected @endif value='{{ $b }}'>{{ $b.": ".Bulan($b) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex align-items-end">
                                <button class="btn btn-primary w-100 mt-1 font-weight-boldest btn-md" type="submit">
                                    <i class="fas fa-info-circle icon-md"></i> Lihat Data
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12" id="content">
            <div class="card shadow rounded-sm">
                <div class="card-body px-4 py-4">
                    <div class="table-responsive">
                        <table class="table rounded" id="myTable">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-left">Kode Payroll</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Detail</th>
                                    <th class="text-center" width="5%">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i)
                                    @php
                                        $tot = 0;
                                        $q_tot = App\Models\Payroll::where('id_payroll', $i->id)->get();
                                        foreach ($q_tot as $r_tot) {
                                            $tot += $r_tot->netto;
                                        }
                                    @endphp
                                    <tr data-child-value="
                                        <tr>
                                            <td>Lokasi Kerja</td>
                                            <td>:</td>
                                            <td width='70%'>{{ $i->pay_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Periode</td>
                                            <td>:</td>
                                            <td width='70%'>{{ $i->pay_bulan." ".$i->pay_tahun }}</td>
                                        </tr>
                                        <tr>
                                            <td>Remark</td>
                                            <td>:</td>
                                            <td width='70%'>{{ $i->pay_desc }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Total</td>
                                            <td>:</td>
                                            <td width='70%'>{{ rupiah($tot) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status Payroll</td>
                                            <td>:</td>
                                            @if ($i->lembur_status == 'BERHASIL')
                                            <td width='70%'><span class='badge rounded-pill badge-soft-success text-success'>{{ $i->payroll_status }}</span> Pada {{ tanggalIndoWaktu($i->payroll_terima_date) }}</td>
                                            @else
                                            <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->payroll_status }}</span></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Dibuat Pada</td>
                                            <td>:</td>
                                            <td width='70%'>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>
                                        </tr>
                                        ">
                                        <td>{{ $i->pay_code }}</td>
                                        <td class="text-center">{{ rupiah($tot) }}</td>
                                        <td class="text-center">
                                            @if ($i->lembur_status == 'BERHASIL')
                                            <span class='badge rounded-pill badge-soft-success text-success'>{{ $i->payroll_status }}</span> Pada {{ tanggalIndoWaktu($i->payroll_terima_date) }}
                                            @else
                                            <span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->payroll_status }}</span>
                                            @endif
                                        </td>
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
                                                    <li><a class="dropdown-item" href='{{ route('payroll.edit', $i->id) }}'>
                                                            <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit
                                                        </a></li>
                                                    <li><a href="{{ route("payroll.show", $i->id) }}" class="dropdown-item"><i class="fa fa-eye me-2"></i>Detail</a></li>
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
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        const elementTahun = document.querySelector('#bulan');
        const choices2 = new Choices(elementTahun);
        const elementBulan = document.querySelector('#tahun');
        const choices3 = new Choices(elementBulan);
        function format ( data ) {
            return '<table class="table">'+data+'</table>';
        }
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [10, 30, 45, 100],
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





