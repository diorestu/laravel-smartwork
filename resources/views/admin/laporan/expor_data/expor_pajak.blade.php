<table>
    <thead>
    <tr><th>Laporan Pembayaran Pajak PPh-21 Pegawai Periode {{ BulanTahun($tahun.'-'.$bulan.'-01') }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Pegawai</th>
        <th>Penghasilan Bersih</th>
        <th>PKP</th>
        <th>PPh Pasal 21</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    @php
        $netto          = $d['netto'];
        if ($netto >= 4500000) {
            $netto_setahun  = 12*$netto;
            $pkp            = floor($netto_setahun-54000000);
            $pph_terutang   = (5/100*$pkp);
            $pph21          = $pph_terutang/12;
        }
        else {
            $pkp            = 0;
            $pph21          = 0;
        }
    @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->user->nama }}</td>
            <td>{{ $netto }}</td>
            <td>{{ $pkp == 0 ? 0 : $pkp }}</td>
            <td>{{ $pph21 == 0 ? 0 : $pph21 }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>JUMLAH TOTAL :</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th>Diekspor melalui Smartwork App pada : {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, LL HH:mm'); }}</th>
        </tr>
    </tfoot>
</table>
