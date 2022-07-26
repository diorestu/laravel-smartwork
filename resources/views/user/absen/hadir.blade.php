@extends('layouts.mobile-navbar')

@section('title')Absen Hadir | Smartwork @endsection

@push('addon-style')
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>
@endpush

@section('content')
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important; height:200px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Live Attendance</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
            <div class="text-center mt-3">
                <h2 id='span' class="text-center text-white fw-light mb-0 display-4"></h2>
                <span class="text-white mt-0">{{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</span>
            </div>
        </div>
    </section>
    <main class="px-4 parent pb-0 mt-3">
        <div class="child card rounded-md mb-0 px-0">
            <div class="card-body p-2 pt-3">
                <div class="text-center">
                    @if (!$shift || $shift == null)
                        <b class="fw-light font-size-14 text-muted">Tidak ada shift</b><br>
                        <b class="fw-bold font-size-20">00:00 - 00:00</b><br>
                    @else
                        <b class="fw-light font-size-14 text-muted">{{ $shift->shift->ket_shift == 'Libur' ? 'Libur' : 'Shift ' . $shift->shift->ket_shift }}
                            - {{ tanggalIndo($shift->tanggal_shift) }}</b><br>
                        <b class="fw-bold font-size-20">{{ tampilJamMenit($shift->shift->hadir_shift) }} -
                            {{ tampilJamMenit($shift->shift->pulang_shift) }}</b><br>
                    @endif
                </div>
                <div class="row mt-4">
                    <form method="post" action="{{ route('absen.store') }}" id="myForm" class="px-3 my-1">
                        @method('post')
                        @csrf
                        <input id="lokasix" class="form-control" type="hidden" name="lat_hadir">
                        <input id="lokasiy" class="form-control" type="hidden" name="long_hadir">
                        <button type="submit" id="btn" class="btn btn-primary waves-effect btn-label waves-light w-100 rounded-md d-none py-2"><i class="label-icon fa fa-clock"></i> Clock In</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @if ($is_radius != 0)
    <div class="mx-4" style="margin-top: -35px;" onclick="getLocation();">
        <div class="alert rounded-sm text-center" role="alert" id='demo'>
            <i class="fa fa-spinner fa-spin font-size-22 text-success mb-3"></i>
            <h4 class="alert-heading">Memverifikasi lokasi Anda...</h4>
        </div>
    </div>
    @endif
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
    <script>
        // timer
        var span = document.getElementById('span');
        function time() {
            var d = new Date();
            var s = d.getSeconds();
            var m = d.getMinutes();
            var h = d.getHours();
            span.textContent =
                ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
        }
        // geolocation
        $(document).ready(function() {
            getLocation();
            setInterval(time, 1000);
        });
        var demo    = document.getElementById("demo");
        var btn     = document.getElementById("btn");
        var lokasix = document.getElementById("lokasix");
        var lokasiy = document.getElementById("lokasiy");
        var form    = document.getElementById("absenForm");
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
                $('#absenForm').removeClass("d-none");
            } else {
                demo.innerHTML = "Geolocation is not supported by this browser.";
                $('#btn').addClass("d-none");
                $('#filepond-input').addClass("d-none");

            }
        }
        function showPosition(position) {
            var latitude1   = position.coords.latitude.toFixed(7);
            var longitude1  = position.coords.longitude.toFixed(7);
            var latitude2   = {{ $cabang_lat }};
            var longitude2  = {{ $cabang_long }};
            var radius      = {{ $radius }};
            var distance    = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(latitude1,longitude1),
                            new google.maps.LatLng(latitude2.toFixed(6), longitude2.toFixed(7)));
            @if ($is_radius != 0)
                if (distance >= radius) {
                    $("#btn").addClass("d-none");
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = 'Maaf, Anda berada didalam radius <strong>' + distance.toFixed(1) +
                        '</strong> meter. Mohon direfresh terlebih dulu';
                } else {
                    $("#demo").addClass("alert-success");
                    $("#demo").removeClass("d-none");
                    $("#btn").removeClass("d-none");
                    demo.innerHTML = 'Anda berada didalam radius <strong>' + distance.toFixed(1) +
                        '</strong> meter. </br>Silahkan klik tombol <strong>Clock In</strong>';
                    $("#lokasix").val(latitude1);
                    $("#lokasiy").val(longitude1);
                }
            @else
                $("#demo").addClass("d-none");
                $('#btn').removeClass("d-none");
                $("#lokasix").val(latitude1);
                $("#lokasiy").val(longitude1);
            @endif
        }
        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML =
                        "Mohon Aktifkan <b>Layanan Lokasi Anda</b> <br> dan <b>Berikan Akses Lokasi</b> Melalui Pengaturan!"
                    $('#filepond-input').addClass("d-none");
                    $("#btn").addClass("d-none");
                    break;
                case error.POSITION_UNAVAILABLE:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "Lokasi Tidak Diketahui. Mohon Periksa Kembali Koneksi Data Anda"
                    $('#filepond-input').addClass("d-none");
                    $("#btn").addClass("d-none");
                    break;
                case error.TIMEOUT:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "RTO: Periksa Koneksi Data Andaa"
                    $('#filepond-input').addClass("d-none");
                    $("#btn").addClass("d-none");
                    break;
                case error.UNKNOWN_ERROR:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "Mohon Ulangi Kembali Proses Absensi."
                    $('#filepond-input').addClass("d-none");
                    $("#btn").addClass("d-none");
                    break;
            }
        }
    </script>
@endpush
