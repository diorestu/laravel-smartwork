<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<div class="card card-custom gutter-b rounded-sm shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between">
            <div class="col-9"><h5>Filter data dengan</h5></div>
            <div class="col-3">
                <div class="d-flex" id="userstable_filter"></div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table rounded" id="myTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-left">Nama</th>
                        <th class="text-left">Cabang</th>
                        <th class="text-left">Tanggal Cuti</th>
                        <th class="text-center">Total Hari</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center" width="5%">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                        <tr data-child-value="
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td width='70%'>{{ $i->cuti_deskripsi }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Cuti</td>
                                <td>:</td>
                                <td width='70%'><span class='badge rounded-pill badge-soft-warning text-warning'>{{ $i->cutiJenis->cuti_nama_jenis }}</span></td>
                            </tr>
                            <tr>
                                <td>Diajukan Pada</td>
                                <td>:</td>
                                <td width='70%'>{{ tanggalIndoWaktuLengkap($i->created_at) }}</td>
                            </tr>
                            ">
                            <td>{{ $i->user->nama }}</td>
                            <td>{{ $i->user->cabang->cabang_nama }}</td>
                            <td class="text-left">{{ tanggalIndo3($i->cuti_awal) }} - {{ tanggalIndo3($i->cuti_akhir) }}</td>
                            <td class="text-center">{{ $i->cuti_total }} hari</td>
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
                                        <li><a class="dropdown-item" target="_blank" href='{{ route('cuti.edit', $i->id_cuti) }}'>
                                                <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit
                                            </a></li>
                                        <li><a id="{{ $i->id_cuti }}" href="javascript:void(0);" class="remove dropdown-item text-danger"><i class="fa fa-trash text-danger me-2"></i><b>Hapus</b></a></li>
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
    $(document).ready(function() {
        function format ( data ) {
            return '<table class="table">'+data+'</table>';
        }
        $('#myTable').DataTable({
            initComplete: function () {
                this.api().columns([1]).every( function (jud) {
                    var theadname       = $("#myTable th").eq([jud]).text();
                    var column          = this;
                    const wrapper       = document.createElement('div');
                    wrapper.className   = 'filter_wp input-group col-12';
                    wrapper.innerHTML   = '<div class="input-group-text"><i class="fa fa-filter"></i></div>';
                    var ss              = document.getElementById('userstable_filter').appendChild(wrapper);
                    var select          = '<select class="form-control"><option value="">Semua '+theadname+'</option></select>';
                    var damas           = $(select).appendTo(ss);
                    damas.on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        var ssss = column.search( val ? '^'+val+'$' : '', true, false ).draw();
                        // console.log();
                    });
                    @php $q_cabang = App\Models\Cabang::where('id_admin', auth()->user()->id)->get(); @endphp
                    @foreach ($q_cabang as $r_cabang)
                        damas.append( '<option value="{{ $r_cabang->cabang_nama }}">{{ $r_cabang->cabang_nama }}</option>' )
                    @endforeach
                });
            },
            lengthMenu: [30, 60, 150, 300],
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
            var idCuti = $(this).attr("id");
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                text: 'Apakah Anda yakin ingin menghapus cuti? Data yang sudah dihapus tidak bisa dikembalikan.',
                icon: 'question',
                confirmButtonText: '<i class="fas fa-trash"></i>&nbsp; Hapus',
                confirmButtonColor: '{{ btnDelete(); }}',
                showConfirmButton: 'true',
                showCancelButton: 'true',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('kelola/cuti') }}" + '/' + idCuti;
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
                                Swal.fire('Berhasil', 'Berhasil menghapus cuti pegawai', 'success')
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
