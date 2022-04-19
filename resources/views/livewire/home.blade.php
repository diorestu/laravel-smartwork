<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <section class="p-0">
        <div class="ps-5 pe-4 pb-4 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="mb-0">
                    <h2 class="fw-bold font-size-18 text-white">Hai, {{ $data->nama }}</h2>
                    <p class="text-white-50 fw-light font-size-12 mb-1">{{ $data->cabang->cabang_nama }}</p>
                </div>
                <div class='mt-3'>
                    {{-- <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i class="fa fa-moon icon-lg layout-mode-dark font-size-20"></i>
                        <i class="fa fa-sun icon-lg layout-mode-light font-size-20"></i>
                    </button> --}}
                    <a class='btn ms-3 text-white' id="btn-logout"><i
                            class="fa fa-sign-out-alt icon-lg font-size-20"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="text-center mb-3">
                <b class="text-center fw-medium text-white font-size-16">{{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</b><br>
            </div>
            @if (!$shift || $shift == null)
            @else
                <br>
            @endif
        </div>
        <div class="parent mb-6">
            <div class="child-float rounded mt-5 px-4">
                <div class="card rounded-sm">
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
                        {{-- <div class="row {{ $d ? 'd-none' : '' }}">
                            <div class="col-6">
                                <a id="btn" class="fw-medium btn btn-primary py-2 mt-2 w-100"
                                    href="{{ route('absen.create') }}">
                                    IN</a>
                            </div>
                            <div class="col-6">
                                <a id="btn" class="fw-medium btn btn-primary py-2 mt-2 w-100"
                                    href="{{ route('absen.create') }}">
                                    OUT</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <div class="ms-4" data-aos="fade-right" data-aos-duration="700">
        <div class="d-flex flex-row flex-nowrap overflow-auto example">
            <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <h3 class="fw-bold font-size-16 mt-1">Cuti</h3>
                    <span class="font-size-22 fw-black">{{ $cuti }}</span>
                </div>
            </div>
            <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <h3 class="fw-bold font-size-16 mt-1">Izin</h3>
                    <span class="font-size-22 fw-black">0</span>
                </div>
            </div>
            <div class="card rounded-sm me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <h3 class="fw-bold font-size-16 mt-1">Sakit</h3>
                    <span class="font-size-22 fw-black">0</span>
                </div>
            </div>
        </div>
    </div>

    <section class="px-4">
        <div class="mt-3">
            <style>
                .menu {
                    min-height: 95px !important;
                }

                i.circle {
                    display: inline-block;
                    border-radius: 100%;
                    box-shadow: 0 0 2px #888;
                    padding: 0.5em 0.6em;
                }

            </style>
            <h4 class="mb-3 fw-bold">Menu Utama</h4>
            {{-- <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i class="fa fa-chevron-right icon-xs text-peimary fw-bold"></i></a> --}}
            <div class="row">
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('user.data') }}" class="mb-2">
                            <i class="bi bi-person-circle circle font-size-20 px-3 text-white"
                                style="background-color: #dc2626"></i>
                        </a>
                        <span>Profil</span>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('user.jadwal') }}" class="mb-2">
                            <i class="bi bi-calendar-week circle font-size-20 px-3 text-white"
                                style="background-color: #ea580c"></i>
                        </a>
                        <span>Jadwal</span>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('absen.index') }}" class="mb-2">
                            <i class="bi bi-alarm-fill circle font-size-20 px-3 text-white"
                                style="background-color: #65a30d"></i>
                        </a>
                        <span>Absensi</span>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('kegiatan.index') }}" class="mb-2">
                            <i class="bi bi-star-fill circle font-size-20 px-3 text-white"
                                style="background-color: #0d9488"></i>
                        </a>
                        <span>Aktivitas</span>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('leave.index') }}" class="mb-2">
                            <i class="bi bi-calendar-x circle font-size-20 px-3 text-white"
                                style="background-color: #0284c7"></i>
                        </a>
                        <span>Cuti</span>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="" class="mb-2">
                            <i class="bi bi-clock-history circle font-size-20 px-3 text-white"
                                style="background-color: #7c3aed"></i>
                        </a>
                        <span>Lembur</span>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('user.gaji') }}" class="mb-2">
                            <i class="bi bi-wallet2 circle font-size-20 px-3 text-white"
                                style="background-color: #c026d3"></i>
                        </a>
                        <span>Gaji</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>
