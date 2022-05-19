<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PrintPDFController;
use App\Http\Controllers\User\CutiController;
use App\Http\Controllers\UserShiftController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\AbsenController;
use App\Http\Controllers\UserSalaryController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\User\MobileController;
use App\Http\Controllers\AbsenGalleryController;
use App\Http\Controllers\Admin\CabangController;
use App\Http\Controllers\Admin\ViewCutiController;
use App\Http\Controllers\User\AktivitasController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ViewAbsenController;
use App\Http\Controllers\Admin\ViewAktivitasController;
use App\Http\Controllers\Admin\ViewAdminController;
use App\Http\Controllers\KegiatanGalleryController;
use App\Http\Controllers\Admin\UserConfigController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KpiMasterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\MasaKerjaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\StatusKawinController;
use App\Http\Controllers\User\UserLemburController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Auth::routes();
    Route::middleware(['auth'])->group(function () {
        Route::get('verify/', [DashboardController::class, 'verify'])->name('admin.verify');
        Route::get('expired/', [DashboardController::class, 'expired'])->name('admin.expired');
    });

    Route::get('getCabang/{id}', function ($id) {
        $course = App\Models\User::select(['id', 'nama'])->where('id_cabang', $id)->where('roles', 'user')->get();
        return response()->json($course);
    });

    // ADMIN CONTROLLER
    Route::prefix('/')->middleware(['auth', 'is_admin', 'is_active', 'is_expired'])->group(function () {
        // DASHBOARD
        Route::get('/',                                 [DashboardController::class, 'index'])->name('admin.welcome');
        Route::get('/dashboard',                        [DashboardController::class, 'dashboard'])->name('admin.home');
        Route::get('/profil-saya',                      [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/profil-saya',                     [DashboardController::class, 'saveProfile'])->name('admin.save');
        Route::post('/upload-logo',                     [DashboardController::class, 'uploadLogo'])->name('upload.logo');
        Route::get('/ubah-kata-sandi',                  [DashboardController::class, 'ubahPassword'])->name('admin.ubahPassword');
        Route::resource('pengguna',                     ViewAdminController::class);

        // MASTER DATA
        Route::prefix('master')->group(function () {
            // pegawai
            Route::get('pegawai/nonActive/{id}',        [UserController::class, 'nonActive'])->name('pegawai.nonactive');
            Route::get('pegawai/active/{id}',           [UserController::class, 'active'])->name('pegawai.active');
            Route::post('pegawai/upload-image-pegawai', [UserController::class, 'uploadFotoPegawai'])->name('pegawai.uploadImage');
            Route::resource('pegawai',                  UserController::class);
            // cabang
            Route::resource('cabang',                   CabangController::class);
            // divisi
            Route::resource('divisi',                   DivisiController::class);
            // shift pegawai
            Route::resource('shift',                    ShiftController::class);
            // tunjanngan jabatan
            Route::resource('tunjangan/jabatan',        JabatanController::class);
            // tunjangan sertifikasi
            Route::resource('tunjangan/sertifikasi',    SertifikasiController::class);
            // tunjangan masa kerja
            Route::resource('tunjangan/masa-kerja',     MasaKerjaController::class);
            // tunjangan status kawin
            Route::resource('tunjangan/status-kawin',   StatusKawinController::class);
            //
            Route::resource('kpi-master',               KpiMasterController::class);
        });

        // MANAJEMEN
        Route::prefix('kelola')->group(function () {
            // absensi
            Route::get('absensi/riwayat',               [ViewAbsenController::class, 'data_riwayat'])->name('absensi.riwayat');
            Route::post('data-absensi-riwayat',         [ViewAbsenController::class, 'showDataRiwayat'])->name('absensi.show_data_riwayat');
            Route::get('absensi-per-karyawan',          [ViewAbsenController::class, 'data_karyawan'])->name('absensi.data_karyawan');
            Route::post('data-absensi-per-karyawan',    [ViewAbsenController::class, 'showDataKaryawan'])->name('absensi.show_data_karyawan');
            Route::get('absensi-per-cabang',            [ViewAbsenController::class, 'data_cabang'])->name('absensi.data_cabang');
            Route::post('data-absensi-per-cabang',      [ViewAbsenController::class, 'showDataCabang'])->name('absensi.show_data_cabang');
            Route::post('absensi/uploadimages/{tipe}/{id}', [ViewAbsenController::class, 'uploadImages'])->name("absensi.uploadimages");
            Route::post('absensi/deleteimages/{id}',    [ViewAbsenController::class, 'deleteImage'])->name("absensi.deleteimages");
            Route::resource('absensi',                  ViewAbsenController::class);
            // cuti
            Route::get('cuti/rekap',                    [ViewCutiController::class, 'rekap'])->name('cuti.rekap');
            Route::post('data-rekap-cuti',              [ViewCutiController::class, 'showDataRekap'])->name('cuti.show_data_rekap');
            Route::get('cuti/{id}/terima',              [ViewCutiController::class, 'accept'])->name('cuti.terima');
            Route::get('cuti/{id}/tolak',               [ViewCutiController::class, 'decline'])->name('cuti.tolak');
            Route::get('cuti-per-karyawan',             [ViewCutiController::class, 'data_karyawan'])->name('cuti.data_karyawan');
            Route::post('data-cuti-per-karyawan',       [ViewCutiController::class, 'showDataKaryawan'])->name('cuti.show_data_karyawan');
            Route::get('cuti-per-cabang',               [ViewCutiController::class, 'data_cabang'])->name('cuti.data_cabang');
            Route::post('data-cuti-per-cabang',         [ViewCutiController::class, 'showDataCabang'])->name('cuti.show_data_cabang');
            Route::post('data-pengajuan-cuti',          [ViewCutiController::class, 'showDataPengajuan'])->name('cuti.show_data_pengajuan');
            Route::resource('cuti',                     ViewCutiController::class);
            // aktivitas
            Route::get('aktivitas/riwayat',             [ViewAktivitasController::class, 'riwayat'])->name("aktivitas.riwayat");
            Route::post('data-riwayat-aktivitas',       [ViewAktivitasController::class, 'showDataRiwayat'])->name('aktivitas.show_data_riwayat');
            Route::post('aktivitas/uploadimages/{id}',  [ViewAktivitasController::class, 'uploadImages'])->name("aktivitas.uploadimages");
            Route::post('aktivitas/deleteimages/{id}',  [ViewAktivitasController::class, 'deleteImage'])->name("aktivitas.deleteimages");
            Route::get('aktivitas-per-karyawan',        [ViewAktivitasController::class, 'data_karyawan'])->name('aktivitas.data_karyawan');
            Route::post('data-aktivitas-per-karyawan',  [ViewAktivitasController::class, 'showDataKaryawan'])->name('aktivitas.show_data_karyawan');
            Route::get('aktivitas-per-cabang',          [ViewAktivitasController::class, 'data_cabang'])->name('aktivitas.data_cabang');
            Route::post('data-aktivitas-per-cabang',    [ViewAktivitasController::class, 'showDataCabang'])->name('aktivitas.show_data_cabang');
            Route::resource('aktivitas',                ViewAktivitasController::class);
            // lembur
            Route::get('lembur/riwayat',                [LemburController::class, 'riwayat'])->name('lembur.riwayat');
            Route::get('lembur/{id}/terima',            [LemburController::class, 'accept'])->name('lembur.terima');
            Route::get('lembur/{id}/tolak',             [LemburController::class, 'decline'])->name('lembur.tolak');
            Route::get('lembur-per-karyawan',           [LemburController::class, 'data_karyawan'])->name('lembur.data_karyawan');
            Route::post('data-lembur-per-karyawan',     [LemburController::class, 'showDataKaryawan'])->name('lembur.show_data_karyawan');
            Route::get('lembur-per-cabang',             [LemburController::class, 'data_cabang'])->name('lembur.data_cabang');
            Route::post('data-lembur-per-cabang',       [LemburController::class, 'showDataCabang'])->name('lembur.show_data_cabang');
            Route::post('data-pengajuan-lembur',        [LemburController::class, 'showDataPengajuan'])->name('lembur.show_data_pengajuan');
            Route::resource('lembur',                   LemburController::class);
            // jadwal kerja
            Route::get('jadwal/impor-jadwal',           [JadwalController::class, 'impor'])->name('jadwal.impor');
            Route::post('jadwal/download-template',     [JadwalController::class, 'download_template'])->name('jadwal.downloadtemplate');
            Route::post('jadwal/upload-tambah-jadwal',  [JadwalController::class, 'upload_add_jadwal'])->name('jadwal.uploadAdd');
            Route::post('jadwal/get-jadwal',            [JadwalController::class, 'get_jadwal'])->name('jadwal.cari');
            Route::get('jadwal/lihat/{cb}/{bl}/{th}',   [JadwalController::class, 'lihat_jadwal'])->name('jadwal.lihat');
            Route::get('jadwal/atur/{usr}/{bl}/{th}',   [JadwalController::class, 'atur_jadwal'])->name('jadwal.atur');
            Route::post('jadwal/simpan/{usr}/{shift}/{tgl}', [JadwalController::class, 'simpan_jadwal'])->name('jadwal.simpan');
            Route::resource('jadwal',                   JadwalController::class);
            //payroll
            Route::post('payroll/cari',                 [PayrollController::class, 'get_payroll'])->name('payroll.cari');
            Route::get('payroll/riwayat/{bl}/{th}',     [PayrollController::class, 'lihat_payroll'])->name('payroll.riwayat');
            Route::get('payroll/slip-gaji/{id}',        [PayrollController::class, 'slipgaji_payroll'])->name('payroll.slipgaji');
            Route::get('payroll/download-slip-gaji/{id}', [PayrollController::class, 'cetak_slipgaji_payroll'])->name('payroll.cetak_slipgaji');
            Route::resource('payroll',                  PayrollController::class);
            // pengumuman
            Route::resource('pengumuman',               PengumumanController::class);
        });
        // PELAPORAN
        Route::prefix('laporan')->group(function () {
            // absensi
            Route::get('absensi/overview',              [LaporanController::class, 'lap_absensi'])->name('laporan.absensi');
            Route::post('data-laporan-absensi',         [LaporanController::class, 'show_data_absensi'])->name('lembur.show_data_absensi');
            Route::get('absensi/summary/{user}/{awal}/{akhir}', [LaporanController::class, 'detail_absensi'])->name('laporan.detail_absensi');
            // cuti
            Route::get('cuti/overview',                 [LaporanController::class, 'lap_cuti'])->name('laporan.cuti');
            Route::post('data-laporan-cuti',            [LaporanController::class, 'showDataCuti'])->name('laporan.show_data_cuti');
            Route::post('cuti/ekspor-data',             [LaporanController::class, 'ekspor_cuti'])->name('ekspor.laporan.cuti');
            // lembur
            Route::get('lembur/overview',               [LaporanController::class, 'lap_lembur'])->name('laporan.lembur');
            Route::post('data-laporan-lembur',          [LaporanController::class, 'showDataLembur'])->name('laporan.show_data_lembur');
            Route::post('lembur/ekspor-data',           [LaporanController::class, 'ekspor_lembur'])->name('ekspor.laporan.lembur');
            // bpjs
            Route::get('bpjs/overview',                 [LaporanController::class, 'lap_bpjs'])->name('laporan.bpjs');
            Route::post('data-iuran-bpjs',              [LaporanController::class, 'showDataBpjs'])->name('laporan.show_data_bpjs');
            Route::post('bpjs/ekspor-data',             [LaporanController::class, 'ekspor_bpjs'])->name('ekspor.laporan.bpjs');
        // pph21
            Route::get('pajak/overview',                 [LaporanController::class, 'lap_pph21'])->name('laporan.pajak');
            Route::post('data-iuran-pajak',              [LaporanController::class, 'showDataPph21'])->name('laporan.show_data_pajak');
            Route::post('pajak/ekspor-data',             [LaporanController::class, 'ekspor_pph21'])->name('ekspor.laporan.pajak');
        });

        // PENGATURAN
        Route::post('config/update-layout/{id}',        [UserConfigController::class, 'updateLayout'])->name("config.updateLayout");
        Route::resource('config',                       UserConfigController::class);
        Route::get('slip-gaji/{id}',                    [PrintPDFController::class, 'cetak_slip_gaji']);
    });

    // USER CONTROLLER
    Route::prefix('user')->middleware(['auth', 'is_user'])->group(function () {
        // Halaman Home
        Route::get('/', [MobileController::class, 'index'])->name('user.home');
        // Halaman Profil
        Route::get('/profil', [MobileController::class, 'profile'])->name('user.profil');
        Route::post('/profile', [MobileController::class, 'saveProfile'])->name('user.save');
        Route::get('/user-data', [MobileController::class, 'data_profile'])->name('user.data');
        Route::get('/account', [MobileController::class, 'changePassword'])->name('user.pass');
        Route::post('/account', [MobileController::class, 'postchangePassword'])->name('user.pass.save');
        // Halaman Absen
        Route::resource('absen', AbsenController::class);
        Route::get('/set-shift', [MobileController::class, 'getShift'])->name('user.get.shift');
        Route::post('/set-shift', [MobileController::class, 'postShift'])->name('user.post.shift');

        // Halaman Kegiatan
        Route::resource('kegiatan', AktivitasController::class);
        // Halaman Pengumuman
        Route::resource('kegiatan', AktivitasController::class);
        // Halaman Slip Gaji
        Route::get('/slip-gaji', [MobileController::class, 'gaji'])->name('user.gaji');
        // Halaman Slip Gaji
        Route::get('/jadwal', [MobileController::class, 'jadwal'])->name('user.jadwal');
        // Upload Foto
        Route::post('upload-kegiatan', [AktivitasController::class, 'postKegiatan'])->name('upload-kegiatan');
        Route::post('upload-hadir', [AbsenGalleryController::class, 'postHadir'])->name('upload-hadir');
        Route::post('upload-pulang', [AbsenGalleryController::class, 'postPulang'])->name('upload-pulang');
        route::resource('leave', CutiController::class);
        route::resource('overtime', UserLemburController::class);
    });
