<!doctype html>
<html lang="en">

    <head>
        @include('includes.meta')
        <title>@yield('title')</title>
        @include('includes.style')
        @stack('addon-style')
    </head>

    <body data-topbar="dark" data-layout-mode="dark">

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div class="bg-soft-light min-vh-100 py-5">
            <div class="py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="row justify-content-center mb-5">
                                    <div class="col-sm-5">
                                        <div class="maintenance-img">
                                            <img src="{{ asset('backend-assets/images/123.png') }}" width="200px" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                </div>
                                <h3 class="mt-4 font-size-22">Selamat Datang di <strong class="text-danger font-size-24 fw-black">smartwork</strong></h3>


                                <div class="mt-4">
                                    <a onclick="event.preventDefault(); document.getElementById('first-form').submit();"  class="btn btn-primary ps-5 pe-5 py-3 font-size-16">Lanjutkan ke Dashboard &nbsp;
                                        <i data-feather="chevron-right"></i>
                                    </a>
                                    <form id="first-form" action="{{ route('config.update', auth()->user()->id) }}" method="POST" style="display: none;">
                                        @method('PATCH')
                                        @csrf
                                        <input type="hidden" name="is_first" value="n">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
        </div>
        <!-- END layout-wrapper -->
        @include('includes.script')
    </body>
</html>
