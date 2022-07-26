@extends('layouts.mobile')

@section('title')Pengajuan Ubah Shift | Smartwork @endsection

@push('addon-style')
<style>
    .no-border { border: none !important; }
    .main-content { overflow: inherit; }
    .child_i { position: absolute; top:-150px; width: 100%; display: block; }
</style>
@endpush

@section('content')
    <section class="p-0">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important; height:250px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 mb-0 text-white">Pengajuan Ubah Shift</h2>
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
    <section class="parent">
        <form class="child_i" action="{{ route('schedule.store') }}" method="post" id="myForm">
            <div class="card m-2 rounded-sm">
                @method('POST')
                @csrf
                <div class="card-body px-2 py-1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Tanggal Tukar Shift</span>
                            <input id="shift_awal" class="form-control text-dark mt-1" type="date" name="tgl_shift" required>
                        </li>
                        <li class="list-group-item px-2 no-border d-none" id="infoJadwal">
                            <div class="d-flex">
                                <div class="col-4 px-1">
                                    <span class="text-muted">Shift</span>
                                    <br>
                                    <span id="old_shift">{{ "-" }}</span>
                                </div>
                                <div class="col-4 px-1">
                                    <span class="text-muted">Schedule In</span>
                                    <br>
                                    <span id="old_in">{{ "-" }}</span>
                                </div>
                                <div class="col-4 px-1">
                                    <span class="text-muted">Schedule Out</span>
                                    <br>
                                    <span id="old_out">{{ "-" }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Shift Baru</span>
                            <select id="id_shift_baru" class="form-select text-dark mt-1" name="id_shift_baru">
                                @foreach($shift as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_shift." : ".$data->ket_shift." (". TampilJamMenit($data->hadir_shift)." - ". TampilJamMenit($data->pulang_shift) .")" }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="list-group-item px-2 no-border">
                            <span class="fw-light font-size-12 text-muted">Keterangan</span>
                            <textarea id="keterangan" class="form-control text-dark mt-1" name="keterangan" cols="3" required></textarea>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col=12">
                <div class="fixed-bottom mb-0 card px-2 pb-4 pt-2 rounded-lg-top">
                    <button type="submit" class="btn btn-lg btn-primary waves-effect btn-label waves-light fw-regular font-size-14 text-white rounded-lg">
                        <i class="label-icon fa fa-check-circle me-2"></i>Ajukan Perubahan Shift
                    </button>
                </div>
            </div>
        </form>
    </section>
    <br>
    <br>
    <br>
@endsection

@push('addon-script')
<script>
    $('#shift_awal').change(function() {
        var url = "{{ route('schedule.cek') }}";
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
                    $('#infoJadwal').removeClass("d-none");
                    $('#infoJadwal').html(result);
                },
                complete: function(data) {
                    Swal.close();
                }
            });
        } else {
            Swal.fire('Maaf','Silahkan pilih tanggal terlebih dahulu.','error');
        }
    });
</script>
@endpush
