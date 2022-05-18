<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<div class="col-xl-12 col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title text-white mb-0 mt-2">Perhitungan Pajak PPh 21 Pegawai</h5>
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
                            <th>Penghasilan Bersih</th>
                            <th>PKP</th>
                            <th>PPh Pasal 21</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        @php
                            $netto          = $d['netto'];
                            if ($netto >= 4500000) {
                                $netto_setahun  = 12*$netto;
                                $pkp            = floor($netto_setahun-54000000);
                                $pph_terutang   = (5/100*$pkp);
                                $pph21          = $pph_terutang/12;
                            }
                            else {
                                $pkp            = "-";
                                $pph21          = "-";
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->user->nama }}</td>
                            <td>{{ rupiah($netto) }}</td>
                            <td>{{ $pkp == "-" ? "-" : rupiah($pkp) }}</td>
                            <td>{{ $pph21 == "-" ? "-" : rupiah($pph21) }}</td>
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
    $('#myTable2').DataTable({
        lengthMenu: [30, 60, 150, 300],
        order: [[0, 'asc']]
    });
</script>
