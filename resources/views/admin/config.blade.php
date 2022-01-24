@extends('layouts.main')

@section('title')
    Profil Saya
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@section('content')
        <div class='mt-0'>
            <div class="row">
                <div class="col-xl-12">
                    <div class="profile-user"></div>
                </div>
            </div>

            <div class="row">
                <div class="profile-content">
                    <div class="row align-items-end">
                        <div class="col-sm">
                            <div class="d-flex align-items-end mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xxl me-3">
                                        <img src="{{ !$data->company_logo ? asset('backend-assets/images/no-image.png') : asset('storage/logo/' . Auth::user()->company_logo) }}"
                                            alt="" class="img-cropped rounded-circle d-block img-thumbnail">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-16 mb-1">{{ $data->nama }}</h5>
                                        <p class="text-muted font-size-13 mb-2 pb-2">{{ !$data->cabang ? '-' : $data->cabang->cabang_nama }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <h4 class="font-weight-bolder alert-heading">Berhasil</h4>
                    {{ $message }}
                </div>
            @endif

            {{-- <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body p-4">
                    <form action="{{ route('config.show', Auth::user()->id) }}" method="post">
                        @method('GET')
                        @csrf
                        <div class="mb-3">
                            <label for="my-input">Nomor Surat</label>
                            <input id="my-input" class="form-control" type="text" name="nomor_surat">
                        </div>
                        <div class="mb-3">
                            <label for="my-input">Tampilan Sistem</label>
                            <select id="my-input" class="form-select" type="text" name="layout_mode">
                                <option value="light">Mode Terang</option>
                                <option value="dark">Mode Gelap</option>
                            </select>
                        </div>
                        <button class="btn btn-primary w-100 btn-lg mt-3" type="submit">
                            <i class="fas fa-hdd icon-md"></i>&nbsp; Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </div> --}}
        </div>
@endsection

@push('addon-script')

@endpush
