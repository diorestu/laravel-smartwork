@extends('layouts.main')

@section('title')
    Data Pengajuan Cuti Pegawai
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
                    <h4 class="fw-bold font-size-22 mt-3 mb-3">Pengajuan Cuti Pegawai</h4>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('cuti.rekap') }}" class="btn btn-success mx-3"><i class="fa fa-calendar icon-sm"></i> &nbsp; Lihat Cuti yang Diapprove</a>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-warning text-black dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download"></i> &nbsp; Ekspor Data &nbsp; <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Pilih Rentang Waktu
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <form id="formAction" action="#" method="POST">
                                        @method('POST')
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-9 col-md-9">
                                                <div class="form-group mb-4">
                                                    <label for="waktu">Rentang Waktu <span class="text-danger">*</span></label>
                                                    <input required id="waktu" class="form-control daterange" type="text" name="waktu" value="{{ $sesi_cuti }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3 mt-2">
                                                <button class="btn btn-primary w-100 mt-3 font-weight-boldest btn-md" type="submit">
                                                    <i class="fas fa-info-circle icon-md"></i> Lihat Data
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="content">
            @if ($data != null)
            @forelse ($data as $item)
                <div class="col-sm-6 col-md-3">
                    <div class="card card-custom gutter-b rounded-sm shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">{{ $item->user->nama }}</h4>
                            <p class="card-text">{{ $item->cuti_deskripsi }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="badge bg-soft-warning text-warning">{{ $item->cutiJenis->cuti_nama_jenis }}</span></li>
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
                                <p>Belum ada pengajuan cuti pegawai</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
            @else
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h1><i class="icon-sm fas fa-calendar"></i></h1>
                        <h3>Silahkan Pilih Rentang Waktu</h3>
                        <p>Untuk melihat data, silahkan set rentang waktu lalu klik lihat data.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var waktu = $("#waktu").val();
            var formData = new FormData(this);
            if (waktu != "") {
                var url = "{{ url('kelola/data-pengajuan-cuti') }}";
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    url: url,
                    data: formData,
                    type: 'POST',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang Memproses Data...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false
                        });
                        Swal.showLoading();
                    },
                    success: function(result) {
                        $('#content').html(result);
                    },
                    complete: function(data) {
                        Swal.close();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                Swal.fire('Maaf','Silahkan pilih rentang waktu.','error');
            }
        });
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
