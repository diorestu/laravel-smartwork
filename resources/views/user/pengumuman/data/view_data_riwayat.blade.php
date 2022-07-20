@forelse($data as $item)
<div class="card mb-2 rounded-sm">
    <div class="card-body overflow-hidden position-relative p-2">
        <div>
            <i class="bx bx-info-circle widget-box-1-icon text-primary"></i>
        </div>
        <div class="d-flex">
            <div class="faq-count">
                <div class="avatar-lg m-auto" style="height: 3rem;">
                    <span class="avatar-title rounded bg-soft-danger text-danger font-size-13 fw-bold">
                        {{ TanggalBulan($item->created_at) }}
                    </span>
                </div>
            </div>
            <div class="flex-1 ms-3">
                <h5 class="mt-2">{{ $item->judul_pengumuman }}</h5>
                <p class="mt-3 mb-0 fw-semibold"><i class="text-primary fa fa-bullhorn"></i>&nbsp; @if ($item->id_divisi != 0) {{ $item->divisi->div_title }} @else {{ "Semua Divisi" }} @endif</p>
                <p class="text-muted mt-1 mb-0">
                    {{ Str::limit(strip_tags($item->desc_pengumuman), 300, ' ...') }}
                </p>
                <div class="mt-4">
                    <a href="{{ route('pengumuman.show', $item->id) }}" class="text-primary fw-medium"> <u>Baca Lebih Detail </u> <i class="mdi mdi-arrow-right ms-1 align-middle"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="mt-4 text-center">
    <h1 class="m-0" style="font-size: 50px;"><i class="dripicons-broadcast"></i></h1>
    <span class="font-size-16 fw-bold">Tidak ada pengumuman di bulan ini <br>
        <small class="fw-medium text-muted">Untuk saat ini belum ada pengumuman di perusahaan kamu.</small>
    </span>
</div>
@endforelse
