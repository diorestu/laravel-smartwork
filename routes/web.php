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
use App\Http\Controllers\LemburController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\MasaKerjaController;
use App\Http\Controllers\StatusKawinController;
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
    });

    Route::get('getCabang/{id}', function ($id) {
        $course = App\Models\User::select(['id', 'nama'])->where('id_cabang', $id)->where('roles', 'user')->get();
        return response()->json($course);
    });

    // ADMIN CONTROLLER
    Route::prefix('/')->middleware(['auth', 'is_admin', 'is_active'])->group(function () {
        // DASHBOARD
        Route::get('/',                                 [DashboardController::class, 'index'])->name('admin.welcome');
        Route::get('/dashboard',                        [DashboardController::class, 'dashboard'])->name('admin.home');
        Route::get('/profil-saya',                      [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/profil-saya',                     [DashboardController::class, 'saveProfile'])->name('admin.save');
        Route::post('/upload-logo',                     [DashboardController::class, 'uploadLogo'])->name('upload.logo');
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
        });

        // MANAJEMEN
        Route::prefix('kelola')->group(function () {
            // absensi
            Route::get('absensi-per-karyawan',          [ViewAbsenController::class, 'data_karyawan'])->name('absensi.data_karyawan');
            Route::post('data-absensi-per-karyawan',    [ViewAbsenController::class, 'showDataKaryawan'])->name('absensi.show_data_karyawan');
            Route::get('absensi-per-cabang',            [ViewAbsenController::class, 'data_cabang'])->name('absensi.data_cabang');
            Route::post('data-absensi-per-cabang',      [ViewAbsenController::class, 'showDataCabang'])->name('absensi.show_data_cabang');
            Route::resource('absensi',                  ViewAbsenController::class);
            // cuti
            Route::get('cuti/riwayat',                  [ViewCutiController::class, 'riwayat'])->name('cuti.riwayat');
            Route::get('cuti/{id}/terima',              [ViewCutiController::class, 'accept'])->name('cuti.terima');
            Route::get('cuti/{id}/tolak',               [ViewCutiController::class, 'decline'])->name('cuti.tolak');
            Route::get('cuti-per-karyawan',             [ViewCutiController::class, 'data_karyawan'])->name('cuti.data_karyawan');
            Route::post('data-cuti-per-karyawan',       [ViewCutiController::class, 'showDataKaryawan'])->name('cuti.show_data_karyawan');
            Route::get('cuti-per-cabang',               [ViewCutiController::class, 'data_cabang'])->name('cuti.data_cabang');
            Route::post('data-cuti-per-cabang',         [ViewCutiController::class, 'showDataCabang'])->name('cuti.show_data_cabang');
            Route::resource('cuti',                     ViewCutiController::class);
            // aktivitas
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
            Route::resource('lembur',                   LemburController::class);
            // jadwal kerja
            Route::get('jadwal/impor-jadwal',           [JadwalController::class, 'impor'])->name('jadwal.impor');
            Route::post('jadwal/get-jadwal',            [JadwalController::class, 'get_jadwal'])->name('jadwal.cari');
            Route::get('jadwal/lihat/{cb}/{bl}/{th}',   [JadwalController::class, 'lihat_jadwal'])->name('jadwal.lihat');
            Route::get('jadwal/atur/{usr}/{bl}/{th}',   [JadwalController::class, 'atur_jadwal'])->name('jadwal.atur');
            Route::post('jadwal/simpan/{usr}/{shift}/{tgl}', [JadwalController::class, 'simpan_jadwal'])->name('jadwal.simpan');
            Route::resource('jadwal',                   JadwalController::class);
            //
            Route::resource('payroll',                  PayrollController::class);
        });

        // PELAPORAN

        // PENNGATURAN
        Route::resource('config', UserConfigController::class);
        Route::get('slip-gaji/{id}', [PrintPDFController::class, 'cetak_slip_gaji']);
    });

    // USER CONTROLLER
    Route::prefix('user')->middleware(['auth', 'is_user'])->group(function () {
        Route::get('/', [MobileController::class, 'index'])->name('user.home');
        Route::get('/profile', [MobileController::class, 'profile'])->name('user.profil');
        Route::get('/account', [MobileController::class, 'changePassword'])->name('user.pass');
        Route::post('/profile', [MobileController::class, 'saveProfile'])->name('user.save');
        Route::resource('absen', AbsenController::class);
        Route::resource('kegiatan', AktivitasController::class);
        Route::post('upload-kegiatan', [AktivitasController::class, 'postKegiatan'])->name('upload-kegiatan');
        Route::post('upload-hadir', [AbsenGalleryController::class, 'postHadir'])->name('upload-hadir');
        Route::post('upload-pulang', [AbsenGalleryController::class, 'postPulang'])->name('upload-pulang');
        // route::resource('cuti', CutiController::class);
    });
