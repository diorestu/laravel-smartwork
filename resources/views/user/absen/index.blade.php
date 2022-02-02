@extends('layouts.mobile-navbar')

@section('title')
    Absen Saya
@endsection

@section('content')
@php
    $id = Auth::user();
    $linkIndex = 'absen.index';
    $linkHadir = 'absen.create';
    $linkPulang = 'absen.edit';
        if (!$absen) {
            $link = route($linkHadir);
        }else{
            $link = route($linkPulang, $absen->id);
        }
@endphp
    <section class="">
        <div class="ps-5 pe-4 pb-5 pt-3" style="background-color: #B0141C !important; border-bottom-left-radius: 20%; border-bottom-right-radius: 20%;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Hai, {{ $id->nama }}</h2>
                    <p class="text-white-50 fw-light font-size-12">{{ $id->company }}</p>
                </div>
                <div class=''>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>

                </div>
            </div>
        </div>
    </section>
    <main class="px-4 mt-3 parent pb-0">
        <div class="child card rounded mb-0 pb-0">
            <div class="card-body">
                <div class="text-center mb-4">
                    <b class="fw-medium font-size-16">{{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</b><br>
                    <b class="fw-medium font-size-18 text-muted">Pagi</b><br>
                    <b class="fw-bold font-size-20 text-muted">07:00 - 16:00</b><br>
                    {{-- <b class="fw-bold font-size-18 text-muted">{{ $absen->jam_hadir }}</b><br> --}}
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <a class="fw-bold btn btn-primary py-2 mt-2 w-100" href="{{ route('absen.create') }}">IN {{ $absen != null ? '- '. tampilJamMenit($absen->jam_hadir) : '' }}</a>
                    </div>
                    <div class="col-6">
                        <a class="fw-bold btn btn-primary py-2 mt-2 w-100" href="{{ !$absen || $absen->jam_hadir != null ? '' : route('absen.edit', $absen->id) }}">OUT {{ !$absen || !$absen->jam_pulang ? '' : '- '.tampilJamMenit($absen->jam_pulang) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
<section class="px-4">
    <div class="">
        <div class="d-flex justify-content-between align-items-baseline">
            <h4 class="mb-3">Absensi Saya</h4>
            <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
        </div>
        <div>
            @forelse($riwayat as $item)
                <div class="alert alert-secondary alert-top-border fade show mb-3" role="alert">
                    <i class="fa fa-info-circle text-primary align-middle me-3"></i><strong>{{ tglIndo2($item->jam_hadir) }}</strong> - {{ $item->ket_hadir }}
                </div>
            @empty
                <div class="card rounded py-5 rounded">
                    <div class="d-flex justify-content-center align-self-center">
                        <div class="text-center">
                            <a class="text-muted">Tidak ada riwayat absensi</a>
                            <br>
                            <a class="fw-bold btn btn-primary py-1 mt-2" href="{{ route('absen.create') }}">Tambah Absensi</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
