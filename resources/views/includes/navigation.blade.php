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
                            <a href="{{ route('pegawai.index') }}" class="dropdown-item {{ request()->is('master/pegawai*') ? 'active' : ''}}" data-key="t-pegawai"><i class="icon-menu" data-feather="user"></i> Pegawai</a>
                            <a href="{{ route('cabang.index') }}" class="dropdown-item {{ request()->is('master/cabang*') ? 'active' : ''}}" data-key="t-lokasi"><i class="icon-menu" data-feather="map-pin"></i> Lokasi Kerja</a>
                            <a href="{{ route('shift.create') }}" class="dropdown-item" data-key="t-jam"><i class="icon-menu" data-feather="clock"></i> Jam Kerja</a>
                            <a href="{{ route('divisi.index') }}" class="dropdown-item" {{ request()->is('master/divisi*') ? 'active' : ''}} data-key="t-divisi"><i class="icon-menu" data-feather="briefcase"></i> Divisi</a>
                            <div class="dropdown">
                                <a class="dropdown-item {{ request()->is('master/tunjangan*') ? 'active' : ''}} dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-tunjangan" role="button">
                                    <span data-key="t-email"><i class="icon-menu" data-feather="award"></i> Tunjangan</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-tunjangan">
                                    <a href="{{ route('jabatan.index') }}" class="dropdown-item">Jabatan</a>
                                    <a href="{{ route('sertifikasi.index') }}" class="dropdown-item">Sertifikasi</a>
                                    <a href="{{ route('masa-kerja.index') }}" class="dropdown-item">Masa Kerja</a>
                                    <a href="{{ route('status-kawin.index') }}" class="dropdown-item">Status Kawin</a>
                                </div>
                            </div>
                            <a href="{{ route('kpi-master.index') }}" class="dropdown-item" {{ request()->is('master/kpi-master') ? 'active' : ''}} data-key="t-divisi"><i class="icon-menu" data-feather="heart"></i> KPI</a>
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
                                <a class="dropdown-item dropdown-toggle arrow-none" href="{{ route('absensi.index') }}" id="topnav-email" role="button">
                                    <i class="icon-menu" data-feather="user-check"></i> <span data-key="t-email">Absensi</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ route('absensi.create') }}" class="dropdown-item">Input Absensi</a>
                                    <a href="{{ route('absensi.index') }}" class="dropdown-item">Absensi Hari Ini</a>
                                    <a href="{{ route('absensi.riwayat') }}" class="dropdown-item">Riwayat Absensi</a>
                                    <a href="{{ route('absensi.data_karyawan') }}" class="dropdown-item">Absensi Per Pegawai</a>
                                    <a href="{{ route('absensi.data_cabang') }}" class="dropdown-item">Absensi Per Lokasi Kerja</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="{{ route('cuti.index') }}" id="topnav-email" role="button">
                                    <i class="icon-menu" data-feather="briefcase"></i> <span data-key="t-email">Cuti</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ route('cuti.create') }}" class="dropdown-item">Input Cuti</a>
                                    <a href="{{ route('cuti.index') }}" class="dropdown-item">Pengajuan Cuti</a>
                                    <a href="{{ route('cuti.rekap') }}" class="dropdown-item">Rekap Cuti</a>
                                    <a href="{{ route('cuti.data_karyawan') }}" class="dropdown-item">Cuti Per Pegawai</a>
                                    <a href="{{ route('cuti.data_cabang') }}" class="dropdown-item">Cuti Per Lokasi Kerja</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button">
                                    <i class="icon-menu" data-feather="clock"></i> <span data-key="t-email">Lembur</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ route('lembur.create') }}" class="dropdown-item">Input Lembur</a>
                                    <a href="{{ route('lembur.index') }}" class="dropdown-item">Permohonan Lembur</a>
                                    <a href="{{ route('lembur.data_karyawan') }}" class="dropdown-item">Lembur Per Pegawai</a>
                                    <a href="{{ route('lembur.data_cabang') }}" class="dropdown-item">Lembur Per Lokasi Kerja</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" id="topnav-tasks"
                                    role="button">
                                    <i class="icon-menu" data-feather="calendar"></i> <span data-key="t-tasks">Jadwal Kerja</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-tasks">
                                    <a href="{{ route("jadwal.impor") }}" class="dropdown-item">Impor Jadwal</a>
                                    <a href="{{ route("jadwal.index") }}" class="dropdown-item">Lihat Jadwal Kerja</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="{{ route('aktivitas.index') }}" id="topnav-contact" role="button">
                                    <i class="icon-menu" data-feather="clipboard"></i> <span data-key="t-contacts">Aktivitas</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="{{ route('aktivitas.create') }}" class="dropdown-item">Input Aktivitas</a>
                                    <a href="{{ route('aktivitas.index') }}" class="dropdown-item">Aktivitas Hari Ini</a>
                                    <a href="{{ route('aktivitas.riwayat') }}" class="dropdown-item">Riwayat Aktivitas</a>
                                    <a href="{{ route('aktivitas.data_karyawan') }}" class="dropdown-item">Aktivitas Per Pegawai</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact" role="button">
                                    <i class="icon-menu" data-feather="credit-card"></i> <span data-key="t-contacts">Payroll</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="{{ route('payroll.create') }}" class="dropdown-item">Buat Payroll Baru</a>
                                    <a href="{{ route('payroll.index') }}" class="dropdown-item">Riwayat Payroll</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact" role="button">
                                    <i class="icon-menu" data-feather="bell"></i> <span data-key="t-contacts">Pengumuman</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="{{ route('pengumuman.create') }}" class="dropdown-item">Buat Pengumuman Baru</a>
                                    <a href="{{ route('pengumuman.index') }}" class="dropdown-item">Data Pengumuman</a>
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
                            <a href="{{ route("laporan.absensi") }}" class="dropdown-item"><i class="icon-menu" data-feather="user-check"></i> Absensi</a>
                            <a href="{{ route("laporan.lembur") }}" class="dropdown-item"><i class="icon-menu" data-feather="clock"></i> Lembur</a>
                            <a href="{{ route('laporan.cuti') }}" class="dropdown-item"><i class="icon-menu" data-feather="briefcase"></i> Cuti</a>
                            <a href="{{ route('laporan.bpjs') }}" class="dropdown-item"><i class="icon-menu" data-feather="shield"></i> BPJS</a>
                            <a href="{{ route('laporan.pajak') }}" class="dropdown-item"><i class="icon-menu" data-feather="dollar-sign"></i> PPh 21</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-laporan"
                            role="button">
                            <i data-feather="file-text"></i><span>Rekrutmen</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            <a href="#" class="dropdown-item"><i class="icon-menu" data-feather="user-check"></i> Lowongan Pekjerjaan</a>
                            <a href="#" class="dropdown-item"><i class="icon-menu" data-feather="clock"></i> Lamaran Masuk</a>
                            <a href="#" class="dropdown-item"><i class="icon-menu" data-feather="briefcase"></i> Psikotes</a>
                            <a href="#" class="dropdown-item"><i class="icon-menu" data-feather="briefcase"></i> Wawancara</a>
                            <a href="#" class="dropdown-item"><i class="icon-menu" data-feather="briefcase"></i> Pembuatan Kontrak</a>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
