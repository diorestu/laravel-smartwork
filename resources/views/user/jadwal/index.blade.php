@extends('layouts.mobile')

@section('title')Jadwal Kerja | Smartwork @endsection

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Jadwal Kerja Saya</h2>
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
                    <div class="col-12 pr-0">
                        <input class="form-control" type="month" value="{{ date("Y-m") }}" name="hari" id="example-month-input">
                    </div>
                </div>
            </form>
        </div>
        <div id="content" class="card mb-2 rounded-sm">
            <table class="table mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th class="text-center">Jam Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $item)
                        <tr>
                            <td class="fw-bold text-uppercase" scope="row">{{ tanggalIndo3($item->tanggal_shift) }}</td>
                            <td class="font-size-11"><b>{{ $item->shift->nama_shift }}</b> : {{ $item->shift->ket_shift }}</td>
                            <td class="font-size-11 text-center">{{ tampilJamMenit($item->shift->hadir_shift) }} - {{ tampilJamMenit($item->shift->pulang_shift) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('addon-script')
    <script>
        $('#example-month-input').change(function() {
            var url = "{{ route('jadwal.riwayat') }}";
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
