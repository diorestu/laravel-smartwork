@extends('layouts.main')

@section('title')
    Detail Informasi Pegawai
@endsection

@push('addon-style')
    <style>
        .card-header { background: rgb(219,66,66); background: linear-gradient(90deg, rgba(219,66,66,1) 0%, rgba(126,7,30,1) 100%); }
    </style>
@endpush

@section('content')
    <div class="main-content mx-0">
        <div class="page-content mt-0 pt-0">
            <div class="row">
                <div class="col-xl-12">
                    <div class="profile-user"></div>
                </div>
            </div>

            <div class="row">
                <div class="profile-content">
                    <div class="row align-items-end">
                        <div class="col-sm">
                            <div class="d-flex align-items-end mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xxl me-3">
                                        <img src="{{ $data->company_logo == '' ? asset('backend-assets/images/no-image.png') : asset('storage/logo/' . Auth::user()->company_logo) }}"
                                            alt="" class="img-fluid rounded-circle d-block img-thumbnail">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h3 class="font-size-25 mb-1">
                                            {{ $data->nama }}
                                            @if ($data->status == 'active')
                                                &nbsp; <span><i class="fas text-primary fa-check-circle icon-sm"></i></span>
                                            @else
                                                &nbsp; <span><i class="fas text-warning fa-exclamation-circle icon-sm"></i></span>
                                            @endif
                                        </h3>
                                        <p class="text-muted font-size-13 mb-2 pb-2">NIP : {{ $data->nip }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                                <div>
                                    <a href="{{ route('pegawai.edit', $data->id) }}" class="btn btn-soft-primary me-2"><i data-feather="edit-3"
                                            class="me-1"></i> Edit Data</a>
                                    @if ($data->status == 'active')
                                        <a href="{{ route('pegawai.nonactive', $data->id) }}" class="btn btn-danger"><i data-feather="x-circle" class="font-size-14 me-1"></i> Nonaktifkan</a>
                                    @else
                                        <a href="{{ route('pegawai.active', $data->id) }}" class="btn btn-success"><i data-feather="check" class="font-size-14 me-1"></i> Aktifkan</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab"
                                        aria-selected="true">Data Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#akun" role="tab"
                                        aria-selected="false">Data Akun</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#asuransi" role="tab"
                                        aria-selected="false">Data Asuransi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3" data-bs-toggle="tab" href="#tunjangan" role="tab"
                                        aria-selected="false">Data Tunjangan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="tab-content">
                        <!-- DATA DIRI -->
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-white mb-0">Data Diri Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 15%;">Nama</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>{{ $data->nama }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>NIP</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->nip }}</b></td>
                                                </tr>

                                                <tr>
                                                    <td>Mulai Kerja</td>
                                                    <td>:</td>
                                                    <td><b>{{ tanggalIndo($data->tanggal_mulaiKerja) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Masa Kerja</td>
                                                    <td>:</td>
                                                    <td><b>{{ masaKerja($data->tanggal_mulaiKerja) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->gender }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Perkawinan</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->status_kawin->status_kawin }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>No. HP</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->phone }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->email }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->alamat }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DATA AKUN -->
                        <div class="tab-pane" id="akun" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-white card-title mb-0">Data Akun Pegawai</h5>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 18%;">Username</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>{{ $data->username }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Akun</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if ($data->status == 'active')
                                                            <span><i class="fas text-success fa-check-circle icon-sm"></i></span> Aktif
                                                        @else
                                                            <span><i class="fas text-warning fa-exclamation-circle icon-sm"></i></span> Non Aktif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Divisi</td>
                                                    <td>:</td>
                                                    <td><b>@if ($data->id_divisi != null) {{ $data->divisi->div_title }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Jabatan</td>
                                                    <td>:</td>
                                                    <td><b>@if ($data->id_jabatan != null) {{ $data->jabatan->jabatan_title }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Sertifikasi</td>
                                                    <td>:</td>
                                                    <td><b>@if ($data->id_sertifikasi != null) {{ $data->sertifikasi->sertifikasi_title }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Lokasi Absensi Kantor</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->cabang->cabang_nama }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Company</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->company }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening</td>
                                                    <td>:</td>
                                                    <td><b>{{ $data->no_rek }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DATA ASURANSI -->
                        <div class="tab-pane" id="asuransi" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-white card-title mb-0">Data Asuransi Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3"><h5>Kesehatan</h5></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;">Status</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td>
                                                        @if ($dataAsuransi != '')
                                                            @if ($dataAsuransi->status_nakes == 'y')
                                                                <span><i class="fas text-success fa-check-circle icon-sm"></i></span> Aktif
                                                            @else
                                                                <span><i class="fas text-warning fa-exclamation-circle icon-sm"></i></span> Non Aktif
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;">Nomor Terdaftar</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataAsuransi != '') {{ $dataAsuransi->nomor_nakes }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;">Potongan</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataAsuransi != '') {{ $dataAsuransi->pot_nakes }}% dari gaji pokok @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><br><h5>Ketengakerjaan</h5></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;">Status</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td>
                                                        @if ($dataAsuransi != '')
                                                            @if ($dataAsuransi->status_naker == 'y')
                                                                <span><i class="fas text-success fa-check-circle icon-sm"></i></span> Aktif
                                                            @else
                                                                <span><i class="fas text-warning fa-exclamation-circle icon-sm"></i></span> Non Aktif
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;">Nomor Terdaftar</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataAsuransi != '') {{ $dataAsuransi->nomor_naker }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;">Potongan</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataAsuransi != '') {{ $dataAsuransi->pot_naker }}% dari gaji pokok @endif</b></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DATA TUNJANGAN -->
                        <div class="tab-pane" id="tunjangan" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-white card-title mb-0">Data Tunjangan Pegawai</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Jabatan</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_jabatan) }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Sertifikasi</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_sertifikasi) }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Transport</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_transport) }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Kosmetik</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_kosmetik) }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Makan</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_makan) }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Masa Kerja</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_masaKerja) }} @endif</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Tunjangan Status Kawin</td>
                                                    <td style="width: 5%;">:</td>
                                                    <td><b>@if ($dataTunjangan != '') {{ rupiah($dataTunjangan->tj_statusKawin) }} @endif</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
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
