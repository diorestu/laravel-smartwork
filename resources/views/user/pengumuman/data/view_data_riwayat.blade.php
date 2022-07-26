<div class="card mb-2 rounded-sm">
    <div class="card-body overflow-hidden position-relative p-2">
        <ul class="list-group list-group-flush">
            @forelse($data as $item)
            <li class="list-group-item px-2 py-1 mb-2 d-flex justify-content-between align-items-center">
                <div>
                    <p class="fw-bold font-size-12 mb-1">{{ $item->judul_pengumuman }}</p>
                    <p class="fw-regular font-size-12 text-muted mb-1">
                        {{ TanggalBulan($item->created_at) }}
                        &nbsp;&nbsp;<span class="badge bg-warning text-black">
                            @if ($item->id_divisi != 0) {{ $item->divisi->div_title }} @else {{ "Semua Divisi" }} @endif
                        </span>
                    </p>
                    <p class="fw-regular font-size-12 mb-1">
                        {{ Str::limit(strip_tags($item->desc_pengumuman), 300, ' ...') }}
                    </p>
                </div>
                <a href="{{ route("notifikasi.show", $item->id) }}" class="btn btn-sm btn-outline-danger">Detail</a>
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
