@extends('layouts.mobile')

@section('title')
Tambah Kegiatan
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
                    <a href="{{ route('cuti.index') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white">Catat Aktivitas</h2>
                </div>
                <div class='ms-4'>
                </div>
            </div>
        </div>
    </section>

    <div class="px-4">
        <form action="{{ route('kegiatan.store') }}" method="post" id="myForm">
            @method('POST')
            @csrf
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Judul Kegiatan<span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <input id="my-input" class="form-control" type="text" name="title_kgt" required>
            </div>
            <div class="mb-3">
                <label for="my-input font-weight-bolder">Deskripsi Kegiatan <span class="text-danger font-weight-bold font-size-sm">*Wajib diisi </span></label>
                <textarea class="form-control" name="desc_kgt" id="" cols="10" rows="5" required></textarea>
            </div>
            <div class="mb-3
            pb-0 rounded-sm px-3 pt-3 bg-white" style="border-style: dashed; border-width: 1px; border-color: green">
                <input id="avatar" type="file" name="avatar" class="filepond" />
            </div>
            <button type="submit" class="btn w-100 btn-primary rounded text-white py-3">Catat Aktivitas</button>
        </form>

        <br>
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
                url: "{{ route('upload-hadir') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            labelIdle: '<span class="filepond--label-action text-success text-decoration-none"><i class="fa fa-camera icon-md text-success"></i>&nbsp; Unggah Foto</span> ',
            acceptedFileTypes: ['image/*'],
        });
    </script>





@endpush

