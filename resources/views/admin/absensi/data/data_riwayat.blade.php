<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .f-10 { font-size: 10px !important; }
    .card-header { background:#B0141C !important; padding: 0.75rem 1.25rem; }
    .filter_wp { margin-bottom: 20px; }
    .filter_wp span { font-weight: bold; margin-bottom: 10px; display:block; }
    .text-tipis  { font-weight: 300; opacity: 0.5; }
</style>

<div class="card card-custom gutter-b rounded-sm shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title text-white mb-0 mt-2">Absensi Tercatat</h5>
        <div class="btn-group" role="group">
            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-download icon-sm"></i>&nbsp; Ekspor Data <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                <a class="dropdown-item" href="{{ route("absensi.riwayat.ekspor", $hari) }}">File Excel</a>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="d-flex justify-content-end">
            <div class="row" id="userstable_filter"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="myTable">
                <thead class="table-dark">
                    <tr>
                        <th width="2%">No</th>
                        <th>Nama Pegawai</th>
                        <th>Lokasi Kerja</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">In</th>
                        <th class="text-center">Out</th>
                        <th class="text-center">Late</th>
                        <th width="5%">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $i->user->nama }}</td>
                            <td>{{ $i->cabang_nama }}</td>
                            <td>{{ tglIndo2($i->jam_hadir) }} <br><span class="text-tipis">{{ $i->ket_shift." ".TampilJamMenit($i->hadir_shift)." - ".TampilJamMenit($i->pulang_shift) }}</span></td>
                            <td class="text-center">{{ TampilJamMenit($i->jam_hadir) }}</td>
                            <td class="text-center">@if ($i->jam_pulang == "") {{ "-" }} @else {{ TampilJamMenit($i->jam_pulang) }} @endif</td>
                            <td class="text-center">
                                {{ telat(TampilTanggal($i->jam_hadir)." ".$i->hadir_shift, $i->jam_hadir, $i->nama_shift) }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li><a class="dropdown-item" href='{{ route('absensi.show', $i->id) }}'>
                                            <span><i class="fas fa-info-circle icon-sm"></i></span>&nbsp;
                                            Lihat Detail
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

<div class="card card-custom gutter-b rounded-sm shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title text-white mb-2 mt-2">Belum Absen</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover" id="myTableTwo">
                <thead class="table-dark">
                    <tr>
                        <th width="2%">No</th>
                        <th>Nama Pegawai</th>
                        <th>Lokasi Kerja</th>
                        <th class="text-center">Shift</th>
                        <th class="text-center">In</th>
                        <th class="text-center">Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_belum_absen as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->nama }}</td>
                            <td>{{ $b->cabang->cabang_nama }}</td>
                            <td class="text-center"><a href="javascript:void(0);" data-toggle="tooltip" title="{{ $b->ket_shift." ".TampilJamMenit($b->hadir_shift)." - ".TampilJamMenit($b->pulang_shift) }}">{{ $b->nama_shift }}</a></td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
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
    $(function () { $('[data-toggle="tooltip"]').tooltip() });
    $(document).ready(function() {
        $('#myTable').DataTable({
            lengthMenu: [50, 100, 150, 300],
            order: [[0, 'asc']]
        });
        $('#myTableTwo').DataTable({
            initComplete: function () {
                this.api().columns([2]).every( function (jud) {
                    var sita            = $('#myTable').DataTable();
                    var theadname       = $("#myTableTwo th").eq([jud]).text();
                    var column          = this;
                    const wrapper       = document.createElement('div');
                    wrapper.className   = 'filter_wp input-group';
                    wrapper.innerHTML   = '<div class="input-group-text"><i class="fa fa-filter"></i></div>';
                    var ss              = document.getElementById('userstable_filter').appendChild(wrapper);
                    var select          = '<select class="form-control"><option value="">Semua '+theadname+'</option></select>';
                    var damas           = $(select).appendTo(ss);
                    damas.on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        var ssss = column.search( val ? '^'+val+'$' : '', true, false ).draw();
                        sita.columns([column[0][0]]).search( val ? '^'+val+'$' : '', true, false ).draw();
                        // console.log();
                    });
                    @php $q_cabang = App\Models\Cabang::where('id_admin', auth()->user()->id)->get(); @endphp
                    @foreach ($q_cabang as $r_cabang)
                        damas.append( '<option value="{{ $r_cabang->cabang_nama }}">{{ $r_cabang->cabang_nama }}</option>' )
                    @endforeach
                });
            },
            lengthMenu: [30, 60, 120, 240],
            order: [[0, 'asc']]
        });
        $('#myTable').on('click', '.remove', function() {
            var table = $('#myTable').DataTable();
            var row_index = table.row($(this).closest('tr'));
            var idStaff = $(this).attr("id");
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                text: 'Apakah Anda yakin ingin menghapus absensi ini? Data yang sudah dihapus tidak bisa dikembalikan.',
                icon: 'question',
                confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                confirmButtonColor: '{{ btnDelete(); }}',
                showConfirmButton: 'true',
                showCancelButton: 'true',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('kelola/absensi') }}" + '/' + idStaff;
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
                                Swal.fire('Berhasil', 'Berhasil menghapus absensi', 'success')
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
