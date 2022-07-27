@extends('layouts.mobile')

@section('title')Absen Pulang | Smartwork @endsection

@push('addon-style')
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>
<style>
    .main-content { overflow: inherit; }
    .child_i { position: absolute; top:-170px; width: 100%; display: block; }
</style>
@endpush

@section('content')
    @php
        $id = Auth::user();
    @endphp
    <section>
        <div class="ps-5 pe-4" style="background-color: #B0141C !important; height:250px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Lupa Absen Pulang</h2>
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

    <section class="parent">
        <div class="child_i">
            <div class="card rounded-sm m-2">
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
                    {{-- <hr> --}}
                    <div class="row mt-4">
                        <form method="post" action="{{ route('absen.update', $data->id) }}" id="myForm" class="px-3">
                            @method('PATCH')
                            @csrf
                            <div class="form-group mb-2">
                                <div class="col-12 pr-0 input-group mt-1">
                                    <label class="fw-light font-size-12 text-muted">Waktu Kepulangan <span class="text-danger">*</span></label>
                                    <div class="input-group-text"><i class="font-size-18 bx bx-calendar-alt"></i></div>
                                    <input type="datetime-local" id="jam_pulang" class="form-control rounded-5 d-none" name="jam_pulang" />
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-12 pr-0 input-group mt-1">
                                    <div class="input-group-text"><i class="font-size-18 bx bx-menu-alt-left"></i></div>
                                    <textarea onclick="getLocation()" id="keterangan" class="form-control rounded-5 d-none" name="deskripsi" rows="1" placeholder="Tulis keterangan absen pulang Anda"></textarea>
                                </div>
                            </div>
                            <input id="lokasix" class="form-control" type="hidden" name="lat_pulang">
                            <input id="lokasiy" class="form-control" type="hidden" name="long_pulang">
                            <button type="submit" id="btn" class="mt-2 btn btn-primary waves-effect btn-label waves-light w-100 rounded-md d-none py-2 rounded-sm"><i class="label-icon fa fa-clock"></i> Clock Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($is_radius != 0)
    <div style="padding-top:80px;" class="mx-2" onclick="getLocation();">
        <div class="alert rounded-sm text-center" role="alert" id='demo'>
            <i class="fa fa-spinner fa-spin font-size-22 text-success mb-3"></i>
            <h4 class="alert-heading">Verifikasi Lokasi...</h4>
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
        $(document).ready(function() {
            getLocation();
        });
        var demo    = document.getElementById("demo");
        var btn     = document.getElementById("btn");
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
            var latitude2  = {{ $cabang_lat }};
            var longitude2 = {{ $cabang_long }};
            var radius     = {{ $radius }};
            var distance   = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(latitude1,longitude1),
                            new google.maps.LatLng(latitude2.toFixed(6), longitude2.toFixed(7)));
            @if ($is_radius != 0)
                if (distance >= radius) {
                    $("#keterangan").addClass("d-none");
                    $("#jam_pulang").addClass("d-none");
                    $("#btn").addClass("d-none");
                    $("#demo").addClass("alert-danger");
                    demo.innerHTML = 'Maaf, Anda tidak berada didalam radius <strong>' + distance.toFixed(1) +
                        '</strong> meter. Mohon direfresh terlebih dulu';
                } else {
                    $("#demo").addClass("alert-success");
                    $("#demo").removeClass("d-none");
                    $("#btn").removeClass("d-none");
                    $("#keterangan").removeClass("d-none");
                    $("#jam_pulang").removeClass("d-none");
                    demo.innerHTML = 'Anda berada didalam radius <strong>' + distance.toFixed(1) +
                        '</strong> meter. </br>Silahkan klik tombol <strong>Clock Out</strong>';
                    $("#lokasix").val(latitude1);
                    $("#lokasiy").val(longitude1);
                }
            @else
                $("#demo").addClass("d-none");
                $('#btn').removeClass("d-none");
                $("#keterangan").removeClass("d-none");
                $("#jam_pulang").removeClass("d-none");
                $("#lokasix").val(latitude1);
                $("#lokasiy").val(longitude1);
            @endif
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
