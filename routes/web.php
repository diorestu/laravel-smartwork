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
use App\Http\Controllers\Admin\ViewAdminController;
use App\Http\Controllers\KegiatanGalleryController;
use App\Http\Controllers\Admin\UserConfigController;
use App\Http\Controllers\JabatanController;
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
    //
    //Admin Controller
    Route::prefix('/')->middleware(['auth', 'is_admin', 'is_active'])->group(function () {
        // Dashboard

        Route::get('/', [DashboardController::class, 'index'])->name('admin.welcome');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.home');
        Route::get('/profil-saya', [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/profil-saya', [DashboardController::class, 'saveProfile'])->name('admin.save');
        Route::post('/upload-logo', [DashboardController::class, 'uploadLogo'])->name('upload.logo');
        Route::resource('pengguna', ViewAdminController::class);

        // Master Data
        Route::prefix('master')->group(function () {
            Route::resource('pegawai', UserController::class);
            Route::get('pegawai/nonActive/{id}', [UserController::class, 'nonActive'])->name('pegawai.nonactive');
            Route::get('pegawai/active/{id}', [UserController::class, 'active'])->name('pegawai.active');
            Route::post('pegawai/upload-image-pegawai', [UserController::class, 'uploadFotoPegawai'])->name('pegawai.uploadImage');
            Route::resource('cabang', CabangController::class);
            Route::resource('upah', UserSalaryController::class);
            Route::resource('tunjangan/jabatan', JabatanController::class);
            Route::resource('tunjangan/sertifikasi', SertifikasiController::class);
            Route::resource('tunjangan/masa-kerja', MasaKerjaController::class);
            Route::resource('tunjangan/status-kawin', StatusKawinController::class);
        });

        // Manajemen
        Route::prefix('kelola')->group(function () {
            Route::resource('absensi', ViewAbsenController::class);
            Route::get('cuti/{id}/terima', [ViewCutiController::class, 'accept'])->name('cuti.terima');
            Route::get('cuti/{id}/tolak', [ViewCutiController::class, 'decline'])->name('cuti.tolak');
            Route::get('cuti/riwayat', [ViewCutiController::class, 'riwayat'])->name('cuti.riwayat');
            Route::resource('cuti', ViewCutiController::class);
            Route::resource('jadwal', JadwalController::class);
            Route::resource('payroll', PayrollController::class);
        });

        // Pengaturan
        Route::resource('config', UserConfigController::class);


        Route::get('shift-user', [ShiftController::class, 'getShiftUser'])->name('get.shift.user');
        Route::get('shift-cabang', [ShiftController::class, 'getShiftCabang'])->name('get.shift.cabang');
        Route::post('shift-user', [ShiftController::class, 'postShiftUser'])->name('post.shift.user');
        Route::post('shift-cabang', [ShiftController::class, 'postShiftCabang'])->name('post.shift.cabang');
        Route::resource('shift', ShiftController::class);
        Route::post('jadwal/cari', [JadwalController::class, 'get_jadwal'])->name('cari.jadwal');
        Route::get('slip-gaji/{id}', [PrintPDFController::class, 'cetak_slip_gaji']);
    });

    Route::get('getCabang/{id}', function ($id) {
        $course = App\Models\User::select(['id', 'nama'])->where('id_cabang', $id)->where('roles', 'user')->get();
        return response()->json($course);
    });

    Route::prefix('user')->middleware(['auth', 'is_user'])->group(function () {
            Route::get('/', [MobileController::class, 'index'])->name('user.home');
            Route::get('/profile', [MobileController::class, 'profile'])->name('user.profil');
            Route::get('/account', [MobileController::class, 'changePassword'])->name('user.pass');
            Route::post('/profile', [MobileController::class, 'saveProfile'])->name('user.save');

            route::resource('absen', AbsenController::class);
            // route::resource('cuti', CutiController::class);
            route::resource('kegiatan', AktivitasController::class);
            Route::post('upload-kegiatan', [AktivitasController::class, 'postKegiatan'])->name('upload-kegiatan');
            route::post('upload-hadir', [AbsenGalleryController::class, 'postHadir'])->name('upload-hadir');
            route::post('upload-pulang', [AbsenGalleryController::class, 'postPulang'])->name('upload-pulang');
    });


