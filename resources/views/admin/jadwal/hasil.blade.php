@extends('layouts.main')

@section('title')
    Jadwal Kerja Pegawai
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
    <style>
        .main-content {
            overflow: visible !important;
        }

        .topnav {
            margin-top: 0px !important;
        }

        .row_sticky {
            justify-content: space-around;
            align-items: flex-start;
        }

        .div_sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 120px;
            z-index: 90;
        }

        .choices__list--dropdown .choices__item {
            font-size: 11px !important;
        }

        .f-8 {
            font-size: 10px !important;
        }

        .table>:not(caption)>*>* {
            padding: 0.35rem 0.35rem !important;
        }
        .card-header { background:#B0141C !important; }
    </style>
@endpush


@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cuti.index') }}">Jadwal Kerja</a></li>
                        <li class="breadcrumb-item active">Lihat Jadwal Kerja Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Jadwal Kerja Pegawai {{ BulanTahun($tahun."-".$bulan) }}</h4>
                    <p class="text-muted mt-1 text-opacity-50">Lihat data jadwal kerja pegawai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row row_sticky">
        <div class="col-12 div_sticky">
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <form id="formAction" action="{{ route("jadwal.cari") }}" method="POST">
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
                                        <option  @if($r_cabang->id == $cb) selected @endif value='{{ $r_cabang->id }}'>{{ $r_cabang->cabang_nama }}</option>
                                        @endforeach
                                        {{-- <option @if($cb == "all") selected @endif value='all'>Semua Lokasi Kerja</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                    <select required id="tahun" class="form-select" name="tahun">
                                        @for ($t = 2021; $t <= 2030; $t++)
                                        <option @if($t == $tahun) selected @endif value='{{ $t }}'>{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                    <select required id="bulan" class="form-select" name="bulan">
                                        @for ($b = 1; $b <= 12; $b++)
                                        <option @if($b == $bulan) selected @endif value='{{ $b }}'>{{ $b.": ".Bulan($b) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 d-flex align-items-end">
                                <button class="btn btn-warning text-black w-100 mt-1 font-weight-boldest btn-md" type="submit">
                                    <i class="fas fa-info-circle icon-md"></i> Lihat Data
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12" id="content">
            @php
                if ($cb != "all") {
                    $dt_cb = App\Models\Cabang::where('id', $cb)->get(); }
                else {
                    $dt_cb = App\Models\Cabang::where('cabang_status', 'Active')->where('id_admin', Auth::user()->id)->get(); }
            @endphp
            @php $jum_hari = Carbon\Carbon::createFromFormat('m-Y', $bulan.'-'.$tahun)->daysInMonth; @endphp
            @foreach ($dt_cb as $c)
            <div class="card shadow rounded-sm">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title text-white mb-0 mt-2">Lokasi Kerja {{ $c->cabang_nama }}</h5>
                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download icon-sm"></i>&nbsp; Ekspor Data <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                            <a class="dropdown-item" href="{{ route("jadwal.ekspor", ['cb'=>$cb, 'bl'=>$bulan, 'th'=>$tahun]) }}">File Excel</a>
                            <a class="dropdown-item" href="#">File PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-4 table-responsive">
                    <table class="table table-bordered table-edits table-editable">
                        <thead class="table-dark">
                            <tr>
                                <th class="align-middle" style="width:350px !important;">Nama Pegawai</th>
                                @for ($i = 1; $i <= $jum_hari; $i++)
                                    <th width="2%" class="align-middle f-8 text-center">{{ $i }}</th>
                                @endfor
                                <th class="align-middle f-8 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $nomor = 1;@endphp
                            @foreach (App\Models\User::where('id_cabang', $c->id)->get() as $i)
                            <tr data-id="{{ $i->id }}">
                                <td class="align-middle f-8" style="width:350px !important;">{{ $i->nama }}</td>
                                @for ($j = 1; $j <= $jum_hari; $j++)
                                    @php
                                        $id_user    = $i->id;
                                        $ada        = false;
                                        $data_shift = NULL;
                                        foreach ($data as $item) {
                                            $id_user_shift = $item->id_user;
                                            $tanggal_shift = TanggalOnly($item->tanggal_shift);
                                            if ($id_user_shift == $id_user && $j == $tanggal_shift) {
                                                $ada        = true;
                                                $data_shift = $item;
                                            }
                                        }
                                    @endphp
                                    @if ($ada)
                                        <td data-field="shift" class="align-middle f-8 text-center" style="width:2.5% !important;"><a href="javascript:void(0);" data-toggle="tooltip" title="{{ $data_shift->ket_shift." ".TampilJamMenit($data_shift->hadir_shift)." - ".TampilJamMenit($data_shift->pulang_shift) }}"> {{ $data_shift->shift->nama_shift }}</a></td>
                                    @else
                                        <td data-field="shift" class="align-middle f-8 text-center" style="width:2.5% !important;">-</td>
                                    @endif
                                @endfor
                                <td>
                                    <a href="{{ route("jadwal.atur", ['usr' => $i->id, 'bl' => $bulan, 'th' => $tahun]) }}" class="btn btn-sm btn-soft-warning waves-effect waves-light" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
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
