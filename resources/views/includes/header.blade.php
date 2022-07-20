<header id="page-topbar" style="background-color: #B0141C !important;">
    {{-- #C7393B --}}
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('admin.home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend-assets/images/logo-sw-fullwhite.png') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend-assets/images/logo-sw-fullwhite.png') }}" alt="" height="24">
                        {{-- <span class="logo-txt">smartwork</span> --}}
                    </span>
                </a>
                <a href="{{ route('admin.home') }}" class="logo logo-light">
                    <span class="logo-sm"><img src="{{ asset('backend-assets/images/logo-sw-fullwhite.png') }}" alt="" height="36"></span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend-assets/images/logo-sw-fullwhite.png') }}" alt="" height="36">
                        {{-- <span class="font-size-24 fw-black txt-logo">smartwork</span> --}}
                    </span>
                </a>
            </div>
            <button type="button"
                class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- App Search-->
            {{-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="btn btn-primary" type="button"><i
                            class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form> --}}
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>
            <div class="dropdown d-inline-block mx-2">
                <button type="button" class="btn header-item noti-icon position-relative"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-success rounded-pill p-1">10</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifikasi </h6>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-soft-danger p-2">3</span>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 300px;">
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{ asset('backend-assets/images/users/avatar-6.jpg') }}"
                                    class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">As a skeptical Cambridge friend of mine
                                            occidental.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                            <span>1 hours ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>Lihat Semua</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    @if (auth()->user()->company_logo == "")
                        <img class="rounded-circle header-profile-user" src="{{ asset('backend-assets/images/no-staff.jpg') }}" alt="Header Avatar">
                    @else
                        <img class="rounded-circle header-profile-user" src="{{ asset('storage/uploads/'.auth()->user()->company_logo) }}" alt="Header Avatar">
                    @endif
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->nama }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="mdi mdi-account-edit font-size-16 align-middle me-1"></i> Profil</a>
                    <a class="dropdown-item" href="{{ route('admin.ubahPassword') }}"><i class="mdi mdi-account-key font-size-16 align-middle me-1"></i> Ubah Kata Sandi</a>
                    <a class="dropdown-item {{ auth()->user()->roles === 'masteradmin' ? '':'d-none' }}" href="{{ route('pengguna.index') }}"><i class="mdi mdi-account-group font-size-16 align-middle me-1"></i> Pengguna Aktif</a>
                    <a class="dropdown-item" href="{{ route('config.index') }}"><i class="mdi mdi-cog font-size-16 align-middle me-1"></i> Pengaturan</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-black fw-black bg-warning rounded" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
