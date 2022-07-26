<ul class="nav nav-pills nav-justified" role="tablist">
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link active" style="border-radius:0px;" data-bs-toggle="tab" href="#home-1" role="tab" aria-selected="false">
            <span class="d-block d-sm-none">Lembur Harian</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" style="border-radius:0px;" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
            <span class="d-block d-sm-none">Permohonan Lembur</span>
        </a>
    </li>
</ul>
<div class="tab-content px-2 pt-4 pb-0 text-muted">
    <div class="tab-pane active" id="home-1" role="tabpanel">
        <div class="card-body px-0 py-1 table-responsive">
            <table class="table rounded px-0" id="myTable">
                <thead class="bg-dark">
                    <tr class="d-none">
                        <th class="text-white">TANGGAL</th>
                        <th class="text-white">IN</th>
                        <th class="text-white">OUT</th>
                        <th class="text-white">LEMBUR</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data_absen as $item_absen)
                        <tr data-child-value="
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Clock In</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'> {{ tanggalIndoWaktuLengkap($item_absen->jam_hadir) }}</td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Clock Out</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'> {{ $item_absen->jam_pulang ? tanggalIndoWaktuLengkap($item_absen->jam_pulang) : 'Belum Absen' }}</td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Kode Shift</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'>
                                    @if ($item_absen->usershift_id == 0)
                                    {{ '-' }}
                                    @else
                                    {{ $item_absen->user_shift->shift->nama_shift }}
                                    @endif
                                </td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Shift</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'>
                                    @if ($item_absen->usershift_id == 0)
                                    {{ '-' }}
                                    @else
                                    {{ $item_absen->user_shift->shift->ket_shift.' / '.$item_absen->user_shift->shift->hadir_shift.' - '.$item_absen->user_shift->shift->pulang_shift }}
                                    @endif
                                </td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Total Lembur</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'>{{ $item_absen->jam_lembur }} jam</td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Keterangan</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'>{{ $item_absen->ket_pulang }}</td>
                            </tr>
                            ">
                            <td class="fw-bold text-uppercase">{{ TanggalBulan($item_absen->jam_hadir) }}</td>
                            <td class="font-size-12">{{ TampilJamMenit($item_absen->jam_hadir) }}</td>
                            <td class="font-size-12">{{ $item_absen->jam_pulang ? TampilJamMenit($item_absen->jam_pulang) : '-' }}</td>
                            <td class="font-size-12">{{ $item_absen->jam_lembur }} jam</td>
                            <td class="dt-control text-end">
                                <a class="btn btn-outline-danger btn-sm btn-circle" href="javascript:void(0);"><i class="bx bx-caret-down"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr class="no-border">
                            <td class="text-center font-size-16" colspan="4">Tidak terdapat data lembur harian <br> <small class="text-muted">Semua lembur harian Anda akan tampil disini</small></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane" id="profile-1" role="tabpanel">
        <div class="card-body px-0 py-1">
            <ul class="list-group list-group-flush">
                @forelse($data as $item)
                <li class="list-group-item px-2 py-1 mb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="fw-bold font-size-12 mb-1">{{ $item->lembur_judul }}</p>
                        <p class="fw-regular font-size-12 text-muted mb-1">
                            {{ TanggalBulan($item->lembur_awal) }}
                            {{ TampilJamMenit($item->lembur_awal) }} - {{ TampilJamMenit($item->lembur_akhir) }}
                            &nbsp;&nbsp;<span class="badge bg-warning text-black">{{ $item->jam_lembur }} jam</span>
                        </p>
                        @if ($item->lembur_status == "DITOLAK")
                            <p class="fw-regular font-size-12 text-danger mb-1">{{ $item->lembur_status }}</p>
                        @elseif($item->lembur_status == "DITERIMA")
                            <p class="fw-regular font-size-12 text-success mb-1">{{ $item->lembur_status }}</p>
                        @else
                            <p class="fw-regular font-size-12 text-primary mb-1">{{ $item->lembur_status }}</p>
                        @endif
                    </div>
                    <a href="{{ route("overtime.show", $item->id) }}" class="btn btn-sm btn-outline-danger">Detail</a>
                </li>
                @empty
                <li class="list-group-item px-2 py-3 mb-2">
                    <div class="text-center">
                        <p class="fw-bold font-size-14 mb-1">Belum ada lembur terinput</p>
                        <p class="fw-regular font-size-12 text-muted mb-1">Semua lembur yang kamu ajukan akan tampil disini</p>
                    </div>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
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
