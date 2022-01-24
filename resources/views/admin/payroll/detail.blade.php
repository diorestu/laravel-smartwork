@extends('layouts.main')

@section('title')
    smartwork
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')


            <div class="px-4 d-flex justify-content-between align-items-baseline">
                <div>
                    <h2 class="font-weight-boldest">Proses Penggajian Pegawai</h2>
                    <p class="text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    </p>
                </div>
                <div class='text-right'>
                    <h5 class="font-weight-boldest">Periode</h5>
                    <h6 class="text-muted">{{ Carbon\Carbon::parse($a)->locale('id')->isoFormat('MMMM') }} 2021</h6>
                </div>
            </div>

            <div class="card card-custom rounded-lg shadow-md">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" id="myTable">
                            <thead class='thead-light'>
                                <tr>
                                    <th class='text-center font-size-md font-weight-boldest' >Nama</th>
                                    <th class='text-center font-size-md font-weight-boldest' width='11%'>Gaji Pokok</th>
                                    <th class='text-center font-size-md font-weight-boldest' width='10%'>Total Tunjangan</th>
                                    <th class='text-center text-success font-size-md font-weight-boldest' width='10%'>Bruto</th>
                                    <th class='text-center font-size-md font-weight-boldest' width='9%'>BPJS TK</th>
                                    <th class='text-center font-size-md font-weight-boldest' width='10%'>BPJS Kesehatan</th>
                                    <th class='text-center text-danger font-size-md font-weight-boldest' width='10%'>Potongan</th>
                                    <th class='text-center text-success font-size-md font-weight-boldest' width='14%'>Netto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data as $i)
                                @php
                                    $pot = $i->total_pot+$i->bpjs_kes_u+$i->bpjs_tk_u;
                                @endphp
                                    <tr>
                                        <td>&nbsp;&nbsp;{{ $i->nama }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->pay_pokok) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->total_tj) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->bruto) }}&nbsp;</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->bpjs_tk_u) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->bpjs_kes_u) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->total_pot) }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{ number_format($i->netto) }}&nbsp;</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $total += $i->netto;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="7" class="font-size-h4 text-right font-weight-boldest">GRAND TOTAL</td>
                                    <td colspan='1' class="font-size-h4 text-right font-weight-boldest">
                                        <div class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ number_format($total) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-start mt-3">
                <div class='pl-3'>
                    <em class='font-size-10 text-muted font-italic'>*Apabila ada proses perubahan nilai upah, bisa
                        diupdate setelah proses submit penggajian selesai</em>
                </div>
                <div class="text-right">
                    <a class="btn btn-success px-4 fw-bold">Submit Penggajian</a>&nbsp;
                    <a href='javascript: history.back();' class="btn btn-soft-danger px-3 fw-bold"><i
                            class="fa fa-chevron-left icon-sm"></i>Kembali</a>
                </div>
            </div>


@endsection
