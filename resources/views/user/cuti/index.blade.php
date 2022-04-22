@extends('layouts.mobile')

@section('title')
    Smartwork - Cuti Saya
@endsection

@section('content')
    <section class="mb-3">
        <div class="ps-5 pe-4 pb-4 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-0">
                <div>
                    <a href="{{ route('user.home') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white mb-0">Cuti Saya</h2>
                </div>
                <div class=''>
                    <a href="{{ route('leave.create') }}" class="btn btn-transparent-danger font-weight-bold text-white"><i
                            class="fa fa-plus fa-lg text-white"></i></a>
                </div>
            </div>
        </div>
    </section>
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
                    <span class="font-size-22 fw-black">{{ $sakit }}</span>
                </div>
            </div>
        </div>
    </div>
    <section class="px-4">
        <div class="">
            <div class="d-flex justify-content-between align-items-baseline">
                <h4 class="mb-3">Cuti Saya</h4>
                <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i
                        class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div>
                @forelse($data as $item)
                    <div class="alert alert-secondary alert-top-border fade show mb-3" role="alert">
                        <div class="d-flex align-items-center justify-content-start">
                            <i class="fa fa-info-circle fa-lg text-primary align-middle me-3"></i>
                            <div>
                                <strong>{{ tglIndo2($item->cuti_awal) }} - {{ tglIndo2($item->cuti_akhir) }}</strong>
                                <br>
                                <span class="">{{ $item->cuti_deskripsi }}</span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="card rounded py-5 rounded">
                        <div class="d-flex justify-content-center align-self-center">
                            <div class="text-center">
                                <a class="text-muted">Tidak ada riwayat pengajuan</a>
                                <br>
                                <a class="fw-bold btn btn-primary py-1 mt-2" href="{{ route('cuti.create') }}">Tambah
                                    Pengajuan Cuti</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
