@extends('layouts.auth')

@section('title')
    Login ke SMARTWORK
@endsection

@section('content')
<div class="auth-content my-auto">
    <div class="text-center">
        <h5 class="mb-0">Selamat Datang di <strong class="text-danger font-size-20 fw-black">smartwork</strong> !</h5>
        <p class="text-muted mt-2">Login untuk mulai menggunakan smartwork</p>
    </div>
    <div class="">
        @error('username')
        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <strong>Gagal!</strong> - Pengguna Tidak Ditemukan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror
        @error('password')
        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <strong>Gagal!</strong> - {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror
    </div>
    <form class="mt-4 pt-2" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-floating form-floating-custom mb-4">
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="input-username" name="username" value="{{ old('username') }}"
            placeholder="NIP / Nama Pengguna" required autofocus>
            <label for="input-username">Nama Pengguna</label>
            <div class="form-floating-icon">
               <i data-feather="users"></i>
            </div>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
            <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" id="password-input" placeholder="Enter Password" name="password">

            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
            </button>
            <label for="input-password">Password</label>
            <div class="form-floating-icon">
                <i data-feather="lock"></i>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <button class="btn btn-danger w-100 waves-effect waves-light py-3" style="background-color: #b7094c;" type="submit">Login</button>
        </div>
    </form>

    <div class="mt-5 text-center">
        <p class="text-muted mb-0">Belum memiliki akun smartwork? <a href="{{ route('register') }}"
                class="text-primary fw-semibold"> Daftar Sekarang</a> </p>
    </div>
</div>
@endsection

