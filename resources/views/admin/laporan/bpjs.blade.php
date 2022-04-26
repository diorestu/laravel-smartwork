@extends('layouts.main')

@section('title')
    Laporan Absensi Pegawai
@endsection

@push('addon-style')
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .f-10 { font-size: 10px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .text-tipis  { font-weight: 300; opacity: 0.5; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">BPJS</a></li>
                        <li class="breadcrumb-item active">Simulasi Iuran BPJS</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Simulasi Iuran BPJS</h4>
                    <p class="text-muted mt-1 text-opacity-50">Kalkulator untuk menghitung berapa iuran BPJS yang harus dibayarkan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="{{ route('ekspor.laporan.cuti') }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="form-group mb-sm-2">
                                    <label for="waktu">Masukkan Nilai Gaji Pokok <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1 mb-md-0" id="nilai" name="nilai" value="">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group mb-sm-2">
                                    <label for="waktu">Tipe Iuran <span class="text-danger">*</span></label>
                                    <select name="" id="" class="form-select">
                                        <option value="">JHT</option>
                                        <option value="">JKK</option>
                                        <option value="">JP</option>
                                        <option value="">JKP</option>
                                        <option value="">Pilih Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 d-flex align-items-end">
                                <button class="btn btn-success text-white w-100 mt-1 font-weight-boldest btn-md text-black mb-2" type="submit">
                                    <i class="fas fa-info-circle icon-md"></i> Hitung
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-custom rounded-sm shadow-md p-4">
                <table class="table">
                    <thead class="table-dark border border-secondary">
                        <tr>
                            <th>Gaji Pokok</th>
                            <th>JHT</th>
                            <th>JP</th>
                            <th>JKK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Rp. 3.500.000</th>
                            <td>Rp. 128.000</td>
                            <td>Rp. 60.000</td>
                            <td>Rp. 35.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable2').DataTable({
                lengthMenu: [30, 60, 120, 240],
                order: [[0, 'asc']]
            });
        });
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var hari = $("#waktu").val();
            var formData = new FormData(this);
            if (hari != "") {
                var url = "{{ route('ekspor.laporan.bpjs') }}";
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
                        console.log(result)
                        // $('#content').html(result);
                    },
                    complete: function(data) {
                        Swal.close();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                Swal.fire('Maaf','Silahkan pilih rentang waktu terlebih dahulu.','error');
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





