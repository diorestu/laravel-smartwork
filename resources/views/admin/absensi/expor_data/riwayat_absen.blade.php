<table>
    <thead>
    <tr><th>REKAP ABSENSI PEGAWAI TANGGAL {{ tanggalIndo3($date) }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Nama Pegawai</th>
        <th rowspan="2">Lokasi Kerja</th>
        <th rowspan="2">Shift</th>
        <th colspan="5">IN</th>
        <th colspan="5">OUT</th>
        <th rowspan="2">Late</th>
    </tr>
    <tr>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Keterangan</th>
        <th>Koor. Lat</th>
        <th>Koor. Long</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Keterangan</th>
        <th>Koor. Lat</th>
        <th>Koor. Long</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $i)
        <tr bgcolor="green">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $i->user->nama }}</td>
            <td>{{ $i->cabang_nama }}</td>
            <td>{{ $i->ket_shift." ".TampilJamMenit($i->hadir_shift)." - ".TampilJamMenit($i->pulang_shift) }}</td>
            <td>{{ Carbon\Carbon::parse($i->jam_hadir)->format('d/m/Y'); }}</td>
            <td>{{ TampilJamMenit($i->jam_hadir) }}</td>
            <td>{{ $i->ket_hadir }}</td>
            <td>{{ $i->lat_hadir }}</td>
            <td>{{ $i->long_hadir }}</td>
            <td>@if ($i->jam_pulang == "") {{ "-" }} @else {{ Carbon\Carbon::parse($i->jam_pulang)->format('d/m/Y'); }} @endif</td>
            <td>@if ($i->jam_pulang == "") {{ "-" }} @else {{ TampilJamMenit($i->jam_pulang) }} @endif</td>
            <td>{{ $i->ket_pulang }}</td>
            <td>{{ $i->lat_pulang }}</td>
            <td>{{ $i->long_pulang }}</td>
            <td>
                {{ telat(TampilTanggal($i->jam_hadir)." ".$i->hadir_shift, $i->jam_hadir, $i->nama_shift) }}
            </td>
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
