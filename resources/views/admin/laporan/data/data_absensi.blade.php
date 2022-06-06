<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<div class="col-xl-12 col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title text-white mb-0 mt-2">Ringkasan Absensi Pegawai</h5>
            <div class="btn-group" role="group">
                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-download icon-sm"></i> Ekspor Data <i class="mdi mdi-chevron-down"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                    <a class="dropdown-item" href="#">Rekap Absensi</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-pdf icon-sm"></i> PDF</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table rounded" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nama Pegawai</th>
                            <th>Hari Kerja</th>
                            <th>Tepat Waktu</th>
                            <th>Terlambat</th>
                            <th>Tidak Hadir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>{{ $d->user->nama }}</th>
                            <th>{{ hariKerja($d->id_user, $awal, $akhir) }} hari</th>
                            <th>{{ tepatWaktu($d->id_user, $awal, $akhir) }} kali</th>
                            <th>{{ terlambat($d->id_user, $awal, $akhir) }} kali</th>
                            <th>{{ mangkir($d->id_user, $awal, $akhir) }} kali</th>
                            <th>
                                <div class="dropdown">
                                    <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                        <a target="_blank" class="dropdown-item" href="{{ route("laporan.detail_absensi", ['user'=>$d->id_user, 'awal'=>$awal, 'akhir'=>$akhir]) }}">Lihat Detail</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $('#myTable').DataTable({
        lengthMenu: [30, 60, 150, 300],
        order: [[0, 'asc']]
    });
</script>
