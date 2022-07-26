<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Slip Gaji</title>
    <link rel="shortcut icon" href="{{ asset('backend-assets/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600&display=swap" rel="stylesheet"> --}}
    <style>
        body { font-family: 'Inter', sans-serif; font-size: 10px; }
        h2 { font-family: 'Inter', sans-serif; font-size: 18px; }
        h3 { font-family: 'Inter', sans-serif; font-size: 16px; }
        h4 { font-family: 'Inter', sans-serif; font-size: 14px; margin: 1px; }
        h5 { font-family: 'Inter', sans-serif; font-weight: 400; font-size: 13px; margin: 0px; }
        h6 { font-family: 'Inter', sans-serif; font-size: 12px; margin: 0px; }
        p { font-family: 'Inter', sans-serif; font-size: 10px; padding: 0px; margin-top: 0px; margin-bottom: 0px; }
        table, tr, td { vertical-align: bottom; }
        .table { width: 100%; color: #000; background-color: transparent; border-collapse: collapse; border: 0px; }
        .table th, .table td { padding: 2px; vertical-align: center; }
        .table-sm th, .table-sm td { padding: 0.1rem; }
        .table-bordered { border: 1px solid #9c9c9c; }
        .table-bordered th, .table-bordered td { border: 1px solid #9c9c9c; }
        .table-borderless th, .table-borderless td, .table-borderless thead th, .table-borderless tbody+tbody { border: 0; }
        .center { margin-left: auto; margin-right: auto }
        .list-inline { padding-left: 0; list-style: none; margin-left: 15px; margin-top: 25px }
        .list-inline>li { display: inline-block; padding-right: 15px; padding-left: 15px }
        .center { text-align: center; }
        td.right { text-align: right; padding-right: 25px }
        .left { text-align: left; }
        tr.spaceUnder>td { padding-bottom: 3em }
        .page-break { page-break-after: always }
        .sliptt { margin: 0px 0px 3px 0px; font-size: 25px; font-weight: 700; }
        .slipperiode { margin: 3px 0px 20px 0px; font-size: 18px; font-weight: 700; }
        .trsliptt { background-color: #de4747; color: #fff; border-color: #ad1f1f; }
        .powered { margin-left: 120px; font-style:italic; color:#ccc;}
        .col-md-6 { width: 50%; float: left; }
        .break { clear:both; }
        .text-uppercase { text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-md-6">
            <h1 class="sliptt">Slip Gaji Pegawai</h1>
            <h3 class="slipperiode">Periode {{ BulanTahun($tahun."-".$bulan) }}</h3>
        </div>
        <div class="col-md-6">
            <span class="powered">Powered By</span>
            <img src="{{ $logo }}" width="100" alt="logo smartwork"/>
        </div>
        <div class="break"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-borderless" style="font-size: 12px; margin-bottom:10px;">
                <tbody><tr>
                    <th class="left">Nama</th>
                    <td>{{ $data->user->nama }}</td>
                    <th class="left">Jabatan</th>
                    <td>{{ $data->user->jabatan->jabatan_title }}</td>
                </tr>
                <tr>
                    <th class="left">ID Karyawan</th>
                    <td>{{ $data->user->nip }}</td>
                    <th class="left">Tanggal Bergabung</th>
                    <td>{{ tanggalIndo($data->user->tanggal_mulaiKerja) }}</td>
                </tr>
                <tr>
                    <th class="left">Lokasi Kerja</th>
                    <td>{{ $data->user->cabang->cabang_nama }}</td>
                    <th class="left">Lama Kerja</th>
                    <td>{{ masaKerja($data->user->tanggal_mulaiKerja) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-hover" style="font-size: 11px;">
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
            <table class="table table-bordered table-hover" style="font-size: 11px;">
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
        <div class="break"></div>
        <div class="col-md-12" style="margin-top:10px;">
            <table class="table table-bordered table-hover" style="font-size: 11px; margin-bottom:10px;">
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
                        <td><i class="text-uppercase" style="font-size: 10px;">{{ terbilang($data->pay_pokok + $data->total_tj - $data->total_pot) }} rupiah</i></td>
                    </tr>
                </tbody>
            </table>
            <p>*) Keterangan: Pajak PPh 21 ditanggung perusahaan.</p>
            <p class="text-right"><i>Dicetak dengan <b>Smartwork App - Solusi Digital HR Perusahaan</b>
            <br>Slip gaji ini tidak membutuhkan tanda tangan, untuk konfirmasi silahkan hubungi 0361-1122245</i></p>
        </div>
    </div>
</body>
</html>
