@extends('layouts.mobile')

@section('title')
    Absen Pulang
@endsection

@push('addon-style')
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>
@endpush

@section('content')
    @php
    $id = Auth::user();
    $radius = 100;
    @endphp
    <section class="p-0 mb-3">
        <div class="ps-5 pe-4 pb-3 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div>
                    <a href="{{ route('absen.index') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Absen Pulang</h2>
                </div>
                <div class=''>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div class="mx-4" onclick="getLocation();">
        <div class="alert rounded-sm text-center" role="alert" id='demo'>
            <i class="fa fa-spinner fa-spin font-size-22 text-success mb-3"></i>
            <h4 class="alert-heading">Verifikasi Lokasi...</h4>
        </div>
    </div>

    <div class="text-center">
        <div class="card rounded-sm mx-4">
            <div class="card-body px-3 py-8">
                <h3 class="text-center font-weight-bolder mb-1">Lupa Absen Pulang</h3>
                <form method="post" action="{{ route('absen.update', $data->id) }}" id="myForm" class="px-3">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="my-date">Tanggal Pulang:</label>
                        <input type="datetime-local" id="my-date" class="form-control rounded-5" name="jam_pulang" />
                    </div>
                    <div class="form-group text-center">
                        <label for="my-textarea">Keterangan Absen Pulang:</label>
                        <textarea onclick="getLocation()" id="my-textarea" class="form-control rounded-5" name="deskripsi" rows="3"></textarea>
                    </div>
                    <input id="lokasix" class="form-control" type="hidden" name="lat_pulang">
                    <input id="lokasiy" class="form-control" type="hidden" name="long_pulang">
                    <button type="submit" id="btn" class="btn btn-primary rounded-sm w-100 py-3 mt-3 d-none">Absen
                        Pulang</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
    <script>
        var demo = document.getElementById("demo");
        var btn = document.getElementById("btn");
        var lokasix = document.getElementById("lokasix");
        var lokasiy = document.getElementById("lokasiy");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                demo.innerHTML = "Geolocation is not supported by this browser.";
                $("#btn").addClass("d-none");
            }
        }

        function showPosition(position) {
            var latitude1  = position.coords.latitude.toFixed(7);
            var longitude1 = position.coords.longitude.toFixed(7);
            var latitude2  = -8.617903;
            var longitude2 = 115.192535;
            var radius     = 100;
            var distance = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(latitude1,
                    longitude1),
                new google.maps.LatLng(latitude2.toFixed(6), longitude2.toFixed(7)));
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
                    '</strong> meter. </br>Silahkan klik tombol <strong>Absen</strong>';
                $("#lokasix").val(latitude1);
                $("#lokasiy").val(longitude1);
            }
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "User denied the request for Geolocation."
                    $("#btn").addClass("d-none");
                    break;
                case error.POSITION_UNAVAILABLE:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "Location information is unavailable."
                    $("#btn").addClass("d-none");
                    break;
                case error.TIMEOUT:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "The request to get user location timed out."
                    $("#btn").addClass("d-none");
                    break;
                case error.UNKNOWN_ERROR:
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = "An unknown error occurred."
                    $("#btn").addClass("d-none");
                    break;
            }
        }
    </script>
@endpush
