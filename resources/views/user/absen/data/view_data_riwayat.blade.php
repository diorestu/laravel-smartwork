<table class="table rounded px-0" id="myTable">
    <thead class="bg-dark">
        <tr class="d-none">
            <th class="text-white">TANGGAL</th>
            <th class="text-white">IN</th>
            <th class="text-white">OUT</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $item)
            <tr data-child-value="
                <tr class='no-border'>
                    <td class='px-0 py-1'>Clock In</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> {{ tanggalIndoWaktuLengkap($item->jam_hadir) }}</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Clock Out</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'> {{ $item->jam_pulang ? tanggalIndoWaktuLengkap($item->jam_pulang) : 'Belum Absen' }}</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Shift</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'>@if ($item->usershift_id != 0) {{ $item->user_shift->shift->ket_shift }} @else {{ "-" }} @endif</td>
                </tr>
                <tr class='no-border'>
                    <td class='px-0 py-1'>Aksi</td>
                    <td class='px-0 py-1'>:</td>
                    <td class='px-2 py-1'><a href='{{ route('absen.show', $item->id) }}'>Detail</a></td>
                </tr>
                ">
                <td class="fw-bold text-uppercase">{{ TanggalBulan($item->jam_hadir) }}</td>
                <td class="font-size-12">{{ TampilJamMenit($item->jam_hadir) }}</td>
                <td class="font-size-12">{{ $item->jam_pulang ? TampilJamMenit($item->jam_pulang) : 'Belum Absen' }}</td>
                <td class="dt-control text-end">
                    <a class="btn btn-outline-danger btn-sm btn-circle" href="javascript:void(0);"><i class="bx bx-caret-down"></i></a>
                </td>
            </tr>
        @empty
            <tr class="no-border">
                <td class="text-center font-size-16" colspan="4">Tidak terdapat data presensi <br> <small class="text-muted">Semua presensi hadir/pulang Anda akan tampil disini</small></td>
            </tr>
        @endforelse
    </tbody>
</table>
<script>
    function format ( data ) {
        return '<table class="table mb-0">'+data+'</table>';
    }
    $(document).ready(function() {
        $('#myTable').DataTable({
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            lengthMenu: [30, 60, 150, 300],
            columnDefs: [
                { searchable: false, targets: 0 },
                { orderable: false, searchable: false, targets: 0 },
                { orderable: false, searchable: false, targets: 0 },
            ],
            order: [[0, 'asc']]
        });
        $('#myTable tbody').on('click', 'td.dt-control', function () {
            var table   = $('#myTable').DataTable();
            var tr      = $(this).closest('tr');
            var row     = table.row( tr );
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(tr.data('child-value'))).show();
                row.child().addClass('damas');
                tr.addClass('shown');
            }
        });
    });
</script>
