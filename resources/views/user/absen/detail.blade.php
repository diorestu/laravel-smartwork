@extends('layouts.mobile')

@section('title')
    Absen Hadir
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@section('content')
    @php
    $radius = 100;
    @endphp
    <section class="p-0 mb-3">
        <div class="ps-5 pe-4 pb-3 pt-3" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div>
                    <a href="{{ route('absen.index') }}" class="text-white">
                        <i class="fa fa-chevron-left font-size-20"></i>
                    </a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Info Absensi</h2>
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
    <div class="text-center" id="absenForm">
        <div class="card mx-4 rounded-sm">
            <div class="card-body px-2 py-4">
                <h3 class="text-center font-weight-bolder mb-1">Absensi Saya</h3>
                <h2 id='span' class="text-center fw-bold mb-2"></h2>
                <div class="mb-3 px-4 row">
                    <div class="col-6">
                        <div class="bg-primary rounded-lg p-3"><span class="text-white">{{ tanggalIndoWaktuLengkap($data->jam_hadir) }}</span></div>
                    </div>
                    <div class="col-6">
                        <div class="bg-primary rounded-lg p-3"><span class="text-white">{{ tanggalIndoWaktuLengkap($data->jam_pulang) }}</span></div>
                    </div>
                </div>
                <div class="px-4">
                    <span class="fw-semibold">Foto Absen Hadir</span>
                    <input id="hadir" name="hadir" type="file" />
                </div>
                <div class="px-4">
                    <span class="fw-semibold">Foto Absen Pulang</span>
                    <input id="pulang" name="pulang" type="file" />
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        $(document).ready(function() {
            $('.filepond--credits').addClass('d-none');
        });
    </script>
    <script>
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
    </script>
@endpush
