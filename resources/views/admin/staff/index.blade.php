@extends('layouts.main')

@section('title')
    Data Pegawai
@endsection

@push('addon-style')
    <!-- DataTables -->
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    <div class="row px-4">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Pegawai</h4>
                    <p class="text-muted text-opacity-50">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem, doloribus.</p>
                </div>
                <div class="page-title-right align-self-end">
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn-soft-primary waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp;Impor/Ekspor Data</a>
                        {{-- <a class="btn btn-soft-success waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp; Data</a> --}}
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fa fa-plus icon-sm text-white"></i>
                            Tambah Pegawai&nbsp;
                        </button>
                        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('pegawai.store') }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                                        </div>
                                        <div class="modal-body p-4">
                                            @if ($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            @endif
                                            <div data-scroll="true" data-height="400">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="my-input">Nama Pegawai</label>
                                                            <input id="my-input" class="form-control" type="text" name="nama">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Nomor Induk Pegawai</label>
                                                            <input id="my-input" class="form-control" type="text" name="nip">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="cabang">Lokasi Kerja</label>
                                                            <select id="cabang" class="form-select" name="id_cabang">
                                                                @foreach (App\Models\Cabang::where('id_admin', auth()->user()->id)->get() as $i)
                                                                    <option value='{{ $i->id }}'>{{ $i->cabang_nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Username Pegawai</label>
                                                            <input id="my-input" class="form-control" type="text" name="username">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Kata Sandi Pegawai</label>
                                                            <input id="my-input" class="form-control" type="text" name="password">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Jenis Kelamin Pegawai</label>
                                                            <select id="my-select" class="form-select" name="gender">
                                                                <option value='Pria'>Pria</option>
                                                                <option value='Wanita'>Wanita</option>
                                                            </select>
                                                        </div>
                                                        {{-- <div class="mb-2">
                                                        <label for="my-input">Username Pegawai</label>
                                                        <input id="my-input" class="form-control" type="text" name="password">
                                                    </div> --}}
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-4">
                                                            <label for="my-input">E-mail Pegawai</label>
                                                            <input id="my-input" class="form-control" type="text" name="email">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Alamat Pegawai</label>
                                                            <textarea id="my-textarea" class="form-control" name="alamat" rows="1"></textarea>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">No. HP Pegawai</label>
                                                            <input id="my-input" class="form-control" type="text" name="phone">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="tanggungan">Tanggungan Pegawai</label>
                                                            <select id="tanggungan" class="form-select" name="tanggungan">
                                                                <option value='TK/0'>TK/0</option>
                                                                <option value='K/0'>K/0</option>
                                                                <option value='K/1'>K/1</option>
                                                                <option value='K/2'>K/2</option>
                                                                <option value='K/3'>K/3</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="my-input">Tanggal Mulai Kerja</label>
                                                            <input id="my-input" class="form-control" type="date" name="tanggal_mulaiKerja">
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
            </div>
        </div>
    </div>
    <div id="alert">
        @if (Session::has('success'))
        <div class="alert alert-success py-4 fade-message alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="fa fa-info-circle"></i>
            <strong>Berhasil!</strong> - {{ \Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

            <script>
            $(function(){
                setTimeout(function() {
                    $('.fade-message').close();
                }, 2000);
            });
            </script>
        @endif
    </div>
    <div class="card card-custom gutter-b rounded-sm shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">

                <table class="table table-hover" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="">NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Lokasi</th>
                            {{-- <th width="">Email</th> --}}
                            <th width="">No. HP</th>
                            <th width="">Username</th>
                            <th width="">Status</th>
                            <th width="5%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i)
                            <tr>
                                <td class='text-primary font-weight-bolder'>{{ $i->nip }}</td>
                                <td>{{ $i->nama }}</td>
                                <td><span class="font-weight-boldest">{{ $i->cabang->cabang_nama }}</span></td>
                                {{-- <td>{{ $i->email }}</td> --}}
                                <td>{{ $i->phone }}</td>
                                <td>{{ $i->username }}</td>
                                <td><span class="badge rounded-pill
                                        @if ($i->status == 'active')
                                            bg-success
                                        @else
                                            bg-danger
                                        @endif">{{ $i->status }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" href='{{ route('pegawai.show', $i->id) }}'>
                                                <span><i class="fas fa-info-circle icon-sm"></i></span>&nbsp;
                                                Detail
                                            </a></li>
                                            <li><form action="{{ route('pegawai.destroy', $i->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa fa-trash text-danger me-2"></i>
                                                    <b>Hapus</b>
                                                </button>
                                            </form></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    {{-- <script src="{{ asset('backend-assets/js/pages/form-advanced.init.js') }}"></script> --}}
    <script>
        const element = document.querySelector('#tanggungan');
        const choices = new Choices(element);
    </script>
    <script>
        const element2 = document.querySelector('#cabang');
        const choices2 = new Choices(element2);
    </script>
    <!-- Required datatable js -->
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [30, 60, 150, 300],
                columnDefs: [
                    { searchable: false, targets: 0 },
                    { orderable: false, searchable: false, targets: 5 },
                    { orderable: false, searchable: false, targets: 6 },
                  ],
                  order: [[0, 'asc']]
            });
        })
    </script>
@endpush
