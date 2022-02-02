@extends('layouts.admin')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="pt-8 px-10">
            <div class="card card-custom mb-12">
                <div class="card-body rounded p-0 d-flex">
                    <div class="d-flex flex-column flex-lg-row-auto w-auto w-lg-350px w-xl-450px w-xxl-500px p-10 p-md-20">
                        <h1 class="font-weight-bolder text-dark">Lihat Jadwal Kerja</h1>
                        <div class="font-size-h4 mb-8">Cari berdasarkan Periode Bulan Kerja</div>
                        <!--begin::Form-->
                        <form class="d-flex py-2 bg-white rounded" action="{{ route('cari.jadwal') }}" method="post">
                            @method('POST')
                            @csrf
                            <select id="my-select" class="form-control form-control-solid mr-5" name="bulan">
                                <option selected disabled>Pilih Periode</option>
                                <option value='01'>Januari</option>
                                <option value='02'>Februari</option>
                                <option value='03'>Maret</option>
                                <option value='04'>April</option>
                                <option value='05'>Mei</option>
                                <option value='06'>Juni</option>
                                <option value='07'>Juli</option>
                                <option value='08'>Agustus</option>
                                <option value='09'>September</option>
                                <option value='10'>Oktober</option>
                                <option value='11'>November</option>
                                <option value='12'>Desember</option>
                            </select>
                            <button class="btn btn-icon btn-danger px-10" type="submit">
                                <i class="fa fa-search icon-md"></i> &nbsp;&nbsp;Cari
                            </button>
                        </form>
                        <!--end::Form-->
                    </div>
                    <div class="d-none d-md-flex flex-row-fluid bgi-no-repeat bgi-position-y-center bgi-position-x-left bgi-size-cover"
                        style="background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/illustrations/progress.svg);">
                    </div>
                </div>
            </div>

            <!-- Modal-->
            <div class="modal fade" id="crudModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('pegawai.store') }}" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div data-scroll="true" data-height="400">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="my-input">Nama Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Nomor Induk Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="nip">
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Lokasi Kerja</label>
                                                <select id="my-select" class="form-control" name="id_cabang">
                                                    @foreach (App\Models\Cabang::where('id_admin', auth()->user()->id)->get() as $i)
                                                        <option value='{{ $i->id }}'>{{ $i->cabang_nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Username Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="username">
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Kata Sandi Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="password">
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="my-input">Username Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="password">
                                            </div> --}}
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="my-input">E-mail Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Alamat Pegawai</label>
                                                <textarea id="my-textarea" class="form-control" name="alamat"
                                                    rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">No. HP Pegawai</label>
                                                <input id="my-input" class="form-control" type="text" name="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Tanggungan Pegawai</label>
                                                <select id="my-select" class="form-control" name="tanggungan">
                                                    <option value='TK/0'>TK/0</option>
                                                    <option value='K/0'>K/0</option>
                                                    <option value='K/1'>K/1</option>
                                                    <option value='K/2'>K/2</option>
                                                    <option value='K/3'>K/3</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="my-input">Tanggal Mulai Kerja</label>
                                                <input id="my-input" class="form-control" type="date" name="nama">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-light-danger font-weight-bold"
                                    data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger font-weight-bolder">
                                    <i class="fa fa-plus icon-sm"></i>
                                    Simpan Data Pegawai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        })
    </script>
@endpush
