<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('admin.home') }}" id="topnav-dashboard"
                            role="button">
                            <i data-feather="home"></i><span data-key="t-dashboard">Dashboard</span>
                        </a>
                    </li>



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none {{ request()->is('master*') ? 'active' : ''}}" href="#" id="topnav-master"
                            role="button">
                            <i data-feather="grid"></i><span data-key="t-master">Master Data</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-master">
                            <a href="{{ route('pegawai.index') }}" class="dropdown-item {{ request()->is('master/pegawai*') ? 'active' : ''}}" data-key="t-pegawai">Pegawai</a>
                            <a href="{{ route('cabang.index') }}" class="dropdown-item {{ request()->is('master/cabang*') ? 'active' : ''}}" data-key="t-lokasi">Lokasi Kerja</a>
                            <a href="{{ route('shift.index') }}" class="dropdown-item" data-key="t-jam">Jam Kerja</a>
                            <a href="{{ route('divisi.index') }}" class="dropdown-item" data-key="t-divisi">Divisi</a>
                            <div class="dropdown">
                                <a class="dropdown-item {{ request()->is('master/tunjangan*') ? 'active' : ''}} dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-tunjangan" role="button">
                                    <span data-key="t-email">Tunjangan</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-tunjangan">
                                    <a href="{{ route('jabatan.index') }}" class="dropdown-item">Jabatan</a>
                                    <a href="{{ route('sertifikasi.index') }}" class="dropdown-item">Sertifikasi</a>
                                    <a href="{{ route('masa-kerja.index') }}" class="dropdown-item">Masa Kerja</a>
                                    <a href="{{ route('status-kawin.index') }}" class="dropdown-item">Status Kawin</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages"
                            role="button">
                            <i data-feather="layers"></i><span data-key="t-apps">Manajemen</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="{{ route('absensi.index') }}" id="topnav-email"
                                    role="button">
                                    <span data-key="t-email">Absensi</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ route('absensi.create') }}" class="dropdown-item"
                                        data-key="t-inbox">Input Absensi</a>
                                    <a href="{{ route('absensi.index') }}" class="dropdown-item"
                                        data-key="t-inbox">Absensi Hari Ini</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Absensi Per Karyawan</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Absensi Per Cabang</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="{{ route('cuti.index') }}" id="topnav-email"
                                    role="button">
                                    <span data-key="t-email">Cuti</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ route('cuti.create') }}" class="dropdown-item"
                                        data-key="t-inbox">Input Cuti</a>
                                    <a href="{{ route('cuti.index') }}" class="dropdown-item"
                                        data-key="t-inbox">Pengajuan Cuti Bulan Ini</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Rekap Cuti Per Karyawan</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Rekap Cuti Per Cabang</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                    role="button">
                                    <span data-key="t-email">Lembur</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="apps-email-inbox.html" class="dropdown-item"
                                        data-key="t-inbox">Input Lembur</a>
                                    <a href="apps-email-inbox.html" class="dropdown-item"
                                        data-key="t-inbox">Lembur Hari Ini</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Lembur Per Karyawan</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Lembur Per Cabang</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" id="topnav-tasks"
                                    role="button">
                                    <span data-key="t-tasks">Jadwal Kerja</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-tasks">
                                    <a href="tasks-list.html" class="dropdown-item"
                                        data-key="t-task-list">Input Jadwal Kerja</a>
                                    <a href="tasks-kanban.html" class="dropdown-item"
                                        data-key="t-kanban-board">Lihat Jadwal Kerja</a>
                                    <a href="tasks-create.html" class="dropdown-item"
                                        data-key="t-create-task">Lihat Jam Kerja</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#"
                                    id="topnav-contact" role="button">
                                    <span data-key="t-contacts">Aktivitas</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="apps-email-inbox.html" class="dropdown-item"
                                        data-key="t-inbox">Input Aktivitas</a>
                                    <a href="apps-email-inbox.html" class="dropdown-item"
                                        data-key="t-inbox">Aktivitas Hari Ini</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Aktivitas Per Karyawan</a>
                                    <a href="apps-email-read.html" class="dropdown-item"
                                        data-key="t-read-email">Aktivitas Per Cabang</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#"
                                    id="topnav-contact" role="button">
                                    <span data-key="t-contacts">Payroll</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="{{ route('payroll.create') }}" class="dropdown-item"
                                        data-key="t-inbox">Input Payroll</a>
                                    <a href="{{ route('payroll.index') }}" class="dropdown-item"
                                        data-key="t-inbox">Riwayat Payroll</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-laporan"
                            role="button">
                            <i data-feather="file-text"></i><span>Laporan</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            <a class="dropdown-item" >Laporan Absensi</a>
                            <a class="dropdown-item" >Laporan Aktivitas</a>
                            <a class="dropdown-item" >Laporan Lembur</a>
                            <a class="dropdown-item" >Laporan Cuti</a>
                        </div>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button">
                            <i data-feather="file-text"></i><span data-key="t-extra-pages">Extra Pages</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-more">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                    role="button">
                                    <span data-key="t-authentication">Authentication</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                    <a href="auth-login.html" class="dropdown-item"
                                        data-key="t-login">Login</a>
                                    <a href="auth-register.html" class="dropdown-item"
                                        data-key="t-register">Register</a>
                                    <a href="auth-recoverpw.html" class="dropdown-item"
                                        data-key="t-recover-password">Recover Password</a>
                                    <a href="auth-lock-screen.html" class="dropdown-item"
                                        data-key="t-lock-screen">Lock Screen</a>
                                    <a href="auth-logout.html" class="dropdown-item" data-key="t-logout">Log
                                        Out</a>
                                    <a href="auth-confirm-mail.html" class="dropdown-item"
                                        data-key="t-confirm-mail">Confirm Mail</a>
                                    <a href="auth-email-verification.html" class="dropdown-item"
                                        data-key="t-email-verification">Email verification</a>
                                    <a href="auth-two-step-verification.html" class="dropdown-item"
                                        data-key="t-two-step-verification">Two step verification</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#"
                                    id="topnav-utility" role="button">
                                    <span data-key="t-utility">Utility</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                    <a href="pages-starter.html" class="dropdown-item"
                                        data-key="t-starter-page">Starter Page</a>
                                    <a href="pages-maintenance.html" class="dropdown-item"
                                        data-key="t-maintenance">Maintenance</a>
                                    <a href="pages-comingsoon.html" class="dropdown-item"
                                        data-key="t-coming-soon">Coming Soon</a>
                                    <a href="pages-timeline.html" class="dropdown-item"
                                        data-key="t-timeline">Timeline</a>
                                    <a href="pages-faqs.html" class="dropdown-item" data-key="t-faqs">FAQs</a>
                                    <a href="pages-pricing.html" class="dropdown-item"
                                        data-key="t-pricing">Pricing</a>
                                    <a href="pages-404.html" class="dropdown-item"
                                        data-key="t-error-404">Error 404</a>
                                    <a href="pages-500.html" class="dropdown-item"
                                        data-key="t-error-500">Error 500</a>
                                </div>
                            </div>
                        </div>
                    </li> --}}

                </ul>
            </div>
        </nav>
    </div>
</div>
