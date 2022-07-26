<ul class="nav nav-pills nav-justified" role="tablist">
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link rounded-top active" style="border-radius: 0px;" data-bs-toggle="tab" href="#home-1" role="tab" aria-selected="false">
            <span class="d-block d-sm-none">Jadwal Kerja</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link rounded-top" style="border-radius: 0px;" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
            <span class="d-block d-sm-none">Perubahan Jadwal</span>
        </a>
    </li>
</ul>
<div class="tab-content px-0 pt-2 pb-0 text-muted">
    <div class="tab-pane active" id="home-1" role="tabpanel">
        <div class="card-body px-0 py-0 table-responsive">
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
        </div>
    </div>
    <div class="tab-pane" id="profile-1" role="tabpanel">
        <div class="card-body px-0 py-1">
            <ul class="list-group list-group-flush">
                @forelse($pengajuan as $item_pengajuan)
                    <li class="list-group-item px-3 py-1 mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="fw-bold font-size-14 mb-1">{{ tanggalIndo($item_pengajuan->tgl_shift) }}</p>
                            <p class="fw-regular font-size-12 text-muted mb-1 d-flex align-items-center">
                                {{ $item_pengajuan->shift->ket_shift }}
                                <i class="font-size-18 mx-2 text-danger bx bx-transfer"></i>
                                {{ $item_pengajuan->shift_baru->ket_shift }}
                            </p>
                            @if ($item_pengajuan->status == "ditolak")
                                <p class="fw-regular font-size-12 text-danger mb-1 text-uppercase d-flex align-items-center"><i class="font-size-16 me-1 text-danger bx bxs-minus-circle"></i> {{ $item_pengajuan->status }}</p>
                            @elseif($item_pengajuan->status == "disetujui")
                                <p class="fw-bold font-size-12 text-success mb-1 text-uppercase d-flex align-items-center"><i class="font-size-16 me-1 text-success bx bxs-check-circle"></i> {{ $item_pengajuan->status }}</p>
                            @else
                                <p class="fw-bold font-size-12 text-primary mb-1 text-uppercase d-flex align-items-center"><i class="font-size-16 me-1 text-primary bx bx-loader-circle"></i> {{ $item_pengajuan->status }} VERIFIKASI</p>
                            @endif
                        </div>
                        <a href="{{ route("schedule.show", $item_pengajuan->id) }}" class="btn btn-sm btn-outline-danger">Detail</a>
                    </li>
                @empty
                    <li class="list-group-item px-2 py-3 mb-2">
                        <div class="text-center">
                            <p class="fw-bold font-size-14 mb-1">Tidak ada perubahan jadwal</p>
                            <p class="fw-regular font-size-12 text-muted mb-1">Semua perubahan jadwal yang kamu ajukan akan tampil disini</p>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
