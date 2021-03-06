@extends('layouts.main')

@section('title')
    Data Cuti Per Lokasi Kerja | Smartwork App
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css"/>
    <style>
        .main-content { overflow: visible !important; }
        .topnav { margin-top: 0px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 150px; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Cuti Pegawai</a></li>
                        <li class="breadcrumb-item active">Data Cuti per Lokasi Kerja</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Cuti per Lokasi Kerja</h4>
                    <p class="text-muted mt-1 text-opacity-50">Lihat data cuti per Lokasi Kerja</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-4 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="#" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group mb-4">
                                    <label for="staff">Pilih Pegawai <span class="text-danger">*</span></label>
                                    <select required id="cabang" class="form-select" name="id_cabang">
                                        @php
                                            $q_cabang = App\Models\Cabang::where('id_admin', auth()->user()->id)->get();
                                        @endphp
                                        @foreach ($q_cabang as $r_cabang)
                                        <option value='{{ $r_cabang->id }}'>{{ $r_cabang->cabang_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group mb-4">
                                    <label for="waktu">Rentang Waktu <span class="text-danger">*</span></label>
                                    <input required id="waktu" class="form-control daterange" type="text" name="waktu" value="">
                                </div> --}}
                            </div>
                        </div>
                        <button class="btn btn-warning text-black w-100 mt-3 font-weight-boldest btn-md" type="submit">
                            <i class="fas fa-info-circle icon-md"></i> Lihat Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8" id="content">
            <div class="card shadow rounded-sm">
                <div class="card-body px-4 py-4">
                    <div class="text-center">
                        <h1><i class="icon-sm fas fa-coffee"></i></h1>
                        <h3>Silahkan Pilih Pegawai</h3>
                        <p>Untuk melihat data, silahkan pilih pegawai lalu klik lihat data.</p>
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
        $('#formAction').submit(function(e) {
            e.preventDefault();
            var idCabang = $("#cabang").val();
            var formData = new FormData(this);
            if (idCabang != "") {
                var url = "{{ url('kelola/data-cuti-per-cabang') }}";
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
                Swal.fire('Maaf','Silahkan pilih lokasi kerja terlebih dahulu.','error');
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





