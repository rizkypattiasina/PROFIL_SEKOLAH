<?php

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

use Illuminate\Support\Facades\Route;

Route::prefix('spp')->middleware(['auth', 'active.user', 'role:Bendahara|Admin'])->group(function() {
    Route::get('/', 'SPPController@index')->name('spp.index');

    Route::get('murid','SPPController@murid')->name('spp.murid.index');
    Route::get('murid/detail/{id}','SPPController@detail')->name('spp.murid.detail');
    Route::put('murid/update-pembayaran','SPPController@updatePembayaran')->name('spp.murid.update.pembayaran');
    Route::put('murid/tolak-pembayaran','SPPController@rejectPembayaran')->name('spp.murid.reject.pembayaran');

});

Route::prefix('spp')->middleware(['auth', 'active.user', 'role:Admin'])->group(function() {
    Route::get('/pengaturan','SPPController@setting')->name('spp.setting');
    Route::post('/update','SPPController@update')->name('spp.update');
});

