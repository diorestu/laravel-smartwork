<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600&display=swap" rel="stylesheet">
    <style type="text/css">
        @page {
            margin: 20px 0px 20px 25px !important;
            padding: 0px 0px 0px 0px !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
        }

        h2 {
            font-family: 'Inter', sans-serif;

            font-size: 18px;
        }

        h3 {
            font-family: 'Inter', sans-serif;
            font-size: 16px;

        }

        h4 {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            margin: 1px;
        }

        h5 {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 13px;
            margin: 0px;
        }

        h6 {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            margin: 0px;
        }

        p {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            padding: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
        }
        b {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            padding: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        table,
        tr,
        td {
            vertical-align: middle;
            margin-bottom: 4px;
        }

        .table {
            width: 100%;
            color: #000;
            background-color: transparent;
            border-collapse: collapse;
            border: 0px;
        }

        .table th,
        .table td {
            padding: 0px;
            vertical-align: center;
        }


        .table-sm th,
        .table-sm td {
            padding: 0.1rem;
        }

        .table-bordered {
            border: 1px solid #000;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody+tbody {
            border: 0;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        .list-inline {
            padding-left: 0;
            list-style: none;
            margin-left: 15px;
            margin-top: 25px;

        }

        .list-inline>li {
            display: inline-block;
            padding-right: 15px;
            padding-left: 15px;
        }

        .center {
            text-align: center;
        }

        td.right {
            text-align: right;
            padding-right: 25px;
        }

        .left {
            text-align: left;
        }

        tr.spaceUnder>td {
            padding-bottom: 3em;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    {{-- @php
        $count = $data ?? ''->count();
        $no = 1;
    @endphp
    @forelse ($data ?? '' as $item ?? '') --}}
    <table class="table">
        <tbody>
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
            </colgroup>
            <tr>
                <td colspan="3">
                    <img alt="Logo" src="{{ asset('images/logo-asta.png') }}" width="25%" />
                </td>
                <td colspan="7" class="right">
                    <h4><b>SLIP GAJI</b></h4>
                    <small>PT. ASTA NADI KARYA UTAMA</small>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table class="table" style="padding: 0 10px 0 10px !important;">
        <tbody>
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
            </colgroup>
            <tr>
                <td colspan="2">
                    Gaji Pokok
                </td>
                <td colspan="1">:</td>
                <td colspan="7" class="right">
                    2,400,400
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Tunjangan
                </td>
                <td colspan="1">:</td>
                <td colspan="7" class="right">
                    2,400,400
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Bruto
                </td>
                <td colspan="1">:</td>
                <td colspan="7" class="right">
                    <b>2,400,400</b>
                </td>
            </tr>
        </tbody>
    </table>
    {{-- <table class="table">
        <tbody>
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
            </colgroup>

            <tr>
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>Nama</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="6" style="padding-left: 15px">
                    <h5>{{ $item ?? ''->nama }}</h5>
                </td>
            </tr>
            <tr class="spaceUnder">
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>Jabatan</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="6" style="padding-left: 15px">
                    <h5>{{ $item ?? ''->jabatan }}</h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>GAJI POKOK</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>Rp.</h5>
                </td>
                <td colspan="5" class="right">
                    <h5>{{ number_format($item ?? ''->pokok) }}</h5>
                </td>
            </tr>
            <tr class="spaceUnder">
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>TUNJANGAN</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>Rp.</h5>
                </td>
                <td colspan="5" class="right">
                    <h5>{{ number_format($item ?? ''->tunjangan) }}</h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>POT. BPJS TK</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>Rp.</h5>
                </td>
                <td colspan="5" class="right">
                    <h5>{{ number_format($item ?? ''->bpjstk) }}</h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>POT. BPJS</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>Rp.</h5>
                </td>
                <td colspan="5" class="right">
                    <h5>{{ number_format($item ?? ''->bpjs) }}</h5>
                </td>
            </tr>
            <tr class="spaceUnder">
                <td colspan="3" class="left" style="padding-left: 25px;">
                    <h5>KOPERASI</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center">
                    <h5>Rp.</h5>
                </td>
                <td colspan="5" class="right">
                    <h5>{{ number_format($item ?? ''->koperasi) }}</h5>
                </td>
            </tr>
            <tr class="">
                <td colspan="3" class="left" style="padding-left: 25px; vertical-align: bottom;">
                    <h5><b>TOTAL POTONGAN</b></h5>
                </td>
                <td colspan="1" class="center" style="vertical-align: middle;">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center" style="vertical-align: bottom;">
                    <h5><b>Rp.</b></h5>
                </td>
                <td colspan="5" class="right" style="vertical-align: bottom;">
                    <h4>{{ number_format($item ?? ''->sum_potongan) }}</h4>
                </td>
            </tr>
            <tr class="spaceUnder">
                <td colspan="3" class="left" style="padding-left: 25px; vertical-align: bottom;">
                    <h5><b>TOTAL GAJI DITERIMA</b></h5>
                </td>
                <td colspan="1" class="center" style="vertical-align: middle;">
                    <h5>:</h5>
                </td>
                <td colspan="1" class="center" style="vertical-align: bottom;">
                    <h5><b>Rp.</b></h5>
                </td>
                <td colspan="5" class="right" style="vertical-align: bottom;">
                    <h4>{{ number_format($item ?? ''->netto) }}</h4>
                </td>
            </tr>
            <tr>
                <td class="right" colspan='10'>
                    <img class="img-thumbnail" src="{{ asset('images/ttd.png') }}" width="220px" alt="">
                </td>
            </tr>

        </tbody>
    </table>
        @if ($no++ < $count)
            <div class='page-break'></div>
        @endif
    @empty
    <h4 class="center">Tidak Ada Data</h4>
    @endforelse --}}
</body>
</html>
