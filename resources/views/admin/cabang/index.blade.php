@extends('layouts.main')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
    <div class="">
        <div class="row px-2">
            <div class="col-12">
                <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                    <div>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                            <li class="breadcrumb-item active">Lokasi Kerja</li>
                        </ol>
                        <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Data Lokasi Kerja</h4>
                        <p class="text-muted text-opacity-50">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                            Voluptatem, doloribus.</p>
                    </div>
                    <div class="page-title-right align-self-end">
                        <div class="d-flex justify-content-end mb-3">
                            <a class="btn btn-soft-primary waves-effect waves-light me-2"><i
                                    class="fa fa-file-excel fa-sm"></i> &nbsp;Impor/Ekspor Data</a>
                            {{-- <a class="btn btn-soft-success waves-effect waves-light me-2"><i class="fa fa-file-excel fa-sm"></i> &nbsp; Data</a> --}}
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="fa fa-plus icon-sm text-white"></i>
                                Tambah Lokasi&nbsp;
                            </button>
                            <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('cabang.store') }}" method="post">
                                            @method('POST')
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Lokasi</h5>
                                            </div>
                                            <div class="modal-body p-4">
                                                @if ($errors->any())
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                                <div data-scroll="true" data-height="400">
                                                    <div class="mb-2">
                                                        <label for="my-input">Nama Lokasi Kerja</label>
                                                        <input id="my-input" class="form-control" type="text"
                                                            name="cabang_nama">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="my-input">No. Telp Lokasi Kerja</label>
                                                        <input id="my-input" class="form-control" type="text"
                                                            name="cabang_phone">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="my-input">Alamat Lokasi Kerja</label>
                                                        <textarea id="my-textarea" class="form-control"
                                                            name="cabang_alamat" rows="5"></textarea>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="my-input">Nilai Upah (UMR)</label>
                                                        <input id="my-input" class="form-control" type="number"
                                                            name="cabang_umk">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-2">
                                                                <label for="my-input">Latitude Lokasi</label>
                                                                <input id="my-input" class="form-control" type="number"
                                                                    name="cabang_umk">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-2">
                                                                <label for="my-input">Longitude Lokasi</label>
                                                                <input id="my-input" class="form-control" type="number"
                                                                    name="cabang_umk">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn btn-soft-danger"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-plus icon-sm"></i>
                                                    Simpan Lokasi Ini</button>
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
        <div>
            @if (Session::has('success'))
                <div id="alert"
                    class="alert alert-success py-4 fade-message alert-dismissible alert-label-icon label-arrow fade show"
                    role="alert">
                    <i class="fa fa-info-circle"></i>
                    <strong>Berhasil!</strong> - {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <script>
                    $(function() {
                        setTimeout(function() {
                                $('#alert').addClass(''));
                        }, 2000);
                    });
                </script>
            @endif
        </div>

        <div class="card card-custom gutter-b rounded-sm shadow-md">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table rounded" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama</th>
                                <th width="">Email</th>
                                <th width="">No. HP</th>
                                <th width="">Alamat</th>
                                <th width="5%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td>{{ $i->cabang_nama }}</td>
                                    <td>{{ $i->cabang_email }}</td>
                                    <td>{{ $i->cabang_phone }}</td>
                                    <td>{{ $i->cabang_alamat }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li><a class="dropdown-item" href='{{ route('cabang.show', $i->id) }}'>
                                                        <span><i class="fas fa-pen icon-sm"></i></span>&nbsp; Edit
                                                    </a></li>
                                                <li>
                                                    <form action="{{ route('cabang.destroy', $i->id) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa fa-times icon-md"></i>
                                                            <b>&nbsp;Hapus</b>
                                                        </button>
                                                    </form>
                                                </li>
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
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            })
        </script>
    @endpush
