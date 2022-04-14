@extends('layouts.mobile-navbar')

@section('title')
    Halaman Beranda Pengguna
@endsection

@push('addon-style')
    <style>
        .rounded-top-sm{
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    </style>
@endpush

@section('content')
    <livewire:home>
@endsection

@push('addon-script')
<script>
    $(function(){
        $('#btn-logout').click(function(){
            if(confirm('Anda akan keluar dari Aplikasi, lanjutkan?')) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
                return false;
        });
    });
</script>
@endpush

