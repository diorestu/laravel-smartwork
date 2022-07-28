@extends('layouts.mobile')

@section('title')Detail Aktivitas | Smartwork @endsection

@push('addon-style')
<link href="{{ asset("backend-assets/libs/glightbox/css/glightbox.min.css") }}" rel="stylesheet">
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<style>
    .no-border td { border: none; }
    .filepond--label-action { color: #cc2b4e !important; }
    .filepond--panel-root { background-color: #f2f2f2; }
    body[data-layout-mode=dark] .filepond--panel-root { background-color: #30373f !important }
</style>
@endpush

@section('content')
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Detail Aktivitas</h2>
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
    <div>
        <div class="card m-2 rounded-sm">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-2">
                        <span class="text-muted">Judul Aktivitas</span>
                        <br>
                        <span>{{ $data->judul_aktivitas }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Deskripsi</span>
                        <br>
                        <span>{{ $data->aktivitas }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Tanggal</span>
                        <br>
                        <span>{{ tanggalIndo($data->created_at) }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Waktu Aktivitas</span>
                        <br>
                        <span>{{ TampilJamMenit($data->jam_aktivitas) }}</span>
                    </li>
                    <li class="list-group-item px-2">
                        <span class="text-muted">Diinput pada</span>
                        <br>
                        <span>{{ tanggalIndoWaktuLengkap($data->created_at) }}</span>
                    </li>
                    <li class="list-group-item px-1">
                        <span class="text-start text-muted">Foto Aktivitas</span>
                        <div class="row">
                            @forelse($data_image as $item_image)
                            <div class="col-4">
                                <div class="mt-1">
                                    <a href="{{ asset('storage/kegiatan/'.$item_image->images) }}" class="image-popup-desc" data-title="Project 01" data-description="Lorem ipsum dolor sit amet, consectetuer adipiscing elit">
                                        <img src="{{ asset('storage/kegiatan/'.$item_image->images) }}" class="img-fluid rounded-sm" alt="work-thumbnail">
                                    </a>
                                </div>
                            </div>
                            @empty
                            {{ "-" }}
                            @endforelse
                        </div>
                    </li>
                    <li class="list-group-item px-1">
                        <span class="text-start text-muted">Upload Foto Aktivitas</span>
                        <div class="mt-2 rounded" style="border-style: dashed; border-width: 1px; border-color: red">
                            <input id="avatar" type="file" name="avatar" class="filepond bg-light text-danger mb-0 mt-0" />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
<script src="{{ asset('backend-assets/libs/glightbox/js/glightbox.min.js') }}"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    $(document).ready(function() {
        $('.filepond--credits').addClass('d-none');

        var lightbox = GLightbox({ selector: ".image-popup", title: !1 }),
        lightboxDesc = GLightbox({ selector: ".image-popup-desc" });

    });
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    const inputElement = document.querySelector('input[id="avatar"]');
    const pond = FilePond.create(inputElement, {
        allowImagePreview: true,
        imagePreviewMaxHeight: 300,
    });
    FilePond.setOptions({
        server: {
            url: "{{ route('upload-kegiatan', ".$data->id.") }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        labelIdle: '<span class="filepond--label-action text-success text-decoration-none"><i class="fa fa-camera"></i> Upload Foto</span> ',
        acceptedFileTypes: ['image/*'],
    });
</script>
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
    </script>
@endif
@endpush
