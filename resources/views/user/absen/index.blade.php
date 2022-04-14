@extends('layouts.mobile-navbar')

@section('title')
    Absen Saya
@endsection

@section('content')
    <section class="">
        <div class="ps-5 pe-4 pb-5 pt-3" style="background-color: #B0141C !important;">
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
            <div class="text-center">
                <b class="text-center fw-medium text-white font-size-16">{{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</b><br>
            </div>
            @if (!$shift || $shift == null)
            @else
                <br>
            @endif
        </div>
    </section>

    <main class="px-4 parent pb-0">
        <div class="child card rounded-lg mb-0 pb-0">
            <div class="card-body">
                <div class="text-center">
                    @if (!$shift || $shift == null)
                        <b class="fw-medium font-size-16 text-muted">Tidak Ada Shift</b><br>
                        <b class="fw-bold font-size-20 text-muted">-</b><br>
                    @else
                        <b class="fw-medium font-size-16 text-muted">{{ $shift->shift->ket_shift == 'Libur' ? 'Libur' : 'Shift '.$shift->shift->ket_shift  }}</b><br>
                        <b class="fw-bold font-size-20 text-muted">{{ tampilJamMenit($shift->shift->hadir_shift) }} -
                            {{ tampilJamMenit($shift->shift->pulang_shift) }}</b><br>
                    @endif
                </div>
                {{-- <hr> --}}
                <div class="row {{ $d ? 'd-none' : '' }}">
                    @if ($absen)
                        <div class="col-6">
                            <a id="btn" class="rounded-lg font-size-16 fw-medium btn btn-primary py-2 mt-2 w-100 {{ $in ? 'disabled' : '' }}"
                                href="{{ route('absen.create') }}">
                                IN {{ $in ? '- '.tampilJamMenit($absen->jam_hadir) : 'false' }}</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ $out ? '' : route('absen.edit', $absen->id) }}" id="btn" class="rounded-lg font-size-16 fw-medium btn btn-primary py-2 mt-2 w-100 {{ $out ? 'disabled' : '' }}">
                                OUT</a>
                                {{-- href="{{ $out ? '' : route('absen.edit', $absen->id) }}" --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <section class="px-4">
        <div class="">
            <div class="d-flex justify-content-between align-items-baseline">
                <h4 class="mb-3">Absensi Saya</h4>
                <a href='' class="font-size-sm text-primary fw-medium">Lihat semua <i
                        class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div>
                @forelse($riwayat as $item)
                    <a href="{{ route('absen.show', $item->id) }}" class="text-dark bg-white rounded mb-3 p-3 d-flex align-items-center">
                        <i class="fa fa-info-circle text-primary align-middle me-3"></i><strong>{{ tanggalIndoWaktu($item->jam_hadir) }}
                            - {{ $item->jam_pulang ? tanggalIndoWaktu($item->jam_pulang) : 'Belum Absen' }}</strong>
                    </a>
                @empty
                    <div class="card rounded py-5 rounded">
                        <div class="d-flex justify-content-center align-self-center">
                            <div class="text-center">
                                <a class="text-muted">Tidak ada riwayat absensi</a>
                                <br>
                                Tidak Ada Data Tersedia
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

