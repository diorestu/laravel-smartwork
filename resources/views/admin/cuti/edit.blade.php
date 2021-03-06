@extends('layouts.main')

@section('title')
    Ubah Data Cuti Pegawai | Smartwork App
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
                <li class="breadcrumb-item"><a href="javascript: void(0);">Kelola</a></li>
                <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Cuti Pegawai</a></li>
                <li class="breadcrumb-item"><a href="{{ route("cuti.rekap") }}">Rekap Cuti</a></li>
                <li class="breadcrumb-item active">Ubah Data Cuti</li>
            </ol>
            <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Ubah Data Cuti Pegawai</h4>
        </div>
    </div>
    <div class="page-content mt-0 pt-0">
        <div class="row">
            <div class="col-xl-12 col-lg-12 p-0">
                <form action="{{ route('cuti.update', $data->id_cuti) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Data Cuti Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="staff">Pegawai <span class="text-danger">*</span></label>
                                                <select required id="staff" class="form-select" name="id_staff">
                                                    @php
                                                        $q_staff = App\Models\User::where('id_admin', auth()->user()->id)->where('id','!=',auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_staff as $r_staff)
                                                    <option @if($r_staff->id==$data->id_user) {{ 'selected' }} @endif value='{{ $r_staff->id }}'>{{ $r_staff->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="cuti_keterangan" class="font-weight-bolder">Keterangan Cuti <span class="text-danger">*</span></label>
                                                <input required id="cuti_keterangan" class="form-control" type="text" name="cuti_keterangan" value="{{ $data->cuti_deskripsi }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="mb-4 form-group">
                                                <label for="cuti_awal">Tanggal Cuti <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                    <input type="text" class="form-control datepicker" id="cuti_awal" name="cuti_awal" value="{{ $data->cuti_awal }}">
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="cuti_total">Jumlah Hari Cuti <span class="text-danger">*</span></label>
                                                <select required id="cuti_total" class="form-select" name="cuti_total">
                                                    @for ($i=1;$i<=20;$i++)
                                                    <option @if($i==$data->cuti_total) {{ 'selected' }} @endif value='{{ $i }}'>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group mb-4">
                                                <label for="id_cuti_jenis">Jenis Cuti <span class="text-danger">*</span></label>
                                                <select required id="id_cuti_jenis" class="form-select" name="id_cuti_jenis">
                                                    @php
                                                        $q_jcuti = App\Models\CutiJenis::where('id_admin', auth()->user()->id)->get();
                                                    @endphp
                                                    @foreach ($q_jcuti as $r_jcuti)
                                                    <option @if($r_jcuti->id==$data->id_cuti_jenis) {{ 'selected' }} @endif value='{{ $r_jcuti->id }}'>{{ $r_jcuti->cuti_nama_jenis }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="cuti_status">Status Cuti <span class="text-danger">*</span></label>
                                                <select required id="cuti_status" class="form-select" name="cuti_status">
                                                    <option @if($data->cuti_status == "PENGAJUAN") {{ 'selected' }} @endif value='PENGAJUAN'>PENGAJUAN</option>
                                                    <option @if($data->cuti_status == "DITERIMA") {{ 'selected' }} @endif value='DITERIMA'>DITERIMA</option>
                                                    <option @if($data->cuti_status == "DITOLAK") {{ 'selected' }} @endif value='DITOLAK'>DITOLAK</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block w-100 btn-md mt-3" type="submit">
                                        <i class="fas fa-check icon-md"></i> &nbsp; Simpan Perubahan
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
        const elementStaff      = document.querySelector('#staff');
        const choicesStaff      = new Choices(elementStaff);
        const elementTotcuti    = document.querySelector('#cuti_total');
        const choicesTotcuti    = new Choices(elementTotcuti);
        const elementJCuti      = document.querySelector('#id_cuti_jenis');
        const choicesJCuti      = new Choices(elementJCuti);
        const elementCutiStatus = document.querySelector('#cuti_status');
        const choicesCutiStatus = new Choices(elementCutiStatus);
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
