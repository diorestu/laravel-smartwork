@extends('layouts.mobile')

@section('title')Ubah Kata Sandi | Smartwork @endsection

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
        <form action="{{ route('user.pass.save') }}" method="post" id="myForm">
            <div class="col=12">
                <div class="card p-4">
                    @method('POST')
                    @csrf
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="oldpassword"><span class="text-danger">*</span> Kata Sandi Lama</label>
                        <input id="oldpassword" required class="form-control text-dark" type="password" name="oldpassword" placeholder="masukan kata sandi lama Anda">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="password"><span class="text-danger">*</span> Kata Sandi Baru</label>
                        <input id="password" required class="form-control text-dark" type="password" name="password" placeholder="ketik kata sandi baru Anda">
                    </div>
                    <div class="mb-3">
                        <label class="font-size-12 mb-1 fw-light" style="color: #888;" for="password-confirm"><span class="text-danger">*</span> Ulangi Kata Sandi Baru</label>
                        <input id="password-confirm" required class="form-control text-dark" type="password" name="password_confirmation" placeholder="ketik ulang kata sandi baru Anda" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <p class="text-danger mb-0">* merupakan field yang harus diisi</p>
                    </div>
                </div>
                <div class="fixed-bottom mb-0 card p-2">
                    <button type="submit" class="btn btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white">
                        <i class="label-icon fa fa-check-circle me-2"></i>Update Kata Sandi
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('addon-script')
@endpush
