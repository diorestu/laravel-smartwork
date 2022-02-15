<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<div class="table-responsive">
    <table class="table table-hover" id="myTable">
        <thead class="table-dark">
            <tr>
                <th>Tanggal Absen</th>
                <th class="text-center">Shift</th>
                <th class="text-center">In</th>
                <th class="text-center">Out</th>
                <th width="5%">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i)
                <tr>
                    <td>{{ tanggalIndo($i->jam_hadir) }}</td>
                    @php
                        $tanggal = ubahKeTanggal($i->jam_hadir);
                        $r_shift = App\Models\UserShift::where('id_user', $i->id_user)->whereDate('tanggal_shift', '=' , $tanggal)->first();
                    @endphp
                    @if ($r_shift != "")
                        <td class="text-center"><a href="javascript:void(0);" data-toggle="tooltip" title="{{ $r_shift->shift->ket_shift." ".TampilJamMenit($r_shift->shift->hadir_shift)." - ".TampilJamMenit($r_shift->shift->pulang_shift) }}">{{ $r_shift->shift->nama_shift }}</a></td>
                    @else
                        <td class="text-center"></td>
                    @endif
                    <td class="text-center">{{ TampilJamMenit($i->jam_hadir) }}</td>
                    <td class="text-center">@if ($i->jam_pulang == "") {{ "-" }} @else {{ TampilJamMenit($i->jam_pulang) }} @endif</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-horizontal-rounded"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li><a target="_blank" class="dropdown-item" href='{{ route('absensi.show', $i->id) }}'>
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

<script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function () { $('[data-toggle="tooltip"]').tooltip() });
    $(document).ready(function() {
        $('#myTable').DataTable({
            lengthMenu: [10, 30, 45, 100],
            columnDefs: [
                { searchable: false, targets: 0 },
                { orderable: false, searchable: false, targets: 1 },
              ],
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
