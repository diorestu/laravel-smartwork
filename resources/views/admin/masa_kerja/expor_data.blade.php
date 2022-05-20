<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Admin</th>
        <th>Masa Kerja</th>
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
            <td>{{ $items->masa_kerja }}</td>
            <td>{{ $items->masa_kerja_tunjangan }}</td>
            <td>{{ $items->created_at }}</td>
            <td>{{ $items->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
