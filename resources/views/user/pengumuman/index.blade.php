@extends('layouts.mobile')

@section('title')Pengumuman | Smartwork @endsection

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Pengumuman</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2">
        <div class="card mb-2">
            <form id="formAction" action="#" method="POST">
                @method('POST')
                @csrf
                <div class="d-flex">
                    <div class="col-12 pr-0 input-group">
                        <div class="input-group-text"><i class="font-size-18 bx bx-filter-alt"></i></div>
                        <input class="form-control" type="month" value="{{ date("Y-m") }}" name="hari" id="example-month-input">
                    </div>
                </div>
            </form>
        </div>
        <div id="content">
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
                                <p class="fw-bold font-size-14 mb-1">Belum ada pengumuman tersedia</p>
                                <p class="fw-regular font-size-12 text-muted mb-1">Semua pengumuman dari perusahaan Anda akan tampil disini</p>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('addon-script')
    <script>
        $('#example-month-input').change(function() {
            var url = "{{ route('notifikasi.riwayat') }}";
            var date = $(this).val();
            if (date != "") {
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    url: url,
                    data: {'hari': date},
                    type: 'POST',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang Memproses Data...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false
                        });
                        Swal.showLoading();
                    },
                    success: function(result) {
                        $('#content').html(result);
                    },
                    complete: function(data) {
                        Swal.close();
                    }
                });
            } else {
                Swal.fire('Maaf','Silahkan pilih periode terlebih dahulu.','error');
            }
        });
    </script>
@endpush
