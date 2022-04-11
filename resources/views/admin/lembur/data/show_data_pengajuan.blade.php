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
</script>
