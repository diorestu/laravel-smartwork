@extends('layouts.main')

@section('title')
    Pengaturan Sistem
@endsection

@push('addon-style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="{{ asset('backend-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .f-10 { font-size: 10px !important; }
        .card-header, .modal-header { background: rgb(219,66,66); background: linear-gradient(90deg, rgba(219,66,66,1) 0%, rgba(126,7,30,1) 100%); }
        .filter_wp span { font-weight: bold; margin-bottom: 10px; display:block; }
        .text-tipis  { font-weight: 300; opacity: 0.5; }
        .main-content { overflow: visible !important; }
        .topnav { margin-top: 0px !important; }
        .row_sticky { justify-content: space-around; align-items: flex-start; }
        .div_sticky { position: -webkit-sticky; position: sticky; top: 150px; }
        .choices__list--dropdown .choices__item { font-size: 11px !important; }
        .pro-text { letter-spacing: 0.3px; background: linear-gradient(120deg,#ff725c,#dbb118); -webkit-background-clip: text; color: transparent !important; }
    </style>
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pengaturan Sistem</a></li>
                    </ol>
                    <h4 class="fw-bold font-size-22 mt-3 mb-3">Pengaturan Sistem</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row row_sticky">
        <div class="col-4 div_sticky">
            @if ($data->tipe_akun == "Basic")
            <div class="card bg-warning border-dark text-black">
                <div class="card-body">
                    <h5 class="mb-4 text-black"><i class="mdi mdi-alert-circle-outline me-3"></i>Basic Version</h5>
                    <p class="card-text">Akun Anda masih menggunakan versi basic Smartwork. Upgrade Smartwork Anda ke Pro Version
                        untuk mendapatkan fitur-fitur lainnya.
                    </p>
                </div>
            </div>
            @else
            <div class="card border-dark">
                <div class="card-body d-flex">
                    <div>
                        <img src="{{ asset("backend-assets/images/sw-pro.svg") }}" width="80" />
                    </div>
                    <div class="mt-3 px-3">
                        <h3 class="mb-1 text-light pro-text">Pro Version</h3>
                        <p class="card-text">Smartwrok Pro - Unlimited Access</p>
                    </div>
                </div>
            </div>
            @endif
            <div class="card card-custom rounded-sm shadow-md">
                <div class="card-body px-4 py-4">
                    <h4 class="card-title my-3 ms-3">Akun Smartwork</h4>
                    <div class="table-responsive">
                        <table class="table mb-3">
                            <tbody>
                                <tr>
                                    <td>Max User</td>
                                    <td>{{ $data->max_user }}</td>
                                </tr>
                                <tr>
                                    <td>Tipe Akun</td>
                                    <td>{{ $data->tipe_akun }}</td>
                                </tr>
                                <tr>
                                    <td>Aktif Sampai</td>
                                    <td>{{ tanggalIndo($data->expired_at) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($data->tipe_akun == "Basic") <a href="#" class="btn btn-block w-100 btn-primary">Upgrade ke Pro</a> @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-custom gutter-b rounded-sm shadow-sm">
                <div class="card-body px-4 py-4">
                    <h4 class="card-title my-2 ms-0">Pengaturan Lokasi Kerja</h4>
                    <div class="list-group mb-3 py-3">
                        @foreach($data_cabang as $dc)
                            <a href="{{ route("config.show", $dc->id) }}" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">{{ $dc->cabang_nama }} <i class="fa fa-chevron-right"></i></a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card card-custom gutter-b rounded-sm shadow-sm">
                <div class="card-body px-4 py-4">
                    <h4 class="card-title my-2 ms-0">Pengaturan Tampilan</h4>
                        <div class="form-check form-switch form-switch-lg mb-3 py-3">
                            <label class="form-check-label" for="customSwitchsizemd">Dark Mode</label>
                            <input id="mode" name="mode" {{ auth()->user()->config->layout_mode == 'dark' ? 'checked' : ''  }} type="checkbox" class="form-check-input layout-mode-switch">
                        </div>
                        <div id="content"></div>
                </div>
            </div>
            <div class="card card-custom gutter-b rounded-sm shadow-sm">
                <div class="card-body px-4 py-4">
                    <h4 class="card-title my-2 ms-0">Pengaturan Umum</h4>
                    <div class="col-12">
                        <form method="POST" action="#" id="formSetting" class="py-3">
                            @csrf
                            @method('PUT')
                            <div class="row mb-4">
                                <label for="company_name" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                                <div class="col-sm-9"><input type="text" class="form-control" name="company_name" value="{{ $data->company_name }}"></div>
                            </div>
                            <div class="row mb-4">
                                <label for="company_address" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9"><input type="text" class="form-control" name="company_address" value="{{ $data->company_address }}"></div>
                            </div>
                            <div class="row mb-4">
                                <label for="company_phone" class="col-sm-3 col-form-label">Telepon</label>
                                <div class="col-sm-9"><input type="text" class="form-control" name="company_phone" value="{{ $data->company_phone }}"></div>
                            </div>
                            <div class="row mb-4">
                                <label for="company_email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9"><input type="email" class="form-control" name="company_email" value="{{ $data->company_email }}"></div>
                            </div>
                            <div class="row mb-4">
                                <label for="company_bidang" class="col-sm-3 col-form-label">Bidang Usaha</label>
                                <div class="col-sm-9">
                                    <select required id="company_bidang" class="form-select" name="company_bidang">
                                        <option value='Pengelolaan SDM'>Pengelolaan SDM</option>
                                        <option value='Teknologi Informasi'>Teknologi Informasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="company_" class="col-sm-3 col-form-label">Logo Perusahan</label>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-9">
                                    <div><button type="submit" class="btn btn-warning text-black w-md"><i class="fa fa-save"></i>&nbsp; Simpan Perubahan</button></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('backend-assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        const elementBidang = document.querySelector('#company_bidang');
        const choices = new Choices(elementBidang);
        $(".layout-mode-switch").change(function() {
            if(this.checked) {
                document.body.setAttribute("data-layout-mode",  "dark");
                document.body.setAttribute("data-topbar",       "dark");
                document.body.setAttribute("data-sidebar",      "dark");
            }
            else {
                document.body.setAttribute("data-layout-mode",  "light");
                document.body.setAttribute("data-topbar",       "dark");
                document.body.setAttribute("data-sidebar",      "light");
            }
            var modelayout = $(this).prop('checked') == true ? "dark" : "light";
            var url = "{{ route('config.updateLayout', auth()->user()->id) }}";
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: {'mode': modelayout},
                success: function(response) {
                    console.log(response);
                }
            });
        });
        $('#formSetting').submit(function(e) {
            e.preventDefault();
            var formData    = new FormData(this);
            var url         = "{{ route('config.update', auth()->user()->id) }}";
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
                    if (result == "ok") {
                        console.log(formData);
                        Swal.fire('Berhasil','Proses update data pengaturan berhasil.','success');
                    } else {
                        Swal.fire('Gagal','Proses update data tidak berhasil.','error');
                    }
                },
                complete: function(data) {
                    // Swal.close();
                },
                cache: false,
                contentType: false,
                processData: false
            });
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
