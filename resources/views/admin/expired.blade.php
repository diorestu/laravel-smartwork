<!doctype html>
<html lang="en">
<head>
    @include('includes.meta')
    <title>Masa Aktif Sistem Telah Berakhir | Smartwork App</title>
    @include('includes.style')
    @stack('addon-style')
</head>
<body data-topbar="dark">
    <div class="preview-img">
        <div class="swiper-container preview-thumb">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url({{ asset('backend-assets/images/bg-3.jpg') }});"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="coming-content min-vh-100 py-4 px-3 py-sm-5">
        <div class="bg-overlay bg-black"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center py-4 py-sm-5">
                        <div class="mb-5">
                            <a href="index.html">
                                <img src="{{ asset("backend-assets/images/logo-sw-white.png") }}" alt="" height="80" class="me-1">
                            </a>
                        </div>
                        <h3 class="text-white mt-5">Masa Aktif Sistem Telah Berakhir</h3>
                        <p class="text-white-50 font-size-15">
                            Maaf, masa aktif sistem Smartwork Anda telah berakhir. Segera lakukan perpanjangan masa aktif untuk mendapatkan layanan Smartwork secara lengkap.
                        </p>
                        @php
                            $pesan      = "Halo, saya ingin memperpanjang masa aktif sistem Smartwork saya dengan detail:%0A%0A";
                            $detail     =  "*ID Admin            :* " . Auth::user()->id . "%0A";
                            $detail     .= "*Perusahaan       :* " . Auth::user()->company . "%0A";
                            $detail     .= "*Email                   :* " . Auth::user()->email . "%0A";
                            $detail     .= "*Perpanjang Sampai       :* 1 bulan kedepan";
                            $pesan_c    = $pesan."".$detail;
                        @endphp
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=6285161100210&text={{ $pesan_c }}&app_absent=0" class="btn btn-warning text-black btn-md my-5"><i class="fa fa-paper-plane"></i>&nbsp; Perpanjang Masa Aktif Smartwork Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.script')
</body>
</html>
