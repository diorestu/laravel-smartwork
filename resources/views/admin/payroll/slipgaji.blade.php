@extends('layouts.main')

@section('title')
    Slip Gaji Pegawai
@endsection

@push('addon-style')
    <style>
        .main-content { overflow: visible !important; }
        .topnav { margin-top: 0px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .f-12 { font-size: 10px !important; }
        .sliptt { margin: 0px 0px 10px 0px; font-size: 25px; font-weight: 700; }
        .slipperiode { margin: 10px 0px 20px 0px; font-size: 18px; font-weight: 700; }
        .trsliptt { background-color: #de4747; color: #fff; border-color: #ad1f1f; }
        .powered { margin-left: 120px; font-style:italic; color:#ccc;}
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
                        <li class="breadcrumb-item active">Slip Gaji</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Slip Gaji Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50 mt-2"></p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route("payroll.cetak_slipgaji", ['id' => $data->id_pay]) }}" class="btn btn-warning waves-effect waves-light text-black">
                            <i class="fa fa-print icon-sm text-black"></i>
                            Print Slip Gaji&nbsp;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <div class="nav-tabs-custom" style="margin-bottom:0px;">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h1 class="sliptt">Slip Gaji Pegawai</h1>
                                        <h3 class="slipperiode">Periode {{ BulanTahun($tahun."-".$bulan) }}</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="powered">Powered By</span>
                                        <img class="pull-right" style="width:80px;" src="https://smartwork.astapijar.id/upload/logos/logo_asta.jpg">
                                        <img class="pull-right" style="width:150px; margin-top:6px; margin-right: 20px;" src="https://smartwork.astapijar.id/dist/img/logo-smartwork.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table" style="font-size: 13px;">
                                            <tbody><tr>
                                                <th>Nama</th>
                                                <td>{{ $data->user->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>ID Karyawan</th>
                                                <td>{{ $data->user->nip }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi Kerja</th>
                                                <td>{{ $data->user->cabang->cabang_nama }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover" style="font-size: 13px;">
                                            <thead>
                                                <tr class="trsliptt">
                                                    <th>Pendapatan</th>
                                                    <th>Unit</th>
                                                    <th>Rate</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Gaji Pokok</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->pay_pokok) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Jabatan</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_jabatan) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Sertifikasi</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_sertifikasi) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Transportasi</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_transport) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Kosmetik</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_kosmetik) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Makan</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_makan) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Masa Kerja</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_masaKerja) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan Status Kawin</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_statusKawin) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Isentif Pegawai</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ rupiah($data->tj_bonus) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table" style="font-size: 13px;">
                                            <tbody><tr>
                                                <th>Jabatan</th>
                                                <td>{{ $data->user->jabatan->jabatan_title }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Bergabung</th>
                                                <td>{{ tanggalIndo($data->user->tanggal_mulaiKerja) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lama Kerja</th>
                                                <td>{{ masaKerja($data->user->tanggal_mulaiKerja) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover" style="font-size: 13px;">
                                            <thead>
                                                <tr class="trsliptt">
                                                    <th>Potongan</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>BPJS Kesehatan</td>
                                                    <td>{{ rupiah($data->bpjs_kes_u) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>BPJS Ketenagakerjaan</td>
                                                    <td>{{ rupiah($data->bpjs_tk_u) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan Kehadiran</td>
                                                    <td>{{ rupiah($data->pt_absen) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan Kasbon</td>
                                                    <td>{{ rupiah($data->pt_kasbon) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan Lainnya</td>
                                                    <td>{{ rupiah($data->pt_lainnya) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover" style="font-size: 13px;">
                                        <thead>
                                            <tr class="trsliptt">
                                                <th colspan="2">TOTAL GAJI YANG DITERIMA <i>(Take Home Pay)</i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>{{ rupiah($data->pay_pokok + $data->total_tj - $data->total_pot) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Terbilang</td>
                                                <td><i class="text-uppercase">{{ terbilang($data->pay_pokok + $data->total_tj - $data->total_pot) }} rupiah</i></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <p>*) Keterangan: Pajak PPh 21 ditanggung perusahaan.</p>
                                        <p class="text-right"><i>Dicetak dengan <b>Smartwork App - Solusi Digital HR Perusahaan</b>
                                        <br>Slip gaji ini tidak membutuhkan tanda tangan, untuk konfirmasi silahkan hubungi 0361-1122245</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
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





