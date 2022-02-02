@extends('layouts.main')

@section('title')
    Profil Saya
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@section('content')
        <div class='mt-0'>
            <div class="row">
                <div class="col-xl-12">
                    <div class="profile-user"></div>
                </div>
            </div>

            <div class="row">
                <div class="profile-content">
                    <div class="row align-items-end">
                        <div class="col-sm">
                            <div class="d-flex align-items-end mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xxl me-3">
                                        <img src="{{ !$data->company_logo ? asset('backend-assets/images/no-image.png') : asset('storage/logo/' . Auth::user()->company_logo) }}"
                                            alt="" class="img-fluid rounded-circle img-cropped d-block img-thumbnail">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-16 mb-1">{{ $data->nama }} - ({{ $data->nip }})</h5>
                                        <p class="text-muted font-size-13 mb-2 pb-2">{{ !$data->company_name ? '-' : $data->company_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-3"></i><strong>Berhasil</strong> - {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body p-4">
                    <form action="{{ route('admin.save') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group mb-3">
                                    <label for="my-select">Nama Lengkap</label>
                                    <input class='form-control font-weight-bolder' type="text" name="nama" id=""
                                        value="{{ $data->nama }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-select">Nama Pengguna</label>
                                    <input class='form-control font-weight-bolder' type="text" name="username" id=""
                                        value="{{ $data->username }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-select">Email</label>
                                    <input class='form-control font-weight-bolder' type="text" name="email" id=""
                                        value="{{ $data->email }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-select">No. Telepon</label>
                                    <input class='form-control font-weight-bolder' type="text" name="phone" id=""
                                        value="{{ $data->phone }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group mb-3">
                                    <label for="my-select">Nama Perusahaan</label>
                                    <input class='form-control font-weight-bolder' type="text" name="company" id=""
                                        value="{{ $data->company }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-select">Alamat Perusahaan</label>
                                    <textarea id="my-textarea" class="form-control" name="alamat" rows="9"
                                        rows="8">{{ $data->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="px-3 py-4 rounded-lg" style="border-style: dashed;
                                  border-color: #008000;
                                  border-width: 0.5px;">
                                    <label class="font-weight-bolder">Logo Perusahaan</label><br>
                                    <small class="text-muted">*Upload logo perusahaan dengan format 1:1 dan ukuran
                                        minimal 720x720</small>
                                    <div class="py-5 rounded-lg">
                                        <input id="avatar" type="file" name="avatar" class="filepond" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 btn-lg mt-3" type="submit">
                            <i class="fas fa-hdd icon-md"></i>&nbsp; Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            $('.filepond--credits').addClass('d-none');
        });
    </script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
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
                url: "{{ route('upload.logo') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            labelIdle: '<span class="filepond--label-action font-size-12 text-success fw-bold text-decoration-none"><i class="fa fa-camera icon-md text-success"></i>&nbsp; Klik Disini Untuk Upload Foto</span> ',
            acceptedFileTypes: ['image/*'],
        });
    </script>
@endpush
