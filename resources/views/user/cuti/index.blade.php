@extends('layouts.mobile')

@section('title')Cuti | Smartwork @endsection

@push('addon-style')
@endpush

@section('content')
    <section class="p-0 mb-2">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Cuti</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="d-flex px-2 mb-2">
        <div class="col-4">
            <div class="card bg-light text-center p-2 mx-1 mb-0">
                <blockquote class="card-blockquote font-size-12 mb-0">
                    <p class="badge bg-success fw-regular mb-1 text-white px-2 py-1">Cuti Tahunan</p>
                    <h2 id="jc" class="font-size-23 fw-bold text-dark">{{ $jc }} Hari</h2>
                </blockquote>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-light text-center p-2 mx-1 mb-0">
                <blockquote class="card-blockquote font-size-12 mb-0">
                    <p class="badge bg-danger fw-regular mb-1 text-white px-2 py-1">Telah Digunakan</p>
                    <h2 id="jumcuti" class="font-size-23 fw-bold text-dark">{{ $jumcuti }} Hari</h2>
                </blockquote>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-light text-center p-2 mx-1 mb-0">
                <blockquote class="card-blockquote font-size-12 mb-0">
                    <p class="badge bg-warning fw-regular mb-1 text-black px-2 py-1">Sisa Cuti</p>
                    <h2 id="sisacuti" class="font-size-23 fw-bold text-dark">{{ $sisacuti }} Hari</h2>
                </blockquote>
            </div>
        </div>
    </section>

    <section class="px-2 mb-2">
        <div class="card mb-2">
            <form id="formAction" action="#" method="POST">
                @method('POST')
                @csrf
                <div class="d-flex">
                    <div class="col-12 pr-0 input-group">
                        <div class="input-group-text"><i class="font-size-18 bx bx-filter-alt"></i></div>
                        <select class="form-control" name="hari" id="example-month-input">
                            @for($tahun = date("Y"); $tahun >= (date("Y")-2); $tahun--)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="card mb-2">
            <div class="d-flex">
                <div class="col-12 pr-0">
                    <a href="{{ route("leave.create") }}" class="btn btn-primary waves-effect btn-label waves-light fw-light w-100 rounded-sm"><i class="label-icon fa fa-plus-circle"></i>&nbsp; Ajukan Cuti</a>
                </div>
            </div>
        </div>
        <div id="content" class="card table-responsive rounded">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush">
                    @forelse($data as $item)
                    <li class="list-group-item px-2 py-1 mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="fw-bold font-size-12 mb-1">{{ $item->cutiJenis->cuti_nama_jenis }}</p>
                            <p class="fw-regular font-size-12 text-muted mb-1">{{ tglIndo4($item->cuti_awal) }} - {{ tglIndo4($item->cuti_akhir) }}</p>
                            @if ($item->cuti_status == "DITOLAK")
                                <p class="fw-regular font-size-12 text-danger mb-1">{{ $item->cuti_status }}</p>
                            @elseif($item->cuti_status == "DITERIMA")
                                <p class="fw-regular font-size-12 text-success mb-1">{{ $item->cuti_status }}</p>
                            @else
                                <p class="fw-regular font-size-12 text-primary mb-1">{{ $item->cuti_status }}</p>
                            @endif
                        </div>
                        <a href="{{ route("leave.show", $item->id_cuti) }}" class="btn btn-sm btn-outline-danger">Detail</a>
                    </li>
                    @empty
                    <li class="list-group-item px-2 py-3 mb-2">
                        <div class="text-center">
                            <p class="fw-bold font-size-14 mb-1">Belum ada cuti yang diambil</p>
                            <p class="fw-regular font-size-12 text-muted mb-1">Semua cuti yang kamu ajukan akan tampil disini</p>
                        </div>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
@endsection

@push('addon-script')
<script>
    $('#example-month-input').change(function() {
        var url = "{{ route('leave.riwayat') }}";
        var date = $(this).val();
        if (date != "") {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                url: url,
                data: {'hari': date},
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
                    const jresult = JSON.parse(result);
                    $('#content').html(jresult.content);
                    $('#jc').html(jresult.jc);
                    $('#jumcuti').html(jresult.jumcuti);
                    $('#sisacuti').html(jresult.sisacuti);
                },
                complete: function(data) {
                    Swal.close();
                }
            });
        } else {
            Swal.fire('Maaf','Silahkan pilih periode terlebih dahulu.','error');
        }
    });
</script>
@if (Session::has('success'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.success('{{ \Session::get('success') }}');
        // Swal.fire('Berhasil', '{{ \Session::get('success') }}', 'success')
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        alertify.set('notifier','position', 'top-right');
        alertify.error('{{ \Session::get('error') }}');
        // Swal.fire('Gagal', '{{ \Session::get('error') }}', 'error')
    </script>
@endif
@endpush
