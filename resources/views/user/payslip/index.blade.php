@extends('layouts.mobile')

@section('title')Slip Gaji | Smartwork @endsection

@push('addon-style')
<style>
    .card-header-merah { background:#B0141C !important; }
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
                    <h2 class="fw-bold font-size-18 text-white mb-0">Slip Gaji</h2>
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
    <section class="px-2 pb-0 pt-2 m-0">
        <div class="card mb-2">
            <div class="d-flex">
                <div class="col-12 pr-0 input-group">
                    <div class="input-group-text"><i class="font-size-18 bx bx-filter-alt"></i></div>
                    <input class="form-control" type="month" value="{{ date("Y-m") }}" name="hari" id="example-month-input">
                </div>
            </div>
        </div>
    </section>
    <div id="content">
        @if ($gaji != null)
        {{-- info --}}
        <section class="pt-0 pb-2 px-2 m-0">
            <div class="card mb-2">
                <div class="card-header card-header-merah py-2 px-2">
                    <h6 class="my-0 text-white"><i class="mdi mdi-block-helper me-3"></i>Bersifat Rahasia</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="card-text text-muted mb-1">PT. Asta Pijar Kreasi</p>
                            <h5 class="card-title mb-1">Ni Komang Karina Wardani</h5>
                            <p class="card-text">Staff Marketing</p>
                        </div>
                        <div>
                            <img src="{{ $id->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $data_user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- pendapatan --}}
        <section class="pt-0 pb-2 px-2 m-0">
            <div class="card mb-2">
                <div class="card-header py-2 bg-transparent border-bottom fw-bold text-uppercase">
                    PENDAPATAN
                </div>
                <div class="card-body p-0">
                    <ul class="list-group-flush p-1 mb-0">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            Gaji Pokok
                            <span>{{ $gaji->pay_pokok }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            Tunjangan
                            <span class="badge bg-primary rounded-pill">2</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            A third list item
                            <span class="badge bg-primary rounded-pill">1</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer py-2 bg-light d-flex justify-content-between align-items-center border-top">
                    <span>Total Pendapatan</span>
                    <span>Rp. 2.000.000</span>
                </div>
            </div>
        </section>
        {{-- potongan --}}
        <section class="pt-0 pb-2 px-2 m-0">
            <div class="card mb-2">
                <div class="card-header py-2 bg-transparent border-bottom fw-bold text-uppercase">
                    POTONGAN
                </div>
                <div class="card-body p-0">
                    <ul class="list-group-flush p-1 mb-0">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            Gaji Pokok
                            <span>Rp. 1.000.000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            Tunjangan
                            <span class="badge bg-primary rounded-pill">2</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            A third list item
                            <span class="badge bg-primary rounded-pill">1</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer py-2 bg-light d-flex justify-content-between align-items-center border-top">
                    <span>Total Pendapatan</span>
                    <span>Rp. 2.000.000</span>
                </div>
            </div>
        </section>
        {{-- caution --}}
        <section class="pt-0 pb-2 px-2 m-0">
            <div class="card mb-2">
                <div class="card-header text-center py-2 font-size-14 bg-transparent border-bottom fw-bold text-uppercase">
                    TAKE HOME PAY
                </div>
                <div class="card-body p-2">
                    <h2 class="text-center text-danger mb-0">Rp. 2.000.000</h2>
                </div>
                <div class="card-footer py-2 text-center bg-light border-top">
                    <span class="font-size-11"><i>Dua juta tiga ratus ribu lima ratus dua puluh tiga rupiah</i></span>
                </div>
            </div>
        </section>
        <section class="pt-0 pb-2 px-2 m-0">
            <div class="card mb-2">
                <div class="d-flex">
                    <div class="col-12 pr-0">
                        <a href="#" class="btn btn-warning text-black waves-effect btn-label waves-light fw-bold w-100"><i class="label-icon fa fa-download"></i>&nbsp; Download Slip Gaji</a>
                    </div>
                </div>
            </div>
            <p class="font-size-11 mt-3 mb-0">
                <i>Dicetak dengan Smartwork App - <b>Solusi Digital HR Perusahaan</b> <br>
                Slip gaji ini tidak membutuhkan tanda tangan, untuk konfirmasi silahkan hubungi 0361-1122245</i>
            </p>
            <p class="font-size-11 mt-2 text-muted">
                <i>HARAP DICATAT BAHWA ISI PERNYATAAN INI HARUS DIPERLAKUKAN DENGAN KERAHASIAAN MUTLAK, KECUALI ANDA HARUS MEMBUAT PENGUNGKAPAN UNTUK TUJUAN PAJAK, HUKUM, ATAU PERATURAN.
                    SETIAP PELANGGARAN KEWAJIBAN KERAHASIAAN INI AKAN DIPROSES SECARA SERIUS BAIK SIAPA SAJA YANG MUNGKIN TERLIBAT</i>
            </p>
        </section>
        @else
        <section class="pt-0 pb-2 px-2 m-0">
            <div class="card mb-2">
                <div class="card-body px-0 py-1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-2 py-3 mb-2">
                            <div class="text-center">
                                <p class="fw-bold font-size-14 mb-1">Slip gaji tidak tersedia di bulan ini</p>
                                <p class="fw-regular font-size-12 text-muted mb-1">Harap sabar ya, slip gaji kamu akan segera tampil disini</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        @endif
    </div>
    <br>
    <br>
@endsection

@push('addon-script')
<script>
    $('#example-month-input').change(function() {
        var url = "{{ route('payslip.riwayat') }}";
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
