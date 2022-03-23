@extends('layouts.main')

@section('title')
    Edit Payroll {{ $dataParent->pay_code }}
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
        .f-12 { font-size: 12px !important; }
        .tj_div { border-bottom: 1px solid #f5f5f5; padding: 3px 0px; }
        .tj_ket, .tj_jum { width: 100px; }
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
                        <li class="breadcrumb-item active">Edit Payroll</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Payroll {{ $dataParent->pay_code }}</h4>
                    <p class="text-muted mt-1 text-opacity-50 mt-2">Periode {{ BulanTahun($dataParent->pay_tahun."-".$dataParent->pay_bulan) }}</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-warning waves-effect waves-light text-black dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download icon-sm text-black"></i>&nbsp; Download CSV <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <li><a class="dropdown-item" href="#">Bank Mandiri</a></li>
                                <li><a class="dropdown-item" href="#">Bank BCA</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <div class="table-responsive">
                        <table class="table rounded" id="myTable">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-left">Nama Pegawai</th>
                                    <th class="text-left">Gaji Pokok</th>
                                    <th class="text-left">Tunjangan</th>
                                    <th class="text-left">Potongan</th>
                                    <th class="text-left">Total</th>
                                    <th class="text-left" width="5%">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i)
                                    <tr class="f-12">
                                        <td>{{ $i->user->nama }}</td>
                                        <td>{{ rupiah($i->pay_pokok) }}</td>
                                        <td>
                                            <a class="text-success" href="#" data-bs-toggle="popover" data-bs-html="true" data-bs-placement="top"
                                            data-bs-original-title="Detail Tunjangan" data-bs-trigger="focus"
                                            data-bs-content="
                                            <div class='tj_div d-flex'><div class='tj_ket'>Jabatan</div>         <div class='tj_jum text-success'>+ {{ rupiah($i->tj_jabatan) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Sertifikasi</div>     <div class='tj_jum text-success'>+ {{ rupiah($i->tj_sertifikasi) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Transport</div>       <div class='tj_jum text-success'>+ {{ rupiah($i->tj_transport) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Kosmetik</div>        <div class='tj_jum text-success'>+ {{ rupiah($i->tj_kosmetik) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Makan</div>           <div class='tj_jum text-success'>+ {{ rupiah($i->tj_makan) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Masa Kerja</div>      <div class='tj_jum text-success'>+ {{ rupiah($i->tj_masaKerja) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Status Kawin</div>    <div class='tj_jum text-success'>+ {{ rupiah($i->tj_statusKawin) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Bonus</div>           <div class='tj_jum text-success'>+ {{ rupiah($i->tj_bonus) }}</div></div>
                                            ">
                                                {{ rupiah($i->total_tj) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="text-danger" href="#" data-bs-toggle="popover" data-bs-html="true" data-bs-placement="top"
                                            data-bs-original-title="Detail Potongan" data-bs-trigger="focus"
                                            data-bs-content="
                                            <div class='tj_div d-flex'><div class='tj_ket'>Absensi</div>    <div class='tj_jum text-danger'>- {{ rupiah($i->pt_absen) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Kasbon</div>     <div class='tj_jum text-danger'>- {{ rupiah($i->pt_kasbon) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>BPJS Kes</div>   <div class='tj_jum text-danger'>- {{ rupiah($i->bpjs_kes_u) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>BPJS TK</div>    <div class='tj_jum text-danger'>- {{ rupiah($i->bpjs_tk_u) }}</div></div>
                                            <div class='tj_div d-flex'><div class='tj_ket'>Lainnya</div>    <div class='tj_jum text-danger'>- {{ rupiah($i->pt_lainnya) }}</div></div>
                                            ">
                                                {{ rupiah($i->total_pot) }}
                                            </a>
                                        </td>
                                        <td><b>{{ rupiah($i->pay_pokok + $i->total_tj - $i->total_pot) }}</b></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                                    <li><a target="_blank" href="{{ route("payroll.slipgaji", ['id' => $i->id_pay]) }}" class="dropdown-item"><i class="fa fa-file me-2"></i>Slip Gaji</a></li>
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
            <h5 class="mb-sm-0 font-size-14 mt-2"><span class="text-danger">*</span> Remark : {{ $dataParent->pay_desc }}</h5>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [10, 30, 45, 100],
                order: [[0, 'asc']]
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





