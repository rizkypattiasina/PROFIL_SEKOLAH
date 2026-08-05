<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controller utama
use App\Http\Controllers\HomeController;

// Controller frontend
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\MenuController;

// Controller backend
use App\Http\Controllers\Backend\AlumniController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;

// Controller pengelolaan website
use App\Http\Controllers\Backend\Website\AboutController;
use App\Http\Controllers\Backend\Website\BeritaController;
use App\Http\Controllers\Backend\Website\EventsController;
use App\Http\Controllers\Backend\Website\FooterController;
use App\Http\Controllers\Backend\Website\ImageSliderController;
use App\Http\Controllers\Backend\Website\KategoriBeritaController;
use App\Http\Controllers\Backend\Website\KegiatanController;
use App\Http\Controllers\Backend\Website\ProfilSekolahController;
use App\Http\Controllers\Backend\Website\ProgramController;
use App\Http\Controllers\Backend\Website\VideoController;
use App\Http\Controllers\Backend\Website\VisidanMisiController;

// Controller pengguna
use App\Http\Controllers\Backend\Pengguna\BendaharaController;
use App\Http\Controllers\Backend\Pengguna\MuridController;
use App\Http\Controllers\Backend\Pengguna\PengajarController;
use App\Http\Controllers\Backend\Pengguna\PerpusController;
use App\Http\Controllers\Backend\Pengguna\PPDBController;
use App\Http\Controllers\Backend\Pengguna\StafController;

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', [IndexController::class, 'index'])
    ->name('frontend.home');

Route::get('/profile-sekolah', [IndexController::class, 'profileSekolah'])
    ->name('profile.sekolah');

Route::get('/visi-dan-misi', [IndexController::class, 'visimisi'])
    ->name('visimisi.sekolah');

Route::get('/program/{slug}', [MenuController::class, 'programStudi'])
    ->name('program.detail');

Route::get('/kegiatan/{slug}', [MenuController::class, 'kegiatan'])
    ->name('kegiatan.detail');

/*
|--------------------------------------------------------------------------
| Berita
|--------------------------------------------------------------------------
*/

Route::get('/berita', [IndexController::class, 'berita'])
    ->name('berita');

Route::get('/berita/{slug}', [IndexController::class, 'detailBerita'])
    ->name('detail.berita');

/*
|--------------------------------------------------------------------------
| Event dan Alumni
|--------------------------------------------------------------------------
*/

Route::get('/event', [IndexController::class, 'events'])
    ->name('event');

Route::get('/event/{slug}', [IndexController::class, 'detailEvent'])
    ->name('detail.event');

Route::get('/alumni', [IndexController::class, 'alumni'])
    ->name('alumni');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::routes([
    'register' => false,
]);

/*
|--------------------------------------------------------------------------
| Backend untuk pengguna yang sudah login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active.user'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    /*
    |--------------------------------------------------------------------------
    | Profil pengguna
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/profile-settings/change-password/{id}',
        [ProfileController::class, 'changePassword']
    )->name('profile.change-password');

    Route::resource(
        'profile-settings',
        ProfileController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Pengaturan
    |--------------------------------------------------------------------------
    */

    Route::prefix('settings')->middleware('role:Admin')->group(function () {
        Route::get('/', [SettingController::class, 'index'])
            ->name('settings');

        Route::post('/add-bank', [SettingController::class, 'addBank'])
            ->name('settings.add.bank');

        Route::put(
            '/notifications/{id}',
            [SettingController::class, 'notifications']
        )->name('settings.notifications');
    });

    /*
    |--------------------------------------------------------------------------
    | Route khusus Admin
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:Admin'])->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Upload dan hapus gambar isi berita
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/backend-berita/upload-image',
            [BeritaController::class, 'uploadImage']
        )->name('backend-berita.upload-image');

        Route::post(
            '/backend-berita/delete-image',
            [BeritaController::class, 'deleteImage']
        )->name('backend-berita.delete-image');

        /*
        |--------------------------------------------------------------------------
        | Pengelolaan website
        |--------------------------------------------------------------------------
        */

        Route::resources([
            'backend-profile-sekolah' => ProfilSekolahController::class,
            'backend-visimisi' => VisidanMisiController::class,
            'program-studi' => ProgramController::class,
            'backend-kegiatan' => KegiatanController::class,
            'backend-imageslider' => ImageSliderController::class,
            'backend-about' => AboutController::class,
            'backend-video' => VideoController::class,
            'backend-kategori-berita' => KategoriBeritaController::class,
            'backend-berita' => BeritaController::class,
            'backend-event' => EventsController::class,
            'backend-footer' => FooterController::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Alumni
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/backend-alumni',
            [AlumniController::class, 'index']
        )->name('backend-alumni.index');

        Route::post(
            '/backend-alumni/{user}',
            [AlumniController::class, 'store']
        )->name('backend-alumni.store');

        Route::delete(
            '/backend-alumni/{user}',
            [AlumniController::class, 'destroy']
        )->name('backend-alumni.destroy');

        /*
        |--------------------------------------------------------------------------
        | Pengelolaan pengguna
        |--------------------------------------------------------------------------
        */

        Route::resources([
            'backend-pengguna-pengajar' => PengajarController::class,
            'backend-pengguna-staf' => StafController::class,
            'backend-pengguna-murid' => MuridController::class,
            'backend-pengguna-ppdb' => PPDBController::class,
            'backend-pengguna-perpus' => PerpusController::class,
            'backend-pengguna-bendahara' => BendaharaController::class,
        ]);
    });
});
