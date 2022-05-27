<table>
    <thead>
    <tr><th>Rekap Cuti Pegawai Pegawai {{ namaUser($user) }}</th></tr>
    <tr><th></th></tr>
    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Lokasi Kerja</th>
        <th>Tanggal Cuti</th>
        <th>Keterangan</th>
        <th>Jenis Cuti</th>
        <th>Total Hari</th>
        <th>Status</th>
        <th>Diajukan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $i)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $i->user->nama }}</td>
        <td>{{ $i->user->cabang->cabang_nama }}</td>
        <td>{{ tanggalIndo3($i->cuti_awal) }} - {{ tanggalIndo3($i->cuti_akhir) }}</td>
        <td>{{ $i->cuti_deskripsi }}</td>
        <td>{{ $i->cutiJenis->cuti_nama_jenis }}</td>
        <td>{{ $i->cuti_total }}</td>
        <td>{{ $i->cuti_status }}</td>
        <td>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>>
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
