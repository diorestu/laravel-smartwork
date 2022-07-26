@extends('layouts.mobile')

@section('title')Detail Pengajuan | Smartwork @endsection

@push('addon-style')
@endpush

@section('content')
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Detail Pengajuan</h2>
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
    <section class="p-2 m-0">
        <div class="card mb-0">
            @if ($data->status == "ditolak")
            <div class="card-header bg-danger py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-block-helper me-2 font-size-20"></i><h6 class="my-0 text-white">PERUBAHAN JADWAL DITOLAK</h6>
            </div>
            @elseif($data->status == "disetujui")
            <div class="card-header bg-success py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-check-circle me-2 font-size-20"></i><h6 class="my-0 text-white">PERUBAHAN JADWAL DISETUJUI</h6>
            </div>
            @else
            <div class="card-header bg-primary py-1 px-2 d-flex align-items-center">
                <i class="text-white mdi mdi-cached me-2 font-size-20"></i><h6 class="my-0 text-white">PROSES PENGAJUAN</h6>
            </div>
            @endif
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text text-muted mb-1">{{ $data->user->cabang->cabang_nama }}</p>
                        <h5 class="card-title mb-1">{{ $data->user->nama }}</h5>
                        <p class="fw-light card-text text-muted">{{ $data->user->jabatan->jabatan_title }}</p>
                    </div>
                    <div>
                        <img src="{{ $data->user->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $data->user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card mx-2 rounded mb-3">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Tanggal Perubahan</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ tanggalIndo($data->tgl_shift) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Jadwal Kerja</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->shift->ket_shift }} : {{ TampilJamMenit($data->shift->hadir_shift) }} - {{ TampilJamMenit($data->shift->pulang_shift) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Menjadi</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->shift_baru->ket_shift }} : {{ TampilJamMenit($data->shift_baru->hadir_shift) }} - {{ TampilJamMenit($data->shift_baru->pulang_shift) }}</span>
                                <span class="mx-2 badge bg-success">Jadwal Baru</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Deskripsi</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ $data->keterangan }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Diajukan Pada</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ tanggalIndo($data->created_at) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Status Pengajuan</span>
                            </div>
                            <div class="col-8 px-1">
                                @if ($data->status == "ditolak")
                                    <p class="fw-bold font-size-12 text-danger mb-1 text-capitalize">{{ $data->status }}</p>
                                @elseif($data->status == "disetujui")
                                    <p class="fw-bold font-size-12 text-success mb-1 text-capitalize">{{ $data->status }}</p>
                                @else
                                    <p class="fw-bold font-size-12 text-primary mb-1 text-capitalize">{{ $data->status }}</p>
                                @endif
                            </div>
                        </div>
                    </li>
                    @if ($data->approved_date != null)
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Diproses pada</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ tanggalIndo($data->approved_date) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-2">
                        <div class="d-flex">
                            <div class="col-4 px-1">
                                <span class="fw-light font-size-12 text-muted">Diproses Oleh</span>
                            </div>
                            <div class="col-8 px-1">
                                <span>{{ namaUser($data->approved_by) }}</span>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        @if ($data->approved_date == null)
        <div class="card mx-2 mt-0 mb-3">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <form action="{{ route('schedule.destroy', $data->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger text-white waves-effect btn-label waves-light fw-bold w-100">
                            <i class="label-icon fa fa-ban"></i>
                            &nbsp; Batalkan Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </section>
@endsection

@push('addon-script')
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
