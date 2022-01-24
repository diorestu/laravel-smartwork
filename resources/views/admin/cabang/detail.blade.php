@extends('layouts.main')

@section('title')
    Detail Lokasi Kerja
@endsection


@section('content')
    <div class="row">
        <div class="col-7">
            <div class="card shadow rounded-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->cabang_nama }}</h5>
                    <p class="card-text">{{ $data->cabang_alamat }}</p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>No. Telp</td>
                                <td>:</td>
                                <td>{{ $data->cabang_phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $data->cabang_email }}</td>
                            </tr>
                            <tr>
                                <td>UMK Berlaku</td>
                                <td>:</td>
                                <td>Rp. {{ $data->cabang_umk }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Terdaftar</td>
                                <td>:</td>
                                <td>{{ tanggalIndo($data->created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-5">
            <div class="card shadow rounded-sm">
                <div class="card-body p-2">
                    <h4 class="card-title my-3 ms-3">Lihat Lokasi di Peta</h4>
                    <iframe
                      width="100%"
                      height="300"
                      frameborder="0"
                      scrolling="no"
                      marginheight="0"
                      marginwidth="0"
                      src="https://maps.google.com/maps?q=+-8.6179093+,+115.1925637+&hl=id&z=17&amp;output=embed">
                     </iframe>
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15779.085611627637!2d115.1924309!3d-8.6179322!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa919bea69199a723!2sApik%20-%20Asta%20Pijar%20Kreasi%20Teknologi!5e0!3m2!1sid!2sid!4v1641786229860!5m2!1sid!2sid"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

