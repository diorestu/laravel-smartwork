@extends('layouts.main')

@section('title')
    Profil Saya | Smartwork App
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/croppie/croppie.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-header { background:#B0141C !important; }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil Admin</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Profil Admin</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('admin.update') }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="tab-content">
                        <!-- DATA DIRI -->
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0"><i class="mdi mdi-account-circle"></i> Role Pengguna : {{ $data->roles }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div id="uploaded_image">
                                                @if ($data->company_logo == "")
                                                    <img src="{{ asset('backend-assets/images/no-staff.jpg') }}" class="d-block w-100" />
                                                @else
                                                    <img src="{{ asset('storage/uploads/'. $data->company_logo) }}" class="d-block w-100" />
                                                @endif
                                            </div>
                                            <input type="file" class="inputfile inputfile-1" name="image" id="upload_image" accept="image/*" />
                                            <label for="upload_image"><i class="fas fa-camera"></i>&nbsp; Ganti Foto Profil</label>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="username" class="font-weight-bolder">Username <span class="text-danger">*</span></label>
                                                <input required class='form-control' type="text" name="username" id="" value="{{ $data->username }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="email" class="font-weight-bolder">Email <span class="text-danger">*</span></label>
                                                <input required class='form-control' type="text" name="email" id="email" value="{{ $data->email }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="phone" class="font-weight-bolder">No. HP <span class="text-danger">*</span></label>
                                                <input required class='form-control' type="text" name="phone" id="phone" value="{{ $data->phone }}">
                                            </div>

                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="nama" class="font-weight-bolder">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input required class='form-control' type="text" name="nama" id="nama" value="{{ $data->nama }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="gender" class="font-weight-bolder">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <select required id="gender" class="form-select" name="gender">
                                                    <option @if ($data->gender == "Pria") selected @endif value='Pria'>Pria</option>
                                                    <option @if ($data->gender == "Wanita") selected @endif value='Wanita'>Wanita</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="alamat" class="font-weight-bolder">Alamat</label>
                                                <textarea id="alamat" class="form-control" name="alamat" rows="3">{{ $data->alamat }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-check-circle icon-md"></i>&nbsp; Update Profil Saya
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="uploadimageModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 center-block text-center">
            <div class="center-block" id="image_demo" style="width:100%; margin-top:30px"></div>
          </div>
          <div class="col-md-12" style="padding-top:30px;">
            <button class="btn btn-block btn-success crop_image">Crop & Upload Image</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/croppie/croppie.js') }}"></script>
    <script>
        // const element = document.querySelector('#tanggungan');
        // const choices = new Choices(element);
        $(document).ready(function() {
            image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 300,
                height: 300,
                type:'square' //circle
            },
            boundary: {
                width: 450,
                height: 450
            }
            });
            $('#upload_image').on('change', function() {
                var reader = new FileReader();
                var base64data = reader.result;
                reader.onload = function(event) {
                    image_crop.croppie('bind', {
                    url: event.target.result
                    }).then(function() {
                    console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#uploadimageModal').modal('show');
            });
            $('.crop_image').click(function(event) {
                image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response) {
                    var url = '{{ route('pegawai.uploadImage') }}';
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        url: url,
                        type: "POST",
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'image': response, 'id': {{ $data->id }} },
                        success: function(data) {
                            $('#uploadimageModal').modal('hide');
                            $('#uploaded_image').html(data);
                        }
                    });
                })
            });
        });
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

