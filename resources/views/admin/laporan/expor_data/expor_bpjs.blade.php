@if ($tipe == "Kesehatan")
<table>
    <thead>
    <tr><th>LAPORAN IURAN PEMBAYARAN BPJS KESEHATAN PEGAWAI PERIODE MARET 2022</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Pegawai</th>
        <th>Gaji Pokok</th>
        <th>Pot. Pegawai</th>
        <th>Pot. Perusahaan</th>
        <th>Jum. Potongan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->user->nama }}</td>
            <td>{{ $d->pay_pokok }}</td>
            <td>{{ $d->bpjs_kes_u }}</td>
            <td>{{ $d->bpjs_kes_p }}</td>
            <td>{{ ($d->bpjs_kes_u+$d->bpjs_kes_p) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Jumlah Total</th>
            <th>{{ $d->sum('pay_pokok') }}</th>
            <th>{{ $d->sum('bpjs_kes_u') }}</th>
            <th>{{ $d->sum('bpjs_kes_p') }}</th>
            <th>{{ ($d->sum('bpjs_kes_u')+$d->sum('bpjs_kes_p')) }}</th>
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
@else
<table>
    <thead>
    <tr>
        <th>LAPORAN IURAN PEMBAYARAN BPJS KETENAGAKERJAAN PEGAWAI PERIODE MARET 2022</th>
    </tr>
    <tr>
        <th>No.</th>
        <th>Pegawai</th>
        <th>Gaji Pokok</th>
        <th>Pot. Pegawai</th>
        <th>Pot. Perusahaan</th>
        <th>Jum. Potongan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->user->nama }}</td>
            <td>{{ $d->pay_pokok }}</td>
            <td>{{ $d->bpjs_kes_u }}</td>
            <td>{{ $d->bpjs_kes_p }}</td>
            <td>{{ ($d->bpjs_kes_u+$d->bpjs_kes_p) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Jumlah Total</th>
            <th>{{ $d->sum('pay_pokok') }}</th>
            <th>{{ $d->sum('bpjs_kes_u') }}</th>
            <th>{{ $d->sum('bpjs_kes_p') }}</th>
            <th>{{ ($d->sum('bpjs_kes_u')+$d->sum('bpjs_kes_p')) }}</th>
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
@endif
