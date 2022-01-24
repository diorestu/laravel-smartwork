@extends('layouts.auth')

@section('content')
    <div class="auth-content my-auto">
        <div class="text-center">
            <h5 class="mb-0">Selamat Datang di <strong class="text-danger font-size-20 fw-black">smartwork</strong> !</h5>
            {{-- <p class="text-muted mt-2">Bergabung ke <strong class="text-danger fw-bold">smartwork</strong> dengan melengkapi Data Diri Anda</p> --}}
        </div>

        <form class="mt-3" action="{{ route('register') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-floating form-floating-custom mb-2">
                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                id="input-nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap Anda" required autofocus autocomplete="">
                <label for="input-nama">Nama Lengkap</label>
                <div class="form-floating-icon">
                   <i data-feather="user"></i>
                </div>
                @error('nama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating form-floating-custom mb-2">
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="input-username" name="username" value="{{ old('username') }}"
                placeholder="Nama Pengguna" required>
                <label for="input-username">Username Anda</label>
                <div class="form-floating-icon">
                   <i data-feather="users"></i>
                </div>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating form-floating-custom mb-2">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="input-email" name="email" value="{{ old('email') }}"
                placeholder="Email Anda" required>
                <label for="input-email">Email Anda</label>
                <div class="form-floating-icon">
                   <i data-feather="mail"></i>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating form-floating-custom mb-2">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="input-password" name="password" value="{{ old('password') }}"
                placeholder="NIP / Nama Pengguna" required>
                <label for="input-password">Kata Sandi Anda</label>
                <div class="form-floating-icon">
                   <i data-feather="lock"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating form-floating-custom mb-2">
                <input type="password" class="form-control" placeholder='Konfirmasi Kata Sandi' id="password-confirm" name="password_confirmation" required autocomplete="new-password" required>
                <label for="input-password">Ulangi Kata Sandi Anda</label>
                <div class="form-floating-icon">
                   <i data-feather="lock"></i>
                </div>
            </div>
            <div class="mt-2">
                <button class="btn btn-danger w-100 waves-effect waves-light py-3" style="background-color: #b7094c;" type="submit">Register</button>
            </div>
            <div class="mt-1">
                <a href="{{ route('login') }}" class="btn btn-light-danger w-100 waves-effect waves-light py-3">Kembali ke Login</a>
            </div>
        </form>
    </div>




@endsection
{{-- <div class="d-flex flex-column flex-root">
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-none login-aside d-md-flex flex-column flex-row-auto bg-dot">
            <div class="d-flex flex-column-auto flex-column pt-lg-30 pt-15">
                <a href="" class="login-logo text-center pb-4">
                    <img src="{{ asset('images/logo-sw-fullwhite.png') }}" class="max-h-70px" alt="" />
                </a>
                <br>
                <br>
            </div>
            <div class="text-center">
                <img class="img-fluid pt-4 mt-2" src="{{ asset('images/123.png') }}" width="250px"
                    alt="Banner Aside">
            </div>
            <br>
            <br>
            <p class="text-center text-white pt-4 mt-2">2021 © Asta Pijar Kreasi Teknologi</p>
        </div>
        <div class="login-content flex-row-fluid d-flex flex-column bg-white">
            <div class="d-flex flex-row-fluid flex-center pt-8">
                <div class="login-form" id="register">
                    <img src="{{ asset('images/logo-sw-dark.png') }}" class="max-h-50px d-block d-md-none" alt="" />
                    <br class="d-block d-md-none">
                    <br class="d-block d-md-none">
                    <br class="d-block d-md-none">
                    <form class="form" action="{{ route('register') }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <div class="pb-4">
                            <h4 class="font-weight-bold text-dark font-size-lg font-size-h1-md mb-4">Bergabung ke <b
                                    class='font-weight-boldest'>smartwork</b> dengan melengkapi Data Diri Anda</h4>
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Nama Lengkap Anda</label>
                            <input id="nama" type="text"
                                class="form-control form-control-solid @error('nama') is-invalid @enderror" name="nama"
                                value="{{ old('nama') }}" placeholder='Nama Lengkap Anda' required
                                autocomplete="nama" autofocus>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Nama Pengguna</label>
                            <input id="username" type="text"
                                class="form-control form-control-solid @error('username') is-invalid @enderror"
                                name="username" value="{{ old('username') }}" required autocomplete="username"
                                autofocus placeholder='Nama Pengguna'>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            {{-- <label class="font-size-h6 font-weight-bolder text-dark">Email Pengguna</label>
                            <input id="email" type="email"
                                class="form-control form-control-solid @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder='Email Anda'>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                {{-- <label class="font-size-h6 font-weight-bolder text-dark pt-5">Kata Sandi</label>
                            </div>
                            <input id="password" type="password"
                                class="form-control form-control-solid @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder='Kata Sandi Anda'>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                {{-- <label for="password-confirm" class="font-size-h6 font-weight-bolder text-dark pt-5">Konfirmasi Kata Sandi</label>
                            </div>
                            <input id="password-confirm" type="password" class="form-control form-control-solid"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder='Konfirmasi Kata Sandi' required>
                        </div>
                        <div class="pb-lg-0 pb-5">
                            <button type="submit"
                                class="btn btn-block btn-danger font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"
                                :disabled="this.email_unavailable">{{ __('Register') }}</button>

                            <a href="{{ route('login') }}"
                                class="btn btn-block btn-outline-danger font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">
                                Kembali ke Halaman Login
                            </a>
                        </div>
                    </form>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password"
                            class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
