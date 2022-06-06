@extends('layouts.main')

@section('title')
    Permohonan Lembur Pegawai | Smartwork App
@endsection

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Lembur Pegawai</a></li>
                        <li class="breadcrumb-item active">Permohonan Lembur</li>
                    </ol>
                    <h4 class="fw-bold font-size-22 mt-3 mb-3">Permohonan Lembur Pegawai</h4>
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
                                                    <input required id="waktu" class="form-control daterange" type="text" name="waktu" value="{{ $sesi_lembur }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3 mt-2">
                                                <button class="btn btn-warning text-black w-100 mt-3 font-weight-boldest btn-md" type="submit">
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

        <div class="row" id="content">
            @if ($data != null)
            @forelse ($data as $item)
                <div class="col-sm-6 col-md-3 cont_{{ $item->id }}">
                    <div class="card card-custom gutter-b rounded-sm shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">{{ $item->user->nama }}</h4>
                            <p class="card-text">{{ $item->lembur_judul }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="icon-menu fas fa-map-marker-alt"></i> {{ $item->user->cabang->cabang_nama }}</li>
                            <li class="list-group-item"><i class="icon-menu fas fa-clock"></i> <span class="badge bg-soft-warning text-warning">{{ $item->jam_lembur }} jam</span></li>
                            <li class="list-group-item">{{ $item->lembur_keterangan }}</li>
                            <li class="list-group-item" style="font-size: 10px;font-weight:bold;">{{ tanggalIndoWaktu($item->lembur_awal).' - '.tanggalIndoWaktu($item->lembur_akhir) }}</li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Option</span>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li><a class="dropdown-item" href='{{ route('lembur.edit', $item->id) }}'><span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit</a></li>
                                        <li><a id="{{ $item->id }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <div class="card-body d-flex justify-content-center">
                            <a onclick="actionCuti('terima', {{ $item->id }})" href="javascript:void(0);" class="btn btn-block w-100 mx-1 btn-primary waves-effect waves-light"><i class="fas fa-check"></i>&nbsp; Terima</a>
                            <a onclick="actionCuti('tolak', {{ $item->id }})" href="javascript:void(0);" class="btn btn-block w-100 mx-1 btn-warning waves-effect waves-light text-black"><i class="fas fa-times"></i>&nbsp; Tolak</a>
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
                                <p>Belum ada permohonan lembur pegawai di perode {{ Carbon\Carbon::parse(date('Y-m'))->locale('id')->format('M Y') }}</p>
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
        $(document).ready(function() {
            $('.remove').on('click', function() {
                var idLembur = $(this).attr("id");
                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: 'Apakah Anda yakin ingin menghapus lembur ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'question',
                    confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                    confirmButtonColor: '{{ btnDelete(); }}',
                    showConfirmButton: 'true',
                    showCancelButton: 'true',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ url('kelola/lembur') }}" + '/' + idLembur;
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        });
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            beforeSend: function(){
                                Swal.showLoading()
                            },
                            success: function(result)
                            {
                                if (result == "ok") {
                                    $( ".cont_"+idLembur ).remove();
                                    Swal.fire('Berhasil', 'Berhasil menghapus lembur pegawai', 'success')
                                } else {
                                    Swal.fire('Gagal',result,'error')
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            });
        });
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var waktu = $("#waktu").val();
            var formData = new FormData(this);
            if (waktu != "") {
                var url = "{{ url('kelola/data-pengajuan-lembur') }}";
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
        function actionCuti(action, idLembur) {
            if (action == "terima") {
                var s_title = "Konfirmasi Approval Lembur";
                var s_text  = "Apakah Anda yakin ingin menyetujui lembur pegawai ini?";
                var s_btnText = '<i class="fas fa-check"></i>&nbsp; Terima';
                var s_btnClr  = '{{ btnTerima(); }}';
            }
            else if (action == "tolak") {
                var s_title = "Konfirmasi Tolak Lembur";
                var s_text  = "Apakah Anda yakin ingin menolak lembur pegawai ini?";
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
                    if (action == "terima") { var url       = "{{ url('kelola/lembur') }}" + '/' + idLembur + '/terima'; }
                    else if (action == "tolak") { var url   = "{{ url('kelola/lembur') }}" + '/' + idLembur + '/tolak'; }
                    else { var url                          = ""; }
                    window.location.href = url;
                }
            });
        }
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
