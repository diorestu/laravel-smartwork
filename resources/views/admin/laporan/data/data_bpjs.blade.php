<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<div class="col-lg-12">
    <div class="card bg-transparent shadow-none">
        <div class="card-body px-2">
            <ul class="nav nav-pills nav-tabs-custom card-header-tabs mt-1" id="pills-tab" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link px-3 py-2 active text-dark" data-bs-toggle="tab" href="#kes" role="tab"
                        aria-selected="true">BPJS Kesehatan</a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link px-3 py-2 text-dark" data-bs-toggle="tab" href="#ker" role="tab"
                        aria-selected="false">BPJS Ketenagakerjaan</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-xl-12 col-lg-12">
    <div class="tab-content">
        <!-- KESEHATAN -->
        <div class="tab-pane active" id="kes" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title text-white mb-0 mt-2">BPJS Kesehatan</h5>
                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="fw-bold btn btn-warning text-black dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download icon-sm text-black"></i> Ekspor Data <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                            <a class="dropdown-item" href="#"><i class="fas fa-file-excel icon-sm"></i> Excel</a>
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
                                    <th>Pegawai</th>
                                    <th>Gaji Pokok</th>
                                    <th>Pot. Pegawai</th>
                                    <th>Pot. Perusahaan</th>
                                    <th>Jum. Potongan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->user->nama }}</td>
                                    <td>{{ rupiah($d->pay_pokok) }}</td>
                                    <td>{{ rupiah($d->bpjs_kes_u) }}</td>
                                    <td>{{ rupiah($d->bpjs_kes_p) }}</td>
                                    <td>{{ rupiah(($d->bpjs_kes_u+$d->bpjs_kes_p)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="fw-bold">-</th>
                                    <th class="fw-bold">Jumlah Total</th>
                                    <th class="fw-bold">{{ rupiah($d->sum('pay_pokok')) }}</th>
                                    <th class="fw-bold">{{ rupiah($d->sum('bpjs_kes_u')) }}</th>
                                    <th class="fw-bold">{{ rupiah($d->sum('bpjs_kes_p')) }}</th>
                                    <th class="fw-bold">{{ rupiah(($d->sum('bpjs_kes_u')+$d->sum('bpjs_kes_p'))) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- KETENAGAKERJAAN -->
        <div class="tab-pane" id="ker" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title text-white mb-0 mt-2">BPJS Ketenagakerjaan</h5>
                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="fw-bold btn btn-warning text-black dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download icon-sm text-black"></i> Ekspor Data <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                            <a class="dropdown-item" href="#"><i class="fas fa-file-excel icon-sm"></i> Excel</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-file-pdf icon-sm"></i> PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table rounded" id="myTable2">
                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Pegawai</th>
                                    <th>Gaji Pokok</th>
                                    <th>Pot. Pegawai</th>
                                    <th>Pot. Perusahaan</th>
                                    <th>Jum. Potongan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->id_user }}</td>
                                    <td>{{ rupiah($d->pay_pokok) }}</td>
                                    <td>{{ rupiah($d->bpjs_tk_u) }}</td>
                                    <td>{{ rupiah($d->bpjs_tk_p) }}</td>
                                    <td>{{ rupiah(($d->bpjs_tk_u+$d->bpjs_tk_p)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="fw-bold">-</th>
                                    <th class="fw-bold">Jumlah Total</th>
                                    <th class="fw-bold">{{ rupiah($d->sum('pay_pokok')) }}</th>
                                    <th class="fw-bold">{{ rupiah($d->sum('bpjs_tk_u')) }}</th>
                                    <th class="fw-bold">{{ rupiah($d->sum('bpjs_tk_p')) }}</th>
                                    <th class="fw-bold">{{ rupiah(($d->sum('bpjs_tk_u')+$d->sum('bpjs_tk_p'))) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
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
    $('#myTable2').DataTable({
        lengthMenu: [30, 60, 150, 300],
        order: [[0, 'asc']]
    });
</script>
