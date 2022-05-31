@extends('layouts.main')

@section('title')
    Tambah Data Absensi Pegawai | Smartwork App
@endsection

@push('addon-style')
    <style>
        .card-header { background:#B0141C !important; }
    </style>
@endpush

@section('content')
<div class="main-content mx-0">
    <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
        <div class="mb-3">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Manajemen</a></li>
                <li class="breadcrumb-item"><a href="{{ route("absensi.index") }}">Absensi Pegawai</a></li>
                <li class="breadcrumb-item active">Tambah Absensi Pegawai</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Tambah Absensi Pegawai</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('absensi.store') }}" method="post" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Tambah Absensi Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <label for="staff">Pegawai <span class="text-danger">*</span></label>
                                                <select required id="staff" class="form-select" name="id_staff">
                                                    @php
                                                        $q_staff = App\Models\User::where('id_admin', auth()->user()->id)->where('id','!=',auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_staff as $r_staff)
                                                    <option value='{{ $r_staff->id }}'>{{ $r_staff->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label for="tgl_hadir">Tanggal Absen Datang <span class="text-danger">*</span></label>
                                                <input required id="tgl_hadir" class="form-control datepicker" type="text" name="tgl_hadir" value="">
                                            </div>
                                            <div class="mb-4">
                                                <label for="jam_hadir">Waktu Absen Datang <span class="text-danger">*</span></label>
                                                <input required id="jam_hadir" class="form-control" type="time" name="jam_hadir" value="">
                                            </div>
                                            <div class="mb-4">
                                                <label for="ket_hadir">Keterangan Absen Datang <span class="text-danger">*</span></label>
                                                <input required id="ket_hadir" class="form-control" type="text" name="ket_hadir" value="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label for="tgl_pulang">Tanggal Absen Pulang</label>
                                                <input id="tgl_pulang" class="form-control datepicker" type="text" name="tgl_pulang" value="">
                                            </div>
                                            <div class="mb-4">
                                                <label for="jam_pulang">Waktu Absen Pulang</label>
                                                <input id="jam_pulang" class="form-control" type="time" name="jam_pulang" value="">
                                            </div>
                                            <div class="mb-4">
                                                <label for="ket_pulang">Keterangan Absen Pulang</label>
                                                <input id="ket_pulang" class="form-control" type="text" name="ket_pulang" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-plus icon-md"></i> &nbsp; Buat Absensi Baru
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
@endsection

@push('addon-script')
    <script>
        const elementStaff = document.querySelector('#staff');
        const choices = new Choices(elementStaff);
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
