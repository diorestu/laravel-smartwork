@extends('layouts.mobile-navbar')

@section('title')Absen Hadir | Smartwork @endsection

@push('addon-style')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<style>
    .no-border td { border: none; }
    .damas { background-color: #f2f2f2; }
    .map { height: 200px; }
</style>
@endpush

@section('content')
    @php $radius = 100; @endphp
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Info Kehadiran</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div id="mapWrapper">
        <div class="card m-2">
            <div class="card-body px-1 py-1">
                <div id="map1" class="map"></div>
            </div>
        </div>
    </div>

    <div id="absenForm">
        <div class="card m-2 rounded-sm">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-1">
                        <div class="d-flex">
                            <div class="col-6 px-1">
                                <span class="text-muted">Waktu Cek</span>
                                <br>
                                <span>{{ TampilJamMenit($data->jam_hadir) }}</span>
                            </div>
                            <div class="col-6 px-1">
                                <span class="text-muted">Tipe</span>
                                <br>
                                <span>Clock In</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-1">
                        <div class="d-flex">
                            <div class="col-6 px-1">
                                <span class="text-muted">Waktu Cek</span>
                                <br>
                                <span>{{ TampilJamMenit($data->jam_pulang) }}</span>
                            </div>
                            <div class="col-6 px-1">
                                <span class="text-muted">Tipe</span>
                                <br>
                                <span>Clock Out</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Shift</span>
                        <br>
                        <span>{{ tanggalIndo($data->jam_hadir) }}</span>
                    </li>
                    <li class="list-group-item px-1">
                        <div class="d-flex">
                            <div class="col-6 px-1">
                                <span class="text-muted">Tanggal Kehadiran</span>
                                <br>
                                <span>{{ tanggalIndo($data->jam_hadir) }}</span>
                            </div>
                            <div class="col-6 px-1">
                                <span class="text-muted">Tanggal Kepulangan</span>
                                <br>
                                <span>{{ tanggalIndo($data->jam_pulang) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-1">
                        <div class="d-flex">
                            <div class="col-6 px-1">
                                <span class="text-muted">Kordinat Kehadiran</span>
                                <br>
                                <span>1234, 1234</span>
                            </div>
                            <div class="col-6 px-1">
                                <span class="text-muted">Kordinat Kepulangan</span>
                                <br>
                                <span>1234, 1234</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-1">
                        <div class="d-flex">
                            <div class="col-6 px-1">
                                <span class="text-start text-muted">Foto Kehadiran</span>
                                <input id="hadir" name="hadir" class="mt-1 mb-0" type="file" />
                            </div>
                            <div class="col-6 px-1">
                                <span class="text-start text-muted">Foto Kepulangan</span>
                                <input id="pulang" name="pulang" class="mt-1 mb-0" type="file" />
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn3JGAbQ9x5_umeWpD9wd3vAxaGK6kv5U&callback=initMap"></script>
    <script>
        $(document).ready(function() {
            $('.filepond--credits').addClass('d-none');
        });
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[id="hadir"]');
        const inputElement2 = document.querySelector('input[id="pulang"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            allowImagePreview: true,
            imagePreviewMaxHeight: 300,
        });
        const pond2 = FilePond.create(inputElement2, {
            allowImagePreview: true,
            imagePreviewMaxHeight: 300,
        });

        FilePond.setOptions({
            server: {
                url: "{{ route('upload-hadir') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            labelIdle: '<span class="filepond--label-action text-success text-decoration-none"><i class="fa fa-camera"></i> Upload Foto</span> ',
            acceptedFileTypes: ['image/*'],
        });
        var myMap1 = {
            lat: {{ $data->lat_hadir }},
            lng: {{ $data->long_hadir }}
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
@endpush
