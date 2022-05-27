<table>
    <thead>
    <tr><th>Laporan Cuti Pegawai {{ $user }} Periode {{ tanggalIndo3($tawal)." s/d ".tanggalIndo3($takhir) }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Pegawai</th>
        <th>Jenis Cuti</th>
        <th>Cuti Awal</th>
        <th>Cuti Akhir</th>
        <th>Keterangan</th>
        <th>Hari Cuti</th>
        <th>Sisa Cuti</th>
        <th>Tanggal Diajukan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->user->nama }}</td>
            <td>{{ $d->cutiJenis->cuti_nama_jenis }}</td>
            <td>{{ Carbon\Carbon::parse($d->cuti_awal)->format('d/m/Y'); }}</td>
            <td>{{ Carbon\Carbon::parse($d->cuti_akhir)->format('d/m/Y'); }}</td>
            <td>{{ $d->cuti_deskripsi }}</td>
            <td>{{ $d->cuti_total }}</td>
            <td>{{ $sisaCuti-$d->cuti_total }}</td>
            <td>{{ Carbon\Carbon::parse($d->created_at)->format('d/m/Y'); }}</td>
        </tr>
        {{ $sisaCuti = $sisaCuti-$d->cuti_total }}
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>TOTAL CUTI</th>
        </tr>
        <tr>
            <th></th>
            <th>Diekspor melalui Smartwork App pada : {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, LL HH:mm'); }}</th>
        </tr>
    </tfoot>
</table>
