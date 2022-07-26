<div class="card-body px-2 py-1">
    <ul class="list-group list-group-flush">
        @forelse($data as $item)
        <li class="list-group-item px-2 py-1 mb-2 d-flex justify-content-between align-items-center">
            <div>
                <p class="fw-bold font-size-12 mb-1">{{ $item->cutiJenis->cuti_nama_jenis }}</p>
                <p class="fw-regular font-size-12 text-muted mb-1">{{ tglIndo4($item->cuti_awal) }} - {{ tglIndo4($item->cuti_akhir) }}</p>
                @if ($item->cuti_status == "DITOLAK")
                    <p class="fw-regular font-size-12 text-danger mb-1">{{ $item->cuti_status }}</p>
                @elseif($item->cuti_status == "DITERIMA")
                    <p class="fw-regular font-size-12 text-success mb-1">{{ $item->cuti_status }}</p>
                @else
                    <p class="fw-regular font-size-12 text-primary mb-1">{{ $item->cuti_status }}</p>
                @endif
            </div>
            <a href="{{ route("leave.show", $item->id_cuti) }}" class="btn btn-sm btn-outline-danger">Detail</a>
        </li>
        @empty
        <li class="list-group-item px-2 py-3 mb-2">
            <div class="text-center">
                <p class="fw-bold font-size-14 mb-1">Belum ada cuti yang diambil</p>
                <p class="fw-regular font-size-12 text-muted mb-1">Semua cuti yang kamu ajukan akan tampil disini</p>
            </div>
        </li>
        @endforelse
    </ul>
</div>
