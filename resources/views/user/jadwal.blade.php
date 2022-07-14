@extends('layouts.mobile')

@section('title')
    Profil Saya
@endsection
{{-- @push('addon-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush --}}

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div>
                    <a href="{{ route('user.home') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white mb-0">Jadwal Kerja Saya</h2>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white"></h2>
                </div>
            </div>
        </div>
    </section>
    <section class="p-3">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th colspan="2" class="text-center">Jam Kerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $item)
                    <tr>
                        <td scope="row">{{ tanggalIndo($item->tanggal_shift) }}</td>
                        <td>{{ $item->shift->ket_shift }}</td>
                        <td>{{ tampilJamMenit($item->shift->hadir_shift) }}</td>
                        <td>{{ tampilJamMenit($item->shift->pulang_shift) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection

@push('addon-script')
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
@endpush
