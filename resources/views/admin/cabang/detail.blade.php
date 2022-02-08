@extends('layouts.main')

@section('title')
    Detail Lokasi Kerja
@endsection

@push('addon-style')
    <style>
        .map { height: 300px; display: block; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('cabang.index') }}">Lokasi Kerja</a></li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Lokasi Kerja</h4>
                    <p class="text-muted mt-1 text-opacity-50">Detail data lokasi kerja</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('cabang.edit', $data->id) }}" class="btn btn-soft-primary me-2"><i data-feather="edit-3" class="me-1"></i> Edit Lokasi Kerja</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <div class="card shadow rounded-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->cabang_nama }}</h5>
                    <p class="card-text">{{ $data->cabang_alamat }}</p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>No. Telp</td>
                                <td>:</td>
                                <td>{{ $data->cabang_phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $data->cabang_email }}</td>
                            </tr>
                            <tr>
                                <td>UMK Berlaku</td>
                                <td>:</td>
                                <td>{{ rupiah($data->cabang_umk) }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Terdaftar</td>
                                <td>:</td>
                                <td>{{ tanggalIndo($data->created_at) }}</td>
                            </tr>
                            <tr>
                                <td>Kordinat Latitude</td>
                                <td>:</td>
                                <td>{{ $data->cabang_lat }}</td>
                            </tr>
                            <tr>
                                <td>Kordinat Longitude</td>
                                <td>:</td>
                                <td>{{ $data->cabang_long }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-5">
            <div class="card shadow rounded-sm">
                <div class="card-body p-2">
                    <h4 class="card-title my-3 ms-3">Lokasi Kerja di Peta</h4>
                    <div id="map1" class="map"></div>
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15779.085611627637!2d115.1924309!3d-8.6179322!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa919bea69199a723!2sApik%20-%20Asta%20Pijar%20Kreasi%20Teknologi!5e0!3m2!1sid!2sid!4v1641786229860!5m2!1sid!2sid"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn3JGAbQ9x5_umeWpD9wd3vAxaGK6kv5U&callback=initMap"></script>
    <script>
        var myMap1 = {
            lat: {{ $data->cabang_lat }},
            lng: {{ $data->cabang_long }}
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
