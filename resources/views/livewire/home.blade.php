<style>
    .menu {
        min-height: 95px !important;
    }
    .child-float {
        position: absolute;
        top: -45px;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
    }
    i.circle {
        display: inline-block;
        border-radius: 100%;
        box-shadow: 0 0 2px #888;
        padding: 0.5em 0.6em;
    }
</style>
<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <section class="p-0">
        <div class="ps-5 pe-5 pt-1" style="background-color: #B0141C !important; height:300px;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="mb-0">
                    <p class="text-white fw-light font-size-12 mb-1">{{ $data->cabang->cabang_nama }}</p>
                    <h2 class="fw-bold font-size-25 text-white">{{ $data->nama }}</h2>
                    <p class="text-white fw-regular font-size-13 mb-1">{{ $data->jabatan->jabatan_title }}</p>
                </div>
                <div class='mt-3'>
                    <a class='btn ms-3 text-white' id="btn-logout"><i
                            class="fa fa-sign-out-alt icon-lg font-size-20"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="text-center mb-1 mt-4">
                <b class="text-center fw-medium text-white font-size-12">Hari ini - {{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</b><br>
            </div>
        </div>
        <div class="parent mb-6" wire:ignore>
            <div class="child-float rounded mt-5 px-3">
                <div class="card rounded-sm">
                    <div class="card-body">
                        <div>
                            <div class="row">
                                <div class="col-3 mb-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('user.data') }}" class="mb-2">
                                            <i class="bi bi-person-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #dc2626"></i>
                                        </a>
                                        <span>Profil</span>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('user.jadwal') }}" class="mb-2">
                                            <i class="bi bi-calendar-week-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #ea580c"></i>
                                        </a>
                                        <span>Jadwal</span>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('absen.index') }}" class="mb-2">
                                            <i class="bi bi-geo-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #65a30d"></i>
                                        </a>
                                        <span>Presensi</span>
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
                                <div class="col-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('leave.index') }}" class="mb-2">
                                            <i class="bi bi-calendar-x-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #0284c7"></i>
                                        </a>
                                        <span>Cuti</span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('overtime.index') }}" class="mb-2">
                                            <i class="bi bi-clock-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #7c3aed"></i>
                                        </a>
                                        <span>Lembur</span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('user.gaji') }}" class="mb-2">
                                            <i class="bi bi-wallet-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #c026d3"></i>
                                        </a>
                                        <span>Slip Gaji</span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{ route('user.gaji') }}" class="mb-2">
                                            <i class="bi bi-info-circle-fill circle font-size-20 px-3 text-white"
                                                style="background-color: #588157"></i>
                                        </a>
                                        <span>Pengumuman</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="ms-3" style="margin-top:110px;" data-aos="fade-right" data-aos-duration="700">
        <div class="d-flex flex-row flex-nowrap overflow-auto example">
            <div class="card rounded-md me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <i class="bi bi-calendar-x font-size-20 px-0" style="color: #ccc;"></i>
                    <h3 class="fw-light text-black-50 font-size-12 mt-1 mb-0">Request</h3>
                    <span class="text-black font-size-14">Hari Cuti</span>
                    {{-- <span class="font-size-22 fw-black">{{ $cuti }}</span> --}}
                </div>
            </div>
            <div class="card rounded-md me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <i class="bi bi-calendar-x font-size-20 px-0" style="color: #ccc;"></i>
                    <h3 class="fw-light text-black-50 font-size-12 mt-1 mb-0">Request</h3>
                    <span class="text-black font-size-14">Lembur</span>
                </div>
            </div>
            <div class="card rounded-md me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <i class="bi bi-calendar-x font-size-20 px-0" style="color: #ccc;"></i>
                    <h3 class="fw-light text-black-50 font-size-12 mt-1 mb-0">Request</h3>
                    <span class="text-black font-size-14">Presensi</span>
                </div>
            </div>
            <div class="card rounded-md me-3" style="min-height: 70px; min-width:120px;">
                <div class="card-body py-2 px-3">
                    <i class="bi bi-calendar-x font-size-20 px-0" style="color: #ccc;"></i>
                    <h3 class="fw-light text-black-50 font-size-12 mt-1 mb-0">Request</h3>
                    <span class="text-black font-size-14">Ubah Shift</span>
                </div>
            </div>
        </div>
    </div>

    <section class="px-3">
        <div class="mt-0">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active card mb-0">
                        <div class="d-flex rounded-sm" style="background-color:#F69C48;">
                            <img class="d-block" height="100px" src="{{ asset("backend-assets/images/dashboard/ewa.png") }}" alt="Earn Wage Access">
                            <div class="my-3 px-2">
                                <h5 class="mt-0 mb-0 text-white">Earn Wage Access</h5>
                                <span class="font-size-11 text-white">Akses gaji fleksibel untuk kesehatan finansial pegawai  Anda semua Anda</span>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item card mb-0">
                        <div class="d-flex rounded-sm" style="background-color:#CA2A3D;">
                            <img class="d-block" height="100px" src="{{ asset("backend-assets/images/dashboard/dark.png") }}" alt="Earn Wage Access">
                            <div class="my-3 px-1">
                                <h5 class="mt-0 mb-2 text-white">Mode Gelap Kini Sudah Hadir</h5>
                                <span class="font-size-11 text-white">Smartwork dengan model gelap untuk menghilangkan lelah pada mata Anda</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
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
