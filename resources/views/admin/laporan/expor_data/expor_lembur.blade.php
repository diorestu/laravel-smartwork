<table>
    <thead>
    <tr><th>Laporan Lembur Pegawai {{ $user }} Periode {{ tanggalIndo3($tawal)." s/d ".tanggalIndo3($takhir) }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Pegawai</th>
        <th>Tipe</th>
        <th>Lembur Awal</th>
        <th>Lembur Akhir</th>
        <th>Keterangan</th>
        <th>Jam Kerja</th>
        <th>Jam Lembur</th>
        <th>Tanggal Diajukan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data_absen as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->user->nama }}</td>
            <td>ABSENSI</td>
            <td>{{ Carbon\Carbon::parse($a->jam_hadir)->format('d/m/Y H:i'); }}</td>
            <td>{{ Carbon\Carbon::parse($a->jam_pulang)->format('d/m/Y H:i'); }}</td>
            <td>{{ $a->ket_pulang }}</td>
            <td>{{ $a->jam_kerja }}</td>
            <td>{{ $a->jam_lembur }}</td>
            <td>{{ Carbon\Carbon::parse($a->jam_pulang)->format('d/m/Y H:i'); }}</td>
        </tr>
    @endforeach
    @foreach($data_lembur as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->user->nama }}</td>
            <td>PENGAJUAN</td>
            <td>{{ Carbon\Carbon::parse($d->lembur_awal)->format('d/m/Y H:i'); }}</td>
            <td>{{ Carbon\Carbon::parse($d->lembur_akhir)->format('d/m/Y H:i'); }}</td>
            <td>{{ $d->lembur_keterangan }}</td>
            <td>{{ $d->jam_kerja }}</td>
            <td>{{ $d->jam_lembur }}</td>
            <td>{{ Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i'); }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>TOTAL LEMBUR</th>
        </tr>
        <tr>
            <th></th>
            <th>Diekspor melalui Smartwork App pada : {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, LL HH:mm'); }}</th>
        </tr>
    </tfoot>
</table>
