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
