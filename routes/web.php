<?php

use App\Http\Controllers\Backend\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// ======= FRONTEND ======= \\

Route::get(
    '/',
    [App\Http\Controllers\Frontend\IndexController::class, 'index']
)->name('frontend.home');

    ///// MENU \\\\\
        //// PROFILE SEKOLAH \\\\
        Route::get('profile-sekolah',[App\Http\Controllers\Frontend\IndexController::class,'profileSekolah'])->name('profile.sekolah');

        //// VISI dan MISI
        Route::get('visi-dan-misi',[App\Http\Controllers\Frontend\IndexController::class,'visimisi'])->name('visimisi.sekolah');

        //// PROGRAM STUDI \\\\
        Route::get('program/{slug}', [App\Http\Controllers\Frontend\MenuController::class, 'programStudi']);
        //// PROGRAM STUDI \\\\
        Route::get('kegiatan/{slug}', [App\Http\Controllers\Frontend\MenuController::class, 'kegiatan']);

        /// BERITA \\\
        Route::get('berita',[App\Http\Controllers\Frontend\IndexController::class,'berita'])->name('berita');
        Route::get('berita/{slug}',[App\Http\Controllers\Frontend\IndexController::class,'detailBerita'])->name('detail.berita');

        /// EVENT \\\
        Route::get('event/{slug}',[App\Http\Controllers\Frontend\IndexController::class,'detailEvent'])->name('detail.event');
        Route::get('event',[App\Http\Controllers\Frontend\IndexController::class,'events'])->name('event');

Auth::routes(['register' => false]);


// ======= BACKEND ======= \\
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

     /// PROFILE \\\
    Route::resource('profile-settings',Backend\ProfileController::class);
    /// SETTINGS \\\
      Route::prefix('settings')->group( function(){
        // BANK
        Route::get('/',[App\Http\Controllers\Backend\SettingController::class,'index'])->name('settings');
        // TAMBAH BANK
        Route::post('add-bank',[App\Http\Controllers\Backend\SettingController::class,'addBank'])->name('settings.add.bank');
        // NOTIFICATIONS
        Route::put('notifications/{id}',[SettingController::class,'notifications']);
      });


    /// CHANGE PASSWORD
    Route::put('profile-settings/change-password/{id}',[App\Http\Controllers\Backend\ProfileController::class, 'changePassword'])->name('profile.change-password');

Route::prefix('/')
    ->middleware('role:Admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Upload gambar berita
        |--------------------------------------------------------------------------
        */

        Route::post(
            'backend-berita/upload-image',
            [
                App\Http\Controllers\Backend\Website\BeritaController::class,
                'uploadImage'
            ]
        )->name('backend-berita.upload-image');

        Route::post(
            'backend-berita/delete-image',
            [
                App\Http\Controllers\Backend\Website\BeritaController::class,
                'deleteImage'
            ]
        )->name('backend-berita.delete-image');


        /*
        |--------------------------------------------------------------------------
        | Website
        |--------------------------------------------------------------------------
        */

        Route::resources([
            'backend-profile-sekolah'
                => Backend\Website\ProfilSekolahController::class,

            'backend-visimisi'
                => Backend\Website\VisidanMisiController::class,

            'program-studi'
                => Backend\Website\ProgramController::class,

            'backend-kegiatan'
                => Backend\Website\KegiatanController::class,

            'backend-imageslider'
                => Backend\Website\ImageSliderController::class,

            'backend-about'
                => Backend\Website\AboutController::class,

            'backend-video'
                => Backend\Website\VideoController::class,

            'backend-kategori-berita'
                => Backend\Website\KategoriBeritaController::class,

            'backend-berita'
                => Backend\Website\BeritaController::class,

            'backend-event'
                => Backend\Website\EventsController::class,

            'backend-footer'
                => Backend\Website\FooterController::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pengguna
        |--------------------------------------------------------------------------
        */

        Route::resources([
            'backend-pengguna-pengajar'
                => Backend\Pengguna\PengajarController::class,

            'backend-pengguna-staf'
                => Backend\Pengguna\StafController::class,

            'backend-pengguna-murid'
                => Backend\Pengguna\MuridController::class,

            'backend-pengguna-ppdb'
                => Backend\Pengguna\PPDBController::class,

            'backend-pengguna-perpus'
                => Backend\Pengguna\PerpusController::class,

            'backend-pengguna-bendahara'
                => Backend\Pengguna\BendaharaController::class,
        ]);

    }); // menutup group role:Admin

}); // menutup group auth