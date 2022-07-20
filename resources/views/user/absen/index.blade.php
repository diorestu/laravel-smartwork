@extends('layouts.mobile-navbar')

@section('title')Presensi | Smartwork @endsection

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
    <section class="">
        <div class="ps-5 pe-5 pb-5 pt-1" style="background-color: #B0141C !important; height:200px;">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="">
                    <p class="text-white fw-light font-size-12 mb-1">{{ $id->cabang->cabang_nama }}</p>
                    <h2 class="fw-bold font-size-25 text-white">{{ $id->nama }}</h2>
                    <p class="text-white fw-regular font-size-13 mb-1">{{ $id->jabatan->jabatan_title }}</p>
                </div>
                <div class=''>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <main class="px-4 parent pb-0">
        <div class="child card rounded-md mb-0 px-0">
            <div class="card-body">
                <div class="text-center">
                    @if (!$shift || $shift == null)
                        <b class="fw-light font-size-14 text-muted">Tidak ada shift</b><br>
                        <b class="fw-bold font-size-20">00:00 - 00:00</b><br>
                    @else
                        <b class="fw-light font-size-14 text-muted">{{ $shift->shift->ket_shift == 'Libur' ? 'Libur' : 'Shift ' . $shift->shift->ket_shift }}
                            - {{ tanggalIndo($shift->tanggal_shift) }}</b><br>
                        <b class="fw-bold font-size-20">{{ tampilJamMenit($shift->shift->hadir_shift) }} -
                            {{ tampilJamMenit($shift->shift->pulang_shift) }}</b><br>
                    @endif
                </div>
                {{-- <hr> --}}
                <div class="row mt-4">
                    @if ($absen)
                        <div class="col-6">
                            <a id="btn"
                                class="rounded-md font-size-16 fw-medium btn btn-primary py-2 mt-2 w-100 {{ $in ? 'disabled' : '' }}"
                                href="{{ route('absen.create') }}">
                                IN {{ $in ? '- ' . tampilJamMenit($absen->jam_hadir) : 'false' }}</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ $out ? '' : route('absen.edit', $absen->id) }}" id="btn"
                                class="rounded-md font-size-16 fw-medium btn btn-primary py-2 mt-2 w-100 {{ $out ? 'disabled' : '' }}">
                                OUT {{ $out ? '- '.tampilJamMenit($absen->jam_pulang) : '' }}</a>
                            {{-- href="{{ $out ? '' : route('absen.edit', $absen->id) }}" --}}
                        </div>
                    @elseif(!$shift || $shift == null)
                        <div class="col-12 text-center">
                            {{-- <p class="font-medium mb-2">Atur Shift Anda Terlebih Dahulu</p> --}}
                            <a href="{{ route('user.get.shift') }}" class="btn btn-primary w-100 rounded-md">Pilih Shift</a>
                        </div>
                    @else
                        <div class="col-6">
                            <a id="btn" class="rounded-md font-size-16 fw-bold btn btn-primary py-2 mt-2 w-100"
                                href="{{ route('absen.create') }}">
                                CLOCK IN</a>
                        </div>
                        <div class="col-6">
                            <a id="btn" class="rounded-md font-size-16 fw-bold btn btn-primary py-2 mt-2 w-100 disabled">
                                CLOCK OUT</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <section>
        <div>
            <div class="px-4 d-flex justify-content-between align-items-baseline">
                <h5 class="mb-3 fw-regular">Log Kehadiran</h5>
                <a href='{{ route('user.absen.riwayat') }}' class="font-size-sm text-primary fw-medium">Lihat semua <i class="fa fa-chevron-right icon-xs text-primary fw-bold"></i></a>
            </div>
            <div class="card mx-3 table-responsive">
                <table class="table rounded px-0" id="myTable">
                    <thead class="bg-dark">
                        <tr class="d-none">
                            <th class="text-white">TANGGAL</th>
                            <th class="text-white">SHIFT</th>
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
                                    <td class='px-0 py-1'></td>
                                </tr>
                                <tr class='no-border'>
                                    <td class='px-0 py-1'>Aksi</td>
                                    <td class='px-0 py-1'>:</td>
                                    <td class='px-0 py-1'> &nbsp;&nbsp;<a href='{{ route('absen.show', $item->id) }}'>Detail</a></td>
                                </tr>
                                ">
                                <td class="fw-bold text-uppercase">{{ TanggalBulan($item->jam_hadir) }}</td>
                                <td class="font-size-12">Pagi</td>
                                <td class="font-size-12">{{ TampilJamMenit($item->jam_hadir) }}</td>
                                <td class="font-size-12">{{ $item->jam_pulang ? TampilJamMenit($item->jam_pulang) : 'Belum Absen' }}</td>
                                <td class="dt-control text-end">
                                    <a class="btn-dark btn-sm btn-circle" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
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
        </div>
    </section>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
<script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    //     alertify.warning("Warning message");
    //     alertify.message("Normal message");
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
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
        // Swal.fire('Berhasil', '{{ \Session::get('success') }}', 'success')
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
        // Swal.fire('Gagal', '{{ \Session::get('error') }}', 'error')
    </script>
@endif
@endpush
