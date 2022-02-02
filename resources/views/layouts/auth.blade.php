<!doctype html>
<html lang="en">

    <head>
        @include('includes.meta')
        <title>@yield('title')</title>
        @include('includes.style')
        @stack('addon-style')
    </head>

    <body data-topbar="dark">
    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-3 pb-3 text-center">
                                        <img class="img-fluid" src="{{ asset('backend-assets/images/logo-sw-dark.png') }}" alt=""
                                            width='200px'>
                                    </div>
                                    @yield('content')
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script>
                                           with  <i class="mdi mdi-heart text-danger"></i> by astapijar.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-end">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div class="testi-contain text-center text-white">
                                            <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                            <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                imposing change
                                                on myself. It's a lot more progressing fun than looking back.
                                                That's why
                                                I ultricies enim
                                                at malesuada nibh diam on tortor neaded to throw curve balls.”
                                            </h4>
                                            <div class="mt-4 pt-1 pb-5 mb-5">
                                                <h5 class="font-size-16 text-white">Richard Drews
                                                </h5>
                                                <p class="mb-0 text-white-50">Web Designer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>
    @include('includes.script')
    </body>

</html>
