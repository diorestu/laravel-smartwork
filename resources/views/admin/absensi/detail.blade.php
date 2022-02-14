@extends('layouts.main')

@section('title')
    Detail Absensi Pegawai
@endsection

@push('addon-style')
    <style>
        .map { height: 200px; display: block; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Absensi Pegawai</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("absensi.index") }}">Absensi Pegawai Hari Ini</a></li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Absensi Pegawai Hari Ini</h4>
                    <p class="text-muted mt-1 text-opacity-50">Detail absensi kehadiran pegawai</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route("absensi.edit", $data->id) }}" class="btn btn-soft-primary me-2"><i data-feather="edit-3" class="me-1"></i> Edit Absensi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <div class="card shadow rounded-sm">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>NIP</td>
                                <td>:</td>
                                <td>{{ $data->user->nip }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pegawai</td>
                                <td>:</td>
                                <td>{{ $data->user->nama }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{ $data->user->gender }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $data->user->email }}</td>
                            </tr>
                            <tr>
                                <td>No. HP</td>
                                <td>:</td>
                                <td>{{ $data->user->phone }}</td>
                            </tr>
                            <tr>
                                <td>Lokasi Kerja</td>
                                <td>:</td>
                                <td>{{ $data->cabang_nama }}</td>
                            </tr>
                            <tr>
                                <td>Shift</td>
                                <td>:</td>
                                <td>{{ $data->nama_shift }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan Shift</td>
                                <td>:</td>
                                <td>{{ $data->ket_shift." ".TampilJamMenit($data->hadir_shift)." - ".TampilJamMenit($data->pulang_shift) }}</td>
                            </tr>
                            <tr>
                                <td>In</td>
                                <td>:</td>
                                <td>{{ tanggalIndoWaktuLengkap($data->jam_hadir) }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan Hadir</td>
                                <td>:</td>
                                <td>{{ $data->ket_hadir }}</td>
                            </tr>
                            <tr>
                                <td>Out</td>
                                <td>:</td>
                                <td>@if ($data->jam_pulang == "") {{ "-" }} @else {{ tanggalIndoWaktuLengkap($data->jam_pulang) }} @endif</td>
                            </tr>
                            <tr>
                                <td>Keterangan Pulang</td>
                                <td>:</td>
                                <td>{{ $data->ket_pulang }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-5">
            <div class="card shadow rounded-sm">
                <div class="card-body p-2">
                    <h4 class="card-title my-3 ms-3">Lokasi Absen Hadir Pegawai</h4>
                    <div id="map1" class="map"></div>
                </div>
            </div>

            <div class="card shadow rounded-sm">
                <div class="card-body p-2">
                    <h4 class="card-title my-3 ms-3">Lokasi Absen Pulang Pegawai</h4>
                    <div id="map2" class="map"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn3JGAbQ9x5_umeWpD9wd3vAxaGK6kv5U&callback=initMap"></script>
    <script>
        var myMap1 = {
            lat: {{ $data->lat_hadir }},
            lng: {{ $data->long_hadir }}
        };
        var myMap2 = {
            lat: @if($data->lat_pulang == "") {{ "0" }} @else {{ $data->lat_pulang }} @endif,
            lng: @if($data->lat_pulang == "") {{ "0" }} @else {{ $data->long_pulang }} @endif
        };
        function initMap() {
            var map = new google.maps.Map(
                document.getElementById('map1'), {
                    zoom: 18,
                    center: myMap1
            });
            var marker = new google.maps.Marker({
                position: myMap1,
                map: map
            });
            var map2 = new google.maps.Map(
                document.getElementById('map2'), {
                    zoom: 18,
                    center: myMap2
                });
            var marker2 = new google.maps.Marker({
                position: myMap2,
                map: map2
            });
        }
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil','{{ \Session::get('success') }}','success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal','{{ \Session::get('error') }}','error')
        </script>
    @endif
@endpush
