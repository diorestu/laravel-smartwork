<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Admin</th>
        <th>NIP</th>
        <th>Nama Pegawai</th>
        <th>Gender</th>
        <th>Alamat</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Lokasi Kerja</th>
        <th>Divisi</th>
        <th>Jabatan</th>
        <th>Sertifikasi</th>
        <th>Username</th>
        <th>Status</th>
        <th>Tanggungan</th>
        <th>Mulai Kerja</th>
        <th>Masa Kerja</th>
        <th>Roles</th>
        <th>No. Rekening</th>
        <th>NPWP</th>
        <th>Company</th>
        <th>Foto</th>
        <th>Terakhir Login</th>
        <th>IP</th>
        <th>Dibuat</th>
        <th>Terakhir Update</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $items)
        <tr>
            <td>{{ $items->id }}</td>
            <td>{{ $items->id_admin }}</td>
            <td>{{ $items->nip }}</td>
            <td>{{ $items->nama }}</td>
            <td>{{ $items->gender }}</td>
            <td>{{ $items->alamat }}</td>
            <td>{{ $items->email }}</td>
            <td>{{ $items->phone }}</td>
            <td>{{ $items->id_cabang == '' ? '-' : $items->cabang->cabang_nama }}</td>
            <td>{{ $items->id_divisi == '' ? '-' : $items->divisi->div_title }}</td>
            <td>{{ $items->id_jabatan == '' ? '-' : $items->jabatan->jabatan_title }}</td>
            <td>{{ $items->id_sertifikasi == '' ? '-' : $items->sertifikasi->sertifikasi_title }}</td>
            <td>{{ $items->username }}</td>
            <td>{{ $items->status }}</td>
            <td>{{ $items->tanggungan == '' ? '-' : $items->status_kawin->status_kawin }}</td>
            <td>{{ $items->tanggal_mulaiKerja }}</td>
            <td>{{ $items->id_masaKerja == '' ? '-' : $items->masa_kerja->masa_kerja }}</td>
            <td>{{ $items->roles }}</td>
            <td>{{ $items->no_rek }}</td>
            <td>{{ $items->npwp }}</td>
            <td>{{ $items->company }}</td>
            <td>{{ $items->company_logo }}</td>
            <td>{{ $items->namuser_last_login_at }}</td>
            <td>{{ $items->user_last_login_ip }}</td>
            <td>{{ $items->created_at }}</td>
            <td>{{ $items->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
