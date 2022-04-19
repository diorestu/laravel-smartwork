@extends('layouts.mobile')

@section('title')
    Detail Kegiatan
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@section('content')
    <section class="p-0 mb-3">
        <div class="ps-5 pe-4 pb-3 pt-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div>
                    <a href="{{ route('kegiatan.index') }}" class="text-white"><i class="fa fa-chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Detail Aktivitas</h2>
                </div>
                <div class='ms-4'>
                </div>
            </div>
        </div>
    </section>

    <div class="px-4 mb-2">
        {{-- {{ $data }} --}}
        <table>
            <tbody>
                <tr>
                    <th>Tanggal</th>
                    <td>:</td>
                    <td>{{ tanggalIndo($data->tanggal_kgt) }}</td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>:</td>
                    <td>{{ tampilJamMenit($data->jam_kgt) }}</td>
                </tr>
                <tr>
                    <th>Judul Kegiatan</th>
                    <td>:</td>
                    <td>{{ $data->title_kgt }}</td>
                </tr>
                <tr>
                    <th>Deskripsi Kegiatan</th>
                    <td>:</td>
                    <td>{{ $data->desc_kgt }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mb-3 mt-2 pb-0 rounded-sm px-3 pt-3 bg-white" style="border-style: dashed; border-width: 1px; border-color: green">
            <input id="avatar" type="file" name="avatar" class="filepond" />
        </div>
    </div>
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
        const inputElement = document.querySelector('input[id="avatar"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            allowImagePreview: true,
            imagePreviewMaxHeight: 300,
        });

        FilePond.setOptions({
            server: {
                url: "{{ route('upload-kegiatan') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            labelIdle: '<span class="filepond--label-action text-success text-decoration-none"><i class="fa fa-camera"></i> Upload Foto</span> ',
            acceptedFileTypes: ['image/*'],
        });
    </script>
@endpush
