@extends('layouts.main')

@section('title')
    Ubah Data Pegawai
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/croppie/croppie.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-header { background: rgb(219,66,66); background: linear-gradient(90deg, rgba(219,66,66,1) 0%, rgba(126,7,30,1) 100%); }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                <li class="breadcrumb-item active">Pegawai</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Pegawai</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab"
                                    aria-selected="true">Data Diri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" data-bs-toggle="tab" href="#akun" role="tab"
                                    aria-selected="false">Data Akun</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" data-bs-toggle="tab" href="#asuransi" role="tab"
                                    aria-selected="false">Data Asuransi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" data-bs-toggle="tab" href="#tunjangan" role="tab"
                                    aria-selected="false">Data Tunjangan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('pegawai.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <!-- DATA DIRI -->
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Data Diri Pegawai</h5>
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
                                                <label for="nip" class="font-weight-bolder">Nomor Induk Pegawai</label>
                                                <input class='form-control' type="text" name="nip" id="nip" value="{{ $data->nip }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tanggal_mulaiKerja">Tanggal Mulai Kerja</label>
                                                <input id="tanggal_mulaiKerja" class="form-control" type="date" name="tanggal_mulaiKerja" value="{{ $data->tanggal_mulaiKerja }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="phone" class="font-weight-bolder">No. HP</label>
                                                <input class='form-control' type="text" name="phone" id="phone" value="{{ $data->phone }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tanggungan" class="font-weight-bolder">Status Perkawinan</label>
                                                <select id="tanggungan" class="form-select" name="tanggungan">
                                                    @php
                                                        $q_sk = App\Models\StatusKawin::where('id_admin', auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_sk as $r_sk)
                                                    <option @if ($data->tanggungan == $r_sk->id) selected @endif value='{{ $r_sk->id }}'>{{ $r_sk->status_kawin }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="nama" class="font-weight-bolder">Nama Lengkap</label>
                                                <input class='form-control' type="text" name="nama" id="nama" value="{{ $data->nama }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="gender" class="font-weight-bolder">Jenis Kelamin</label>
                                                <select id="gender" class="form-select" name="gender">
                                                    <option @if ($data->gender == "Pria") selected @endif value='Pria'>Pria</option>
                                                    <option @if ($data->gender == "Wanita") selected @endif value='Wanita'>Wanita</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="email" class="font-weight-bolder">Email</label>
                                                <input class='form-control' type="text" name="email" id="email" value="{{ $data->email }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="alamat" class="font-weight-bolder">Alamat</label>
                                                <textarea id="alamat" class="form-control" name="alamat" rows="3">{{ $data->alamat }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-hdd icon-md"></i> &nbsp; Simpan Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- DATA AKUN -->
                        <div class="tab-pane" id="akun" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-white card-title mb-0">Data Akun Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="username" class="font-weight-bolder">Username</label>
                                                <input class='form-control' type="text" name="username" id="" value="{{ $data->username }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="divisi" class="font-weight-bolder">Divisi</label>
                                                <select id="divisi" class="form-select" name="id_divisi">
                                                    @php
                                                        $q_div = App\Models\Divisi::where('id_admin', auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_div as $r_div)
                                                    <option @if ($data->id_divisi == $r_div->div_id) selected @endif value='{{ $r_div->div_id }}'>{{ $r_div->div_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="cabang" class="font-weight-bolder">Lokasi Absensi Kantor</label>
                                                <select id="cabang" class="form-select" name="id_cabang">
                                                    @php $query = App\Models\Cabang::where('id_admin', auth()->user()->id)->get(); @endphp
                                                    @foreach ($query as $r)
                                                    <option @if ($data->id_cabang == $r->id) selected @endif value='{{ $r->id }}'>{{ $r->cabang_nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="no_rek" class="font-weight-bolder">Nomor Rekening Pegawai</label>
                                                <input class='form-control' type="text" name="no_rek" id="no_rek" value="{{ $data->no_rek }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="status" class="font-weight-bolder">Status Akun</label>
                                                <select id="status" class="form-select" name="status">
                                                    <option @if ($data->status == "active") selected @endif value='active'>Aktif</option>
                                                    <option @if ($data->status == "not active") selected @endif value='not active'>Tidak Aktif</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="jabatan" class="font-weight-bolder">Jabatan</label>
                                                <select id="jabatan" class="form-select" name="id_jabatan">
                                                    @php $q_jab = App\Models\Jabatan::where('id_admin', auth()->user()->id)->get(); @endphp
                                                    @foreach ($q_jab as $r_jab)
                                                    <option @if ($data->id_jabatan == $r_jab->jabatan_id) selected @endif value='{{ $r_jab->jabatan_id }}'>{{ $r_jab->jabatan_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="company" class="font-weight-bolder">Company</label>
                                                <input class='form-control' type="text" name="company" id="company" value="{{ $data->company }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="sertifikasi" class="font-weight-bolder">Sertifikasi</label>
                                                <select id="sertifikasi" class="form-select" name="id_sertifikasi">
                                                    @php
                                                        $q_sertif = App\Models\Sertifikasi::where('id_admin', auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_sertif as $r_sertif)
                                                    <option @if ($data->id_sertifikasi == $r_sertif->id) selected @endif value='{{ $r_sertif->id }}'>{{ $r_sertif->sertifikasi_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-hdd icon-md"></i> &nbsp; Simpan Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- DATA ASURANSI -->
                        <div class="tab-pane" id="asuransi" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-white card-title mb-0">Data Asuransi Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="bpjs_kes" class="font-weight-bolder">Asuransi Kesehatan</label>
                                                <select id="bpjs_kes" class="form-select" name="status_nakes">
                                                    <option @if ($dataAsuransi != '' && $dataAsuransi->status_nakes == 'y') selected @endif value='y'>Aktif</option>
                                                    <option @if ($dataAsuransi != '' && $dataAsuransi->status_nakes == 'n') selected @endif value='n'>Tidak Aktif</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="bpjs_naker" class="font-weight-bolder">Asuransi Ketenagakerjaan</label>
                                                <select id="bpjs_naker" class="form-select" name="status_naker">
                                                    <option @if ($dataAsuransi != '' && $dataAsuransi->status_naker == 'y') selected @endif value='y'>Aktif</option>
                                                    <option @if ($dataAsuransi != '' && $dataAsuransi->status_naker == 'n') selected @endif value='n'>Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="nomor_nakes" class="font-weight-bolder">Nomor Asuransi Kesehatan</label>
                                                <input class='form-control' type="text" name="nomor_nakes" id="nomor_nakes" value="@if ($dataAsuransi != ''){{ $dataAsuransi->nomor_nakes }}@else{{ 0 }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="nomor_naker" class="font-weight-bolder">Nomor Asuransi Ketenagakerjaan</label>
                                                <input class='form-control' type="text" name="nomor_naker" id="nomor_naker" value="@if ($dataAsuransi != ''){{ $dataAsuransi->nomor_naker }}@else{{ 0 }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="pot_nakes" class="font-weight-bolder">Potongan Asuransi Kesehatan</label>
                                                <input class='form-control' type="number" name="pot_nakes" id="pot_nakes" value="@if ($dataAsuransi != ''){{ $dataAsuransi->pot_nakes }}@else{{ 0 }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="pot_naker" class="font-weight-bolder">Potongan Asuransi Ketenagakerjaan</label>
                                                <input class='form-control' type="number" name="pot_naker" id="pot_naker" value="@if ($dataAsuransi != ''){{ $dataAsuransi->pot_naker }}@else{{ 0 }}@endif">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-hdd icon-md"></i> &nbsp; Simpan Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- DATA TUNJANGAN -->
                        <div class="tab-pane" id="tunjangan" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-white card-title mb-0">Data Tunjangan Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="tj_jabatan" class="font-weight-bolder">Tunjangan Jabatan</label>
                                                <input class='form-control' type="text" name="tj_jabatan" id="tj_jabatan" value="@if ($data->id_jabatan != ''){{ $data->jabatan->jabatan_tunjangan }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tj_sertifikasi" class="font-weight-bolder">Tunjangan Sertifikasi</label>
                                                <input class='form-control' type="text" name="tj_sertifikasi" id="tj_sertifikasi" value="@if ($data->id_sertifikasi != ''){{ $data->sertifikasi->sertifikasi_tunjangan }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tj_masaKerja" class="font-weight-bolder">Tunjangan Masa Kerja</label>
                                                <input class='form-control' type="text" name="tj_masaKerja" id="tj_masaKerja" value="@if ($data->id_masaKerja != ''){{ $data->masa_kerja->masa_kerja_tunjangan }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tj_statusKawin" class="font-weight-bolder">Tunjangan Status Kawin</label>
                                                <input class='form-control' type="text" name="tj_statusKawin" id="tj_statusKawin" value="@if ($data->tanggungan != ''){{ $data->status_kawin->status_kawin_tunjangan }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="tj_makan" class="font-weight-bolder">Tunjangan Makan</label>
                                                <input class='form-control' type="text" name="tj_makan" id="tj_makan" value="@if ($dataTunjangan != ''){{ $dataTunjangan->tj_makan }}@else{{ 0 }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tj_transport" class="font-weight-bolder">Tunjangan Transport</label>
                                                <input class='form-control' type="text" name="tj_transport" id="tj_transport" value="@if ($dataTunjangan != ''){{ $dataTunjangan->tj_transport }}@else{{ 0 }}@endif">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="tj_kosmetik" class="font-weight-bolder">Tunjangan Kosmetik</label>
                                                <input class='form-control' type="text" name="tj_kosmetik" id="tj_kosmetik" value="@if ($dataTunjangan != ''){{ $dataTunjangan->tj_kosmetik }}@else{{ 0 }}@endif">
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="tj_lain" class="font-weight-bolder">Tunjangan Lainnya</label>
                                                <input class='form-control' type="text" name="tj_lain" id="tj_lain" value="@if ($dataTunjangan != ''){{ $dataTunjangan->tj_lain }}@else{{ 0 }}@endif">
                                            </div>
                                        </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-hdd icon-md"></i> &nbsp; Simpan Profil
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
    {{-- <script src="{{ asset('backend-assets/js/pages/form-advanced.init.js') }}"></script> --}}
    <script src="{{ asset('backend-assets/libs/croppie/croppie.js') }}"></script>
    <script>
        const element = document.querySelector('#tanggungan');
        const choices = new Choices(element);
        const element2 = document.querySelector('#cabang');
        const choices2 = new Choices(element2);
        const element3 = document.querySelector('#gender');
        const choices3 = new Choices(element3);
        const element4 = document.querySelector('#status');
        const choices4 = new Choices(element4);
        const element5 = document.querySelector('#bpjs_kes');
        const choices5 = new Choices(element5);
        const element6 = document.querySelector('#divisi');
        const choice6  = new Choices(element6);
        const element7 = document.querySelector('#jabatan');
        const choice7  = new Choices(element7);
        const element8 = document.querySelector('#sertifikasi');
        const choice8  = new Choices(element8);

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
@endpush
