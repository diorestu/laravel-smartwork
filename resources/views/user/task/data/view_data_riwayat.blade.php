<table class="table rounded px-0" id="myTable">
    <thead class="bg-dark">
        <tr class="d-none">
            <th class="text-white">TANGGAL</th>
            <th class="text-white">AKTIVITAS</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
            <tr data-child-value="
                <tr class='no-border'>
                    <td class='px-0 py-1'>Judul</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> {{ $item->judul_aktivitas }}</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Keterangan</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> {{ $item->aktivitas }}</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Waktu Aktivitas</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> {{ $item->jam_aktivitas }}</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Diinput pada</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> {{ tanggalIndoWaktuLengkap($item->created_at) }}</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Aksi</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> <a href='{{ route('aktivitas.show', $item->id) }}'>Detail</a></td>
                </tr>
                ">
                <td class="fw-bold text-uppercase">{{ TanggalBulan($item->created_at) }}</td>
                <td class="fw-regular">{{ $item->judul_aktivitas }}</td>
                <td class="dt-control text-end">
                    <a class="btn-dark btn-sm btn-circle" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                </td>
            </tr>
        @empty
            <tr class="no-border">
                <td class="text-center font-size-16" colspan="3">Tidak ada riwayat aktivitas <br> <small class="text-muted">Semua aktivitas Anda akan tampil disini</small></td>
            </tr>
        @endforelse
    </tbody>
</table>
