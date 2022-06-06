<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .f-10 { font-size: 10px !important; }
    .card-header { background:#B0141C !important; padding: 0.75rem 1.25rem; }
    .text-tipis  { font-weight: 300; opacity: 0.5; }
</style>

<div class="card shadow rounded-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title text-white mb-0 mt-2">Lembur Tercatat</h5>
        <div class="btn-group" role="group">
            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-download"></i>&nbsp; Ekspor Data <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                <a class="dropdown-item" href="{{ route("lembur.pegawai.ekspor", ['u'=>$user, 's'=>$awal, 'e'=>$akhir]) }}">File Excel</a>
            </div>
        </div>
    </div>
    <div class="card-body px-4 py-4">
        <div class="table-responsive">
            <table class="table rounded" id="myTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-left">Nama</th>
                        <th class="text-center">Tanggal Lembur</th>
                        <th class="text-center">Total Jam</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center" width="5%">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        <tr data-child-value="
                            <tr>
                                <td>Lokasi Kerja</td>
                                <td>:</td>
                                <td width='70%'>{{ $i->user->cabang->cabang_nama }}</td>
                            </tr>
                            <tr>
                                <td>Waktu Lembur</td>
                                <td>:</td>
                                <td width='70%'>{{ tanggalIndoWaktu($i->lembur_awal) }} - {{ tanggalIndoWaktu($i->lembur_akhir) }}</td>
                            </tr>
                            <tr>
                                <td>Judul Lembur</td>
                                <td>:</td>
                                <td width='70%'>{{ $i->lembur_judul }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td width='70%'>{{ $i->lembur_keterangan }}</td>
                            </tr>
                            <tr>
                                <td>Jam Kerja</td>
                                <td>:</td>
                                <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->jam_kerja }} jam</span></td>
                            </tr>
                            <tr>
                                <td>Jam Lembur</td>
                                <td>:</td>
                                <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->jam_lembur }} jam</span></td>
                            </tr>
                            <tr>
                                <td>Status Lembur</td>
                                <td>:</td>
                                @if ($i->lembur_status == 'DITERIMA')
                                <td width='70%'><span class='badge rounded-pill badge-soft-success text-success'>{{ $i->lembur_status }}</span> Pada {{ tanggalIndoWaktu($i->approve_date) }}</td>
                                @elseif($i->lembur_status == 'PENGAJUAN')
                                <td width='70%'><span class='badge rounded-pill badge-soft-primary text-primary'>{{ $i->lembur_status }}</span></td>
                                @else
                                <td width='70%'><span class='badge rounded-pill badge-soft-danger text-danger'>{{ $i->lembur_status }}</span></td>
                                @endif
                            </tr>
                            <tr>
                                <td>Diajukan Pada</td>
                                <td>:</td>
                                <td width='70%'>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>
                            </tr>
                            ">
                            <td>{{ $i->user->nama }}</td>
                            <td class="text-center">{{ tanggalIndo3($i->lembur_awal) }}</td>
                            <td class="text-center"><span class='badge rounded-pill badge-soft-primary text-primary'>{{ $i->jam_lembur }} jam</span></td>
                            <td class="dt-control text-center">
                                <a class="btn btn-primary btn-sm btn-circle" href="javascript:void(0);"><i class="fas fa-chevron-down"></i></a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li><a class="dropdown-item" href='{{ route('cuti.edit', $i->id) }}'>
                                                <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit
                                            </a></li>
                                        <li><a id="{{ $i->id }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    function format ( data ) {
        return '<table class="table">'+data+'</table>';
    }
    $(function () { $('[data-toggle="tooltip"]').tooltip() });
    $(document).ready(function() {
        $('#myTable').DataTable({
            lengthMenu: [10, 30, 45, 100],
            order: [[0, 'asc']]
        });
        $('#myTable tbody').on('click', 'td.dt-control', function () {
            var table   = $('#myTable').DataTable();
            var tr      = $(this).closest('tr');
            var row     = table.row( tr );
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(tr.data('child-value'))).show();
                tr.addClass('shown');
            }
        });
        $('#myTable').on('click', '.remove', function() {
            var table = $('#myTable').DataTable();
            var row_index = table.row($(this).closest('tr'));
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
                                row_index.remove().draw();
                                Swal.fire('Berhasil', 'Berhasil menghapus lembur', 'success')
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
