@extends('layouts.main')

@section('title')
    smartwork
@endsection

@section('content')
    <div class="">
        <div class="px-4 d-flex justify-content-between">
            <div>
                <h2 class="font-weight-boldest">Data Upah Pegawai</h2>
                <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
            <div>
                <a href='{{ route('upah.create') }}' class="btn btn-primary btn-shadow">
                    <i class="fa fa-plus-circle me-2"></i>&nbsp;Tambah Upah
                    {{-- <i class="fa fa-chevron-right"></i> --}}
                </a>
            </div>
        </div>

        <div class="card card-custom gutter-b rounded-sm shadow-md">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="">Pilih Cabang</label>
                            <select id="select-cabang" class="form-select w-100" name="">
                                @foreach (App\Models\Cabang::where('id_admin', auth()->user()->id)->get() as $c)
                                    <option value="{{ $c->id }}">{{ $c->cabang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-self-end">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search me-3"></i>Cari Data Upah</button>
                    </div>
                    <div class="col-5"></div>
                </div>
                <hr>
                {{-- @foreach (App\Models\Cabang::where('id_admin', auth()->user()->id)->get() as $c)
                <div class="table-responsive py-2">
                    <h4 class="fw-bold pb-3">{{ $c->cabang_nama }}</h4>
                    <table class="table shadow" id="myTable">
                        <thead class='table-dark'>
                            <tr>
                                <th width='4%' class="text-center">No</th>
                                <th>Nama</th>
                                <th width='25%'>Nama Cabang</th>
                                <th width='25%' class="text-center">Gaji Pokok</th>
                                <th width='10%' class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $item)
                                @if ($c->id == $item->id_cabang)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $c->cabang_nama }}</td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ number_format($item->gaji_pokok) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href='{{ route('upah.edit', $item->id) }}'><span class="text-primary font-weight-bolder">
                                            <i class="fa fa-pen icon-sm text-primary"></i>
                                            Ubah</span>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                @endforeach --}}
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select-cabang').select2();
    });
</script>
@endpush



