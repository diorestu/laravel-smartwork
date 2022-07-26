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
                    <p class="card-text text-muted mb-1">{{ $gaji->user->cabang->cabang_nama }}</p>
                    <h5 class="card-title mb-1">{{ $gaji->user->nama }}</h5>
                    <p class="card-text">{{ $gaji->user->jabatan->jabatan_title }}</p>
                </div>
                <div>
                    <img src="{{ $gaji->user->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $gaji->user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
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
                    <span>{{ rupiah($gaji->pay_pokok) }}</span>
                </li>
                @if ($gaji->tj_jabatan > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Jabatan
                    <span>{{ rupiah($gaji->tj_jabatan) }}</span>
                </li>
                @endif
                @if ($gaji->tj_sertifikasi > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Sertifikasi
                    <span>{{ rupiah($gaji->tj_sertifikasi) }}</span>
                </li>
                @endif
                @if ($gaji->tj_transport > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Transportasi
                    <span>{{ rupiah($gaji->tj_transport) }}</span>
                </li>
                @endif
                @if ($gaji->tj_kosmetik > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Kosmetik
                    <span>{{ rupiah($gaji->tj_kosmetik) }}</span>
                </li>
                @endif
                @if ($gaji->tj_makan > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Makan
                    <span>{{ rupiah($gaji->tj_makan) }}</span>
                </li>
                @endif
                @if ($gaji->tj_masaKerja > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Masa Kerja
                    <span>{{ rupiah($gaji->tj_masaKerja) }}</span>
                </li>
                @endif
                @if ($gaji->tj_statusKawin > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Tunjangan Status Kawin
                    <span>{{ rupiah($gaji->tj_statusKawin) }}</span>
                </li>
                @endif
                @if ($gaji->tj_bonus > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Isentif Pegawai
                    <span>{{ rupiah($gaji->tj_bonus) }}</span>
                </li>
                @endif
            </ul>
        </div>
        <div class="card-footer py-2 bg-light d-flex justify-content-between align-items-center border-top">
            <span>Total Pendapatan</span>
            <span>{{ rupiah($gaji->bruto) }}</span>
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
                @if ($gaji->bpjs_kes_u > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    BPJS Kesehatan
                    <span>{{ rupiah($gaji->bpjs_kes_u) }}</span>
                </li>
                @endif
                @if ($gaji->bpjs_tk_u > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    BPJS Ketenagakerjaan
                    <span>{{ rupiah($gaji->bpjs_tk_u) }}</span>
                </li>
                @endif
                @if ($gaji->pt_absen > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Potongan Kehadiran
                    <span>{{ rupiah($gaji->pt_absen) }}</span>
                </li>
                @endif
                @if ($gaji->pt_kasbon > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Potongan Kasbon
                    <span>{{ rupiah($gaji->pt_kasbon) }}</span>
                </li>
                @endif
                @if ($gaji->pt_lainnya > 0)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    Potongan Lainnya
                    <span>{{ rupiah($gaji->pt_lainnya) }}</span>
                </li>
                @endif
            </ul>
        </div>
        <div class="card-footer py-2 bg-light d-flex justify-content-between align-items-center border-top">
            <span>Total Potongan</span>
            <span>{{ rupiah($gaji->total_pot) }}</span>
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
            <h2 class="text-center text-danger mb-0">{{ rupiah($gaji->netto) }}</h2>
        </div>
        <div class="card-footer py-2 text-center bg-light border-top">
            <span class="font-size-11"><i>Terbilang : {{ terbilang($gaji->netto) }} rupiah</i></span>
        </div>
    </div>
</section>
<section class="pt-0 pb-2 px-2 m-0">
    <div class="card mb-2">
        <div class="d-flex">
            <div class="col-12 pr-0">
                <a href="{{ route("payslip.download", ['id' => $gaji->id_pay]) }}" class="btn btn-warning text-black waves-effect btn-label waves-light fw-bold w-100"><i class="label-icon fa fa-download"></i>&nbsp; Download Slip Gaji</a>
            </div>
        </div>
    </div>
    <p class="font-size-11 mt-3 mb-0">
        <i>Dicetak dengan Smartwork App - <b>Solusi Digital HR Perusahaan</b> <br>
        Slip gaji ini tidak membutuhkan tanda tangan.</i>
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
