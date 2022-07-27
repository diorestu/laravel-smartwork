@extends('layouts.mobile')

@section('title')Pengajuan Cuti | Smartwork @endsection

@push('addon-style')
<style>
    .no-border { border: none !important; }
    .main-content { overflow: inherit; }
    .child_i { position: absolute; top:-170px; width: 100%; display: block; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important; height:250px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Pengajuan Cuti</h2>
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
    <section class="parent">
        <form class="child_i" action="{{ route('leave.store') }}" method="post" id="myForm">
            <div class="card m-2 rounded-sm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-2 py-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Jenis Cuti <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-briefcase-alt-2"></i></div>
                                <select id="cuti_jenis" class="form-select text-dark" name="id_cuti_jenis" required>
                                    @foreach ($jenis as $item)
                                        <option value="{{ $item->id }}">{{ $item->cuti_nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li class="list-group-item px-2 py-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Hari Cuti <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-calendar-alt"></i></div>
                                <input id="cuti_awal" class="form-control text-dark" type="date" name="cuti_awal" required>
                            </div>
                        </li>
                        <li class="list-group-item px-2 py-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Jumlah Hari Cuti <span class="text-danger">*</span></span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx bx-calendar-alt"></i></div>
                                <select id="cuti_total" class="form-select text-dark" name="cuti_total" required>
                                    @for($i = 1; $i < 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} hari</option>
                                    @endfor
                                </select>
                            </div>
                        </li>
                        <li class="list-group-item px-2 py-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Keterangan Cuti</span>
                            <div class="col-12 pr-0 input-group mt-1">
                                <div class="input-group-text"><i class="font-size-18 bx bx-menu-alt-left"></i></div>
                                <textarea id="cuti_deskripsi" class="form-control text-dark" name="cuti_deskripsi" cols="3" required></textarea>
                            </div>
                        </li>
                        <li class="list-group-item p-2 no-border">
                            <span class="font-size-11 text-danger">* merupakan field yang tidak boleh kosong</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div style="padding-bottom:1.5rem;" class="fixed-bottom mb-0 card px-2 pt-2 rounded-sm">
                    <button type="submit" class="btn btn-lg btn-primary waves-effect btn-label waves-light fw-regular font-size-16 text-white rounded-sm">
                        <i class="label-icon fa fa-check-circle me-2"></i>Ajukan Cuti
                    </button>
                </div>
            </div>
        </form>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection

@push('addon-script')
@endpush
