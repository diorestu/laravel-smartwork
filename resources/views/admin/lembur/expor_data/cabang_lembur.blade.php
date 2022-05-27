<table>
    <thead>
    <tr><th>Rekap Lembur Pegawai Cabang {{ namaCabang($cabang) }} Periode {{ Carbon\Carbon::parse($awal)->format('d/m/Y')." sd ".Carbon\Carbon::parse($akhir)->format('d/m/Y') }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Lokasi Kerja</th>
        <th>Tanggal Lembur</th>
        <th>Waktu Lembur</th>
        <th>Judul Lembur</th>
        <th>Keterangan</th>
        <th>Jam Kerja</th>
        <th>Jam Lembur</th>
        <th>Status</th>
        <th>Diajukan pada</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $i)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $i->user->nama }}</td>
        <td>{{ $i->user->cabang->cabang_nama }}</td>
        <td>{{ tanggalIndo3($i->lembur_awal) }}</td>
        <td>{{ tanggalIndoWaktu($i->lembur_awal) }} - {{ tanggalIndoWaktu($i->lembur_akhir) }}</td>
        <td>{{ $i->lembur_judul }}</td>
        <td>{{ $i->lembur_keterangan }}</td>
        <td>{{ $i->jam_kerja }}</td>
        <td>{{ $i->jam_lembur }}</td>
        <td>{{ $i->lembur_status }}</td>
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
