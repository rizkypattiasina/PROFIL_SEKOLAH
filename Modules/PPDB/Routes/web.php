<?php

use Illuminate\Support\Facades\Route;

Route::prefix('ppdb')->group(function () {
    Route::get('/', 'PPDBController@index')->name('ppdb.index');
    Route::get('/register', 'AuthController@registerView')->middleware('guest')->name('ppdb.register');
    Route::post('/register', 'AuthController@registerStore')->middleware(['guest', 'throttle:10,1'])->name('ppdb.register.store');
});

Route::prefix('ppdb')->middleware(['auth', 'active.user', 'role:Guest'])->group(function () {
    Route::get('form-pendaftaran', 'PendaftaranController@index')->name('ppdb.form-pendaftaran');
    Route::put('form-pendaftaran', 'PendaftaranController@update')->name('ppdb.form-pendaftaran.update');
    Route::get('form-data-orangtua', 'PendaftaranController@dataOrtuView')->name('ppdb.form-orangtua');
    Route::put('form-data-orangtua', 'PendaftaranController@updateOrtu')->name('ppdb.form-orangtua.update');
    Route::get('form-berkas', 'PendaftaranController@berkasView')->name('ppdb.form-berkas');
    Route::put('form-berkas', 'PendaftaranController@berkasStore')->name('ppdb.form-berkas.update');
});

Route::prefix('ppdb')->middleware(['auth', 'active.user', 'role:PPDB|Admin'])->group(function () {
    Route::resource('data-murid', 'DataMuridController')->only(['index', 'show', 'update']);
    Route::put('data-murid/{data_murid}/reject', 'DataMuridController@reject')->name('data-murid.reject');
    Route::resource('ppdb-content', 'PpdbContentController')->except(['show']);
});
