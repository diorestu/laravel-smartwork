<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Admin</th>
        <th>Nama Jabatan</th>
        <th>Tunjangan</th>
        <th>Dibuat</th>
        <th>Terakhir Update</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $items)
        <tr>
            <td>{{ $items->jabatan_id }}</td>
            <td>{{ $items->id_admin }}</td>
            <td>{{ $items->jabatan_title }}</td>
            <td>{{ $items->jabatan_tunjangan }}</td>
            <td>{{ $items->created_at }}</td>
            <td>{{ $items->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
