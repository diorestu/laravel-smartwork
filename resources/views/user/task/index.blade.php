@extends('layouts.mobile-navbar')

@section('title')Aktivitas Saya | Smartwork @endsection

@push('addon-style')
<link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .no-border td { border: none; }
    .damas { background-color: #f2f2f2; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Aktivitas Kerja</h2>
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
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <input class="form-control" type="month" value="{{ "2019-08" }}" id="example-month-input">
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <a href="#" class="btn btn-primary waves-effect btn-label waves-light fw-light w-100"><i class="label-icon fa fa-plus-circle"></i>&nbsp; Buat Aktivitas Baru</a>
                </div>
            </div>
        </div>
        <div>
            <div class="card table-responsive">
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
                        @forelse($data as $item)
                            <tr data-child-value="
                                <tr class='no-border'>
                                    <td class='px-0 py-1'>Judul</td>
                                    <td class='px-0 py-1'>:</td>
                                    <td class='px-2 py-1'> {{ $item->title_kgt }}</td>
                                </tr>
                                <tr class='no-border'>
                                    <td class='px-0 py-1'>Keterangan</td>
                                    <td class='px-0 py-1'>:</td>
                                    <td class='px-2 py-1'> {{ $item->title_kgt }}</td>
                                </tr>
                                <tr class='no-border'>
                                    <td class='px-0 py-1'>Waktu Aktivitas</td>
                                    <td class='px-0 py-1'>:</td>
                                    <td class='px-2 py-1'> {{ $item->title_kgt }}</td>
                                </tr>
                                <tr class='no-border'>
                                    <td class='px-0 py-1'>Diinput pada</td>
                                    <td class='px-0 py-1'>:</td>
                                    <td class='px-2 py-1'> {{ $item->title_kgt }}</td>
                                </tr>
                                ">
                                <td class="fw-bold text-uppercase">{{ TanggalBulan($item->tanggal_kgt) }}</td>
                                <td class="font-size-12"></td>
                                <td class="font-size-12"></td>
                                <td class="dt-control text-end">
                                    <a class="btn-dark btn-sm btn-circle" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-border">
                                <td class="text-center font-size-16" colspan="3">Tidak ada riwayat aktivitas <br> <small class="text-muted">Semua aktivitas Anda akan tampil disini</small></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
</script>
@endpush
