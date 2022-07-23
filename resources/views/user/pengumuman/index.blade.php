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
                                <a href="{{ route('notifikasi.show', $item->id) }}" class="text-primary fw-medium"> <u>Baca Lebih Detail </u> <i class="mdi mdi-arrow-right ms-1 align-middle"></i></a>
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
