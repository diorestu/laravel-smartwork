@extends('layouts.print')

@section('content')
<table class="table table-borderless">
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
                <img alt="Logo" src="{{ asset('images/logo-asta.png') }}" width="20%" />
            </td>
            <td colspan="7" class="text-right">
                <h6 class='font-weight-boldest'>SLIP GAJI</h6>
                <span><small>PT. ASTA NADI KARYA UTAMA</small></span>
                <p><small>Denpasar</small></p>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <tbody>
        <colgroup>
            <col width="10%">
            <col width="10%">
            <col width="15%">
            <col width="5%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
        </colgroup>
        <tr>
            <td colspan="3">Gaji Pokok</td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <span>2,494,000</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">Tunjangan</td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <span>2,494,000</span>
            </td>
        </tr>
        <tr>
            <td colspan="3"><b>Bruto</b></td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <b>2,494,000</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">BPJS</td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <span>2,494,000</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">BPJS</td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <span>2,494,000</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">Potongan</td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <span>2,494,000</span>
            </td>
        </tr>
        <tr>
            <td colspan="3"><b>Netto</b></td>
            <td colspan="1"></td>
            <td colspan="6" class="text-right">
                <b>2,494,000</b>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-borderless">
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
            <td class="text-right" colspan='10'>
                <img src="{{ asset('images/ttd-slip.png') }}" width="50%" alt="">
            </td>
        </tr>
    </tbody>
</table>


@endsection
