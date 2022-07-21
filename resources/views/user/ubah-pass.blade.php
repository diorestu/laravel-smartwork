@extends('layouts.mobile')

@section('title')Ubah Kata Sandi | Smartwork @endsection

@push('addon-style')
<style>
    .no-border { border: none !important; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Ubah Kata Sandi</h2>
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
    <section>
        <div class="card m-2 rounded-sm">
            <form action="{{ route('user.pass.save') }}" method="post" id="myForm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted"><span class="text-danger">*</span> Kata Sandi Lama</span>
                            <input id="oldpassword" required class="form-control text-dark mt-1" type="password" name="oldpassword" placeholder="masukan kata sandi lama Anda">
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted"><span class="text-danger">*</span> Kata Sandi Baru</span>
                            <input id="password" required class="form-control text-dark mt-1" type="password" name="password" placeholder="ketik kata sandi baru Anda">
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted"><span class="text-danger">*</span> Ulangi Kata Sandi Baru</span>
                            <input id="password-confirm" required class="form-control text-dark mt-1" type="password" name="password_confirmation" placeholder="ketik ulang kata sandi baru Anda" autocomplete="new-password">
                        </li>
                    </ul>
                    <p class="px-2 mt-2 text-danger">* merupakan field yang harus diisi</p>
                </div>
                <div class="fixed-bottom mb-0 card p-2">
                    <button type="submit" class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white">
                        <i class="label-icon fa fa-check-circle me-2"></i>Update Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('addon-script')
@endpush
