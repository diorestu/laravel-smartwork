@extends('layouts.mobile')

@section('title')
    Profil Saya
@endsection
{{--
@push('addon-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush --}}

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4 pb-3 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div>
                    <a href="{{ route('user.home') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white mb-0">Slip Gaji</h2>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white"></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        @foreach ($gaji as $item)
            <div class="p-4">
                <a href="" class="text-dark text-decoration-none w-100">
                    <div class="d-flex justify-content-between align-items-center pe-2 py-2 mb-1">
                        <span class="fw-semibold">{{ Bulan($item->slip->pay_bulan) }} {{ $item->slip->pay_tahun }}</span>
                        <span><i class="fa fa-chevron-right"></i></span>
                    </div>
                </a>
            </div>
        @endforeach
    </section>
@endsection

{{-- @push('addon-script')
    <script>
        $(function() {
            $('#btn-logout').click(function() {
                if (confirm('Anda akan keluar dari Aplikasi, lanjutkan?')) {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                }
                return false;
            });
        });
    </script>
@endpush --}}
