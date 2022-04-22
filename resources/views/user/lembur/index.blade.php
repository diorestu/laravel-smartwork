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
                    <h2 class="fw-bold font-size-18 text-white mb-0">Lembur Saya</h2>
                </div>
                <div class=''>
                    <a href="{{ route('overtime.create') }}" class="btn btn-transparent-danger font-weight-bold text-white"><i
                            class="fa fa-plus text-white"></i></a>
                </div>
            </div>
        </div>
    </section>
    <section class="px-4">
        <div class="">
            <div class="d-flex justify-content-between align-items-baseline">
                <h4 class="mb-3">Pengajuan Lembur</h4>
                <a href='' class="font-size-sm text-peimary fw-bold">Lihat semua <i
                        class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div>
                @forelse($data as $item)
                    <div class="alert alert-secondary alert-top-border fade show mb-3" role="alert">
                        <div class="d-flex align-items-center justify-content-start">
                            <i class="fa fa-{{ $item->lembur_status == 'PENGAJUAN' ? 'info' : 'check' }}-circle fa-lg text-{{ $item->lembur_status == 'PENGAJUAN' ? 'primary' : 'success' }} align-middle me-3"></i>
                            <div>
                                <strong>{{ tglIndo2($item->lembur_awal) }}</strong> - <span class="text-muted">{{ tampilJamMenit($item->lembur_awal) }} s/d {{ tampilJamMenit($item->lembur_akhir) }}</span>
                                <br>
                                <em class="">{{ $item->lembur_keterangan }}</em>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="card rounded py-5 rounded">
                        <div class="d-flex justify-content-center align-self-center">
                            <div class="text-center">
                                <a class="text-muted">Tidak ada riwayat pengajuan</a>
                                <br>
                                <a class="fw-bold btn btn-primary py-1 mt-2" href="{{ route('overtime.create') }}">Tambah
                                    Pengajuan Lembur</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
