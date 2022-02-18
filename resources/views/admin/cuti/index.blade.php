@extends('layouts.main')

@section('title')
    Data Pengajuan Cuti Pegawai - Bulan {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}
@endsection

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item active">Cuti Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Pengajuan Cuti Pegawai {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}</h4>
                    <p class="text-muted mt-1 text-opacity-50">Data pengajuan cuti pegawai periode {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn-soft-primary waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp;Impor/Ekspor Data</a>
                        <a href="{{ route('cuti.riwayat') }}" class="btn btn-warning waves-effect waves-light text-black">
                            <i class="fa fa-calendar icon-sm text-black"></i> Lihat Riwayat Cuti Pegawai&nbsp;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse ($data as $item)
            <div class="col-sm-6 col-md-3">
                <div class="card card-custom gutter-b rounded-sm shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">{{ $item->user->nama }}</h4>
                        <p class="card-text">{{ $item->cuti_deskripsi }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><span class="badge bg-soft-warning text-warning">Cuti Melahirkan</span></li>
                        <li class="list-group-item">{{ $item->cuti_total }} hari</li>
                        <li class="list-group-item">{{ tanggalIndo3($item->cuti_awal).' - '.tanggalIndo3($item->cuti_akhir) }}</li>
                    </ul>
                    <div class="card-body d-flex justify-content-center">
                        <a onclick="actionCuti('terima', {{ $item->id_cuti }})" href="javascript:void(0);" class="btn btn-block w-100 mx-1 btn-primary waves-effect waves-light"><i class="fas fa-check"></i>&nbsp; Terima</a>
                        <a onclick="actionCuti('tolak', {{ $item->id_cuti }})" href="javascript:void(0);" class="btn btn-block w-100 mx-1 btn-warning waves-effect waves-light text-black"><i class="fas fa-times"></i>&nbsp; Tolak</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-custom gutter-b rounded-sm shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1><i class="fas fa-coffee"></i></h1>
                            <h4>Data Kosong</h4>
                            <p>Belum ada pengajuan cuti pegawai di perode {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@push('addon-script')
    <script>
        function actionCuti(action, idCuti) {
            if (action == "terima") {
                var s_title = "Konfirmasi Approval Cuti";
                var s_text  = "Apakah Anda yakin ingin menyetujui cuti pegawai ini?";
                var s_btnText = '<i class="fas fa-check"></i>&nbsp; Terima';
                var s_btnClr  = '{{ btnTerima(); }}';
            }
            else if (action == "tolak") {
                var s_title = "Konfirmasi Tolak Cuti";
                var s_text  = "Apakah Anda yakin ingin menolak cuti pegawai ini?";
                var s_btnText = '<i class="fas fa-times"></i>&nbsp; Tolak';
                var s_btnClr  = '{{ btnTolak(); }}';
            }
            Swal.fire({
                title: s_title,
                text: s_text,
                icon: 'question',
                confirmButtonText: s_btnText,
                confirmButtonColor: s_btnClr,
                showConfirmButton: 'true',
                showCancelButton: 'true',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (action == "terima") { var url       = "{{ url('kelola/cuti') }}" + '/' + idCuti + '/terima'; }
                    else if (action == "tolak") { var url    = "{{ url('kelola/cuti') }}" + '/' + idCuti + '/tolak'; }
                    else { var url                          = ""; }
                    window.location.href = url;
                }
            });
        }
    </script>
@endpush
