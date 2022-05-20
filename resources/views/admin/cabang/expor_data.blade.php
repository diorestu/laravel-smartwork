<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Admin</th>
        <th>Nama Cabang</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Status</th>
        <th>Lat</th>
        <th>Long</th>
        <th>Cabang UMK</th>
        <th>Lembur Dasar</th>
        <th>Lembur H1</th>
        <th>Lembur H2</th>
        <th>Lembur H9</th>
        <th>Lembur H10</th>
        <th>Dibuat</th>
        <th>Diupdate</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $items)
        <tr>
            <td>{{ $items->id }}</td>
            <td>{{ $items->id_admin }}</td>
            <td>{{ $items->cabang_nama }}</td>
            <td>{{ $items->cabang_email }}</td>
            <td>{{ $items->cabang_phone }}</td>
            <td>{{ $items->cabang_alamat }}</td>
            <td>{{ $items->cabang_status }}</td>
            <td>{{ $items->cabang_lat }}</td>
            <td>{{ $items->cabang_long }}</td>
            <td>{{ $items->cabang_umk }}</td>
            <td>{{ $items->lembur_dasar }}</td>
            <td>{{ $items->lembur_h1 }}</td>
            <td>{{ $items->lembur_h2 }}</td>
            <td>{{ $items->lembur_h9 }}</td>
            <td>{{ $items->lembur_h10 }}</td>
            <td>{{ $items->created_at }}</td>
            <td>{{ $items->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
