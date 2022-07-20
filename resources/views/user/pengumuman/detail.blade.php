@extends('layouts.mobile')

@section('title')Detail Aktivitas | Smartwork @endsection

@push('addon-style')
<style>
    .isi_pengumuman p { margin-bottom: 0px; }
</style>
@endpush

@section('content')
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Detail Pengumuman</h2>
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
    <div>
        <div class="card m-2 rounded-sm">
            <div class="card-header bg-light p-3">
                <h5 class="my-0 text-dark">{{ $data->judul_pengumuman }}</h5>
            </div>
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-2">
                        <span class="text-muted">Ditujukan Kepada</span>
                        <br>
                        <span>@if ($data->id_divisi != 0) {{ $data->divisi->div_title }} @else {{ "Semua Divisi" }} @endif</span>
                    </li>
                    <li class="list-group-item px-2 isi_pengumuman">
                        @php echo $data->desc_pengumuman @endphp
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-6 px-0">
                                <span class="text-muted">Diinput pada</span>
                                <br>
                                <span>{{ tanggalIndoWaktuLengkap($data->created_at) }}</span>
                            </div>
                            <div class="col-6 px-0">
                                <span class="text-muted">Diupdate pada</span>
                                <br>
                                <span>{{ tanggalIndoWaktuLengkap($data->updated_at) }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <section class="pt-0 pb-2 px-2 mt-3">
        <div class="card mb-2">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <a href="#" class="btn btn-light text-dark waves-effect btn-label waves-light fw-bold w-100">
                        <i class="label-icon fa fa-download"></i>&nbsp; Download lampiran pengumuman
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('addon-script')
@endpush
