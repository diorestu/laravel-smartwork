@extends('layouts.main')

@section('title')
    Laporan Pembayaran Pajak PPh 21 Pegawai | Smartwork App
@endsection

@push('addon-style')
    <style>
        .f-10 { font-size: 10px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .text-tipis  { font-weight: 300; opacity: 0.5; }
        .card-header { background:#B0141C !important; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("laporan.bpjs") }}">Pajak PPh 21</a></li>
                        <li class="breadcrumb-item active">Perhitungan Pajak PPh 21 Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-3 fw-bold font-size-22 mt-3">Perhitungan Pajak PPh 21 Pegawai</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="staff">Pilih Lokasi Kerja <span class="text-danger">*</span></label>
                                    <select required id="cabang" class="form-select" name="id_cabang">
                                        @php
                                            $q_cabang = App\Models\Cabang::where('id_admin', auth()->user()->id)->get();
                                        @endphp
                                        @foreach ($q_cabang as $r_cabang)
                                        <option value='{{ $r_cabang->id }}'>{{ $r_cabang->cabang_nama }}</option>
                                        @endforeach
                                        <option value='all'>Semua Lokasi Kerja</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                    <select required id="tahun" class="form-select" name="tahun">
                                        @for ($t=2022;$t>=2020;$t--)
                                        <option value='{{ $t }}'>{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                    <select required id="bulan" class="form-select" name="bulan">
                                        @for ($b=1;$b<=12;$b++)
                                        <option value='{{ $b }}'>{{ $b.": ".Bulan($b) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 d-flex align-items-end">
                                <button class="btn btn-warning text-black w-100 mt-1 font-weight-boldest btn-md text-black" type="submit">
                                    <i class="fas fa-info-circle icon-md"></i> Hitung Pajak
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="content">
        <div class="col-12">
            <div class="card card-custom gutter-b rounded-sm shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center">
                        <h1><i class="fas fa-filter"></i></h1>
                        <h4>Silahkan lengkapi filter diatas</h4>
                        <p>Untuk melihat data, silahkan isi filter diatas lalu klik hitung iuran</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
     <script>
        const elementCabang = document.querySelector('#cabang');
        const choices = new Choices(elementCabang);
        const elementTahun = document.querySelector('#bulan');
        const choices2 = new Choices(elementTahun);
        const elementBulan = document.querySelector('#tahun');
        const choices3 = new Choices(elementBulan);
    </script>
    <script>
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var waktu = $("#bulan").val();
            var formData = new FormData(this);
            if (waktu != "") {
                var url = "{{ url('laporan/data-iuran-pajak') }}";
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                $.ajax({
                    url: url,
                    data: formData,
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
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                Swal.fire('Maaf','Silahkan pilih rentang waktu.','error');
            }
        });
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil','{{ \Session::get('success') }}','success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal','{{ \Session::get('error') }}','error')
        </script>
    @endif
@endpush





