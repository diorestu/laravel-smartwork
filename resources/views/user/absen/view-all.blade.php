@extends('layouts.mobile')

@section('title')Riwayat Kehadiran | Smartwork @endsection

@push('addon-style')
<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .no-border td { border: none; }
    .damas { background-color: #f2f2f2; }
    /* .alertify-notifier.ajs-right .ajs-message.ajs-visible { right: 260px !important; } */
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Log Kehadiran</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2">
        <div class="card mb-2">
            <form id="formAction" action="#" method="POST">
                @method('POST')
                @csrf
                <div class="d-flex">
                    <div class="col-12 pr-0 input-group">
                        <div class="input-group-text"><i class="font-size-18 bx bx-filter-alt"></i></div>
                        <input class="form-control" type="month" value="{{ date("Y-m") }}" name="hari" id="example-month-input">
                    </div>
                </div>
            </form>
        </div>
        <div id="content" class="card mx-1 table-responsive rounded">
            <table class="table rounded px-0" id="myTable">
                <thead class="bg-dark">
                    <tr class="d-none">
                        <th class="text-white">TANGGAL</th>
                        <th class="text-white">IN</th>
                        <th class="text-white">OUT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                        <tr data-child-value="
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Clock In</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'> {{ tanggalIndoWaktuLengkap($item->jam_hadir) }}</td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Clock Out</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'> {{ $item->jam_pulang ? tanggalIndoWaktuLengkap($item->jam_pulang) : 'Belum Absen' }}</td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Shift</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'>@if ($item->usershift_id != 0) {{ $item->user_shift->shift->ket_shift }} @else {{ "-" }} @endif</td>
                            </tr>
                            <tr class='no-border'>
                                <td class='px-0 py-1'>Aksi</td>
                                <td class='px-0 py-1'>:</td>
                                <td class='px-2 py-1'><a href='{{ route('absen.show', $item->id) }}'>Detail</a></td>
                            </tr>
                            ">
                            <td class="fw-bold text-uppercase">{{ TanggalBulan($item->jam_hadir) }}</td>
                            <td class="font-size-12">{{ TampilJamMenit($item->jam_hadir) }}</td>
                            <td class="font-size-12">{{ $item->jam_pulang ? TampilJamMenit($item->jam_pulang) : '-' }}</td>
                            <td class="dt-control text-end">
                                <a class="btn btn-outline-danger btn-sm btn-circle" href="javascript:void(0);"><i class="bx bx-caret-down"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr class="no-border">
                            <td class="text-center font-size-16" colspan="4">Tidak terdapat data presensi <br> <small class="text-muted">Semua presensi hadir/pulang Anda akan tampil disini</small></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('addon-script')
<script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    function format ( data ) {
        return '<table class="table mb-0">'+data+'</table>';
    }
    $(document).ready(function() {
        $('#myTable').DataTable({
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            lengthMenu: [30, 60, 150, 300],
            columnDefs: [
                { searchable: false, targets: 0 },
                { orderable: false, searchable: false, targets: 0 },
                { orderable: false, searchable: false, targets: 0 },
            ],
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
                row.child().addClass('damas');
                tr.addClass('shown');
            }
        });
    });
    $('#example-month-input').change(function() {
        var url = "{{ route('user.absen.viewRiwayat') }}";
        var date = $(this).val();
        if (date != "") {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                url: url,
                data: {'hari': date},
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
                }
            });
        } else {
            Swal.fire('Maaf','Silahkan pilih tanggal absen terlebih dahulu.','error');
        }
    });
</script>
@endpush
