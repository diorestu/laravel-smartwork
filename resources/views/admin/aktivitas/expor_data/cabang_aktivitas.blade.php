<table>
    <thead>
    <tr><th>Rekap Aktivitas Pegawai {{ namaCabang($cabang) }} Periode {{ Carbon\Carbon::parse($awal)->format('d/m/Y')." sd ".Carbon\Carbon::parse($akhir)->format('d/m/Y') }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Nama Pegawai</th>
        <th>Lokasi Kerja</th>
        <th>Judul Aktivitas</th>
        <th>Keterangan</th>
        <th>Waktu Aktivitas</th>
        <th>Diinput pada</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $i)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $i->user->nama }}</td>
        <td>{{ $i->user->cabang->cabang_nama }}</td>
        <td>{{ $i->judul_aktivitas }}</td>
        <td>{{ $i->aktivitas }}</td>
        <td>{{ $i->jam_aktivitas }}</td>
        <td>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr><th></th></tr>
        <tr>
            <th></th>
            <th>Diekspor melalui Smartwork App pada : {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, LL HH:mm'); }}</th>
        </tr>
    </tfoot>
</table>
