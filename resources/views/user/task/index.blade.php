@extends('layouts.mobile-navbar')

@section('title')
    Smartwork - Kegiatan Saya
@endsection

@section('content')
    <section class="">
        <div class="ps-5 pe-4 pb-5 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline pt-3 pb-0">
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Kegiatan Saya</h2>
                </div>
                <div class=''>
                    <a href="{{ route('kegiatan.create') }}"
                        class="btn btn-transparent-danger font-weight-bold mr-2 text-white"><i
                            class="fa fa-plus text-white me-2"></i>Tambah</a>
                </div>
            </div>
        </div>
    </section>
    <main class="px-4 mt-3 parent pb-0">
        <div class="child card rounded mb-0 pb-0">
            <div class="card-body">
                <div class="text-center mb-4">
                    <b
                        class="fw-medium font-size-16">{{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</b><br>
                    {{-- <b class="fw-bold font-size-18 text-muted">{{ $absen->jam_hadir }}</b><br> --}}
                </div>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <div class="card">

                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                </div>

            </div>
        </div>
    </main>
    <hr>
    <section class="px-4">
        <div class="">
            <div class="d-flex justify-content-between align-items-baseline">
                <h4 class="mb-3">Kegiatan Saya</h4>
                <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i
                        class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div>
                @forelse($data as $item)
                    <div class="bg-white rounded mb-3 p-3 d-flex align-items-center shadow-sm">
                        <i
                            class="fa fa-info-circle text-primary align-middle me-3"></i><strong>{{ tglIndo2($item->tanggal_kgt) }}</strong>-
                        {{ $item->title_kgt }}</strong>
                    </div>
                @empty
                    <div class="card rounded py-5 rounded">
                        <div class="d-flex justify-content-center align-self-center">
                            <div class="text-center">
                                <a class="text-muted">Tidak ada riwayat pengajuan</a>
                                <br>
                                <a class="fw-bold btn btn-primary py-1 mt-2" href="{{ route('kegiatan.create') }}">Tambah Kegiatan</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
