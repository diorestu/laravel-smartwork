<table class="table mb-0">
    <thead class="table-dark">
        <tr>
            <th>Tanggal</th>
            <th>Shift</th>
            <th class="text-center">Jam Kerja</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwal as $item)
            <tr>
                <td class="fw-bold text-uppercase" scope="row">{{ tanggalIndo3($item->tanggal_shift) }}</td>
                <td class="font-size-11"><b>{{ $item->shift->nama_shift }}</b> : {{ $item->shift->ket_shift }}</td>
                <td class="font-size-11 text-center">{{ tampilJamMenit($item->shift->hadir_shift) }} - {{ tampilJamMenit($item->shift->pulang_shift) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
