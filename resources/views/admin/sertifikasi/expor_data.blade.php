<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Admin</th>
        <th>Nama Sertifikasi</th>
        <th>Tunjangan</th>
        <th>Dibuat</th>
        <th>Terakhir Update</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $items)
        <tr>
            <td>{{ $items->id }}</td>
            <td>{{ $items->id_admin }}</td>
            <td>{{ $items->sertifikasi_title }}</td>
            <td>{{ $items->sertifikasi_tunjangan }}</td>
            <td>{{ $items->created_at }}</td>
            <td>{{ $items->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
