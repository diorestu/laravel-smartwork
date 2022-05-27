<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Admin</th>
        <th>Judul Pengumuman</th>
        <th>Deskripsi</th>
        <th>Divisi</th>
        <th>Dibuat</th>
        <th>Terakhir Update</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $items)
        <tr>
            <td>{{ $items->id }}</td>
            <td>{{ $items->id_admin }}</td>
            <td>{{ $items->judul_pengumuman }}</td>
            <td>{{ $items->desc_pengumuman }}</td>
            <td>@if ($items->id_divisi != 0) {{ $items->divisi->div_title }} @else {{ "Semua divisi" }} @endif</td>
            <td>{{ $items->created_at }}</td>
            <td>{{ $items->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
