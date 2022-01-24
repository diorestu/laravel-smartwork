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
            <div class="card gutter-b card-stretch p-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Nama Pegawai</td>
                                @php
                                    $t = date('t');
                                    $s = (int) $t;
                                    for ($i = 1; $i <= $s; $i++) {
                                        echo '<td align="center">' . $i . '</td>';
                                    }
                                @endphp
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item }}</td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                </tr>
                                @endforeach
                            @foreach ($data as $key => $item)

                                <td>{{ $item->nama }}</td>

                                {{-- <td>{{ $item->nama_shift }}</td>

                                @if (($key + 1) % 31 == 0)
                                    </tr>
                                @endif --}}

                            @endforeach

                            {{-- @if (($key + 1) % 31 != 0)
                                </tr>
                            @endif --}}
                        </tbody>
                    </table>
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


