<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SopirController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TagihanController;

Route::get('/', function () {
    return view('home');
});

Route::controller(VendorController::class)->group(function () {
    Route::get('/vendor/table/vendor', 'tableVendor')->name('Vendor.tableVendor');
    Route::get('/vendor', 'vendor');

    Route::post('/vendor', 'store')->name('vendor.store'); // Create
    Route::get('/vendor/get/{id}', 'get')->name('vendor.get'); //Read
    Route::put('/vendor/{id}', 'update')->name('vendor.update'); // Update
    Route::delete('/vendor/{id}', 'destroy')->name('vendor.destroy'); //Delete
});


Route::controller(SopirController::class)->group(function () {
    Route::get('/sopir/table/sopir', 'tableSopir')->name('sopir.tableSopir');
    Route::get('/sopir', 'sopir');

    Route::post('/sopir', 'store')->name('sopir.store'); // Create
    Route::get('/sopir/get/{id}', 'get')->name('sopir.get'); //Read
    Route::put('/sopir/{id}', 'update')->name('sopir.update'); // Update
    Route::delete('/sopir/{id}', 'destroy')->name('sopir.destroy'); //Delete
});

Route::controller(BahasaController::class)->group(function () {
    Route::get('/bahasa/table/bahasa', 'tableBahasa')->name('bahasa.tableBahasa');
    Route::get('/bahasa', 'bahasa');
    Route::get('/bahasa/getAllBahasa','getAllBahasa')->name('bahasa.getAllBahasa');

    Route::post('/bahasa', 'store')->name('bahasa.store'); // Create
    Route::get('/bahasa/get/{id}', 'get')->name('bahasa.get'); //Read
    Route::put('/bahasa/{id}', 'update')->name('bahasa.update'); // Update
    Route::delete('/bahasa/{id}', 'destroy')->name('bahasa.destroy'); //Delete
});


Route::controller(UserController::class)->group(function () {
    Route::get('/user/table/user', 'tableUser')->name('user.tableUser');
    Route::get('/user', 'user');

    Route::post('/user', 'store')->name('user.store'); // Create
    Route::get('/user/get/{id}', 'get')->name('user.get'); //Read
    Route::put('/user/{id}', 'update')->name('user.update'); // Update
    Route::delete('/user/{id}', 'destroy')->name('user.destroy'); //Delete
});

Route::controller(KendaraanController::class)->group(function () {
    Route::get('/kendaraan/table/kendaraan', 'tableKendaraan')->name('kendaraan.tableKendaraan');
    Route::get('/kendaraan', 'kendaraan');

    Route::post('/kendaraan', 'store')->name('kendaraan.store'); // Create
    Route::get('/kendaraan/get/{id}', 'get')->name('kendaraan.get'); //Read
    Route::put('/kendaraan/{id}', 'update')->name('kendaraan.update'); // Update
    Route::delete('/kendaraan/{id}', 'destroy')->name('kendaraan.destroy'); //Delete
});

Route::controller(GuideController::class)->group(function () {
    Route::get('/guide/table/guide', 'tableGuide')->name('guide.tableGuide');
    Route::get('/guide', 'guide');

    Route::post('/guide', 'store')->name('guide.store'); // Create
    Route::get('/guide/get/{id}', 'get')->name('guide.get'); //Read
    Route::put('/guide/{id}', 'update')->name('guide.update'); // Update
    Route::delete('/guide/{id}', 'destroy')->name('guide.destroy'); //Delete
});

Route::controller(ReservasiController::class)->group(function () {
    Route::get('/reservasi/table/reservasi', 'tableReservasi')->name('reservasi.tableReservasi');
    Route::get('/reservasi', 'reservasi');

    Route::post('/reservasi', 'store')->name('reservasi.store'); // Create
    Route::get('/reservasi/get/{id}', 'get')->name('reservasi.get'); //Read
    Route::put('/reservasi/{id}', 'update')->name('reservasi.update'); // Update
    Route::delete('/reservasi/{id}', 'destroy')->name('reservasi.destroy'); //Delete
});

Route::controller(TagihanController::class)->group(function () {
    Route::get('/tagihan', 'tagihan');
    Route::get('/tagihan/table/tagihan', 'tabletagihan')->name('tagihan.tableTagihan');
    Route::get('/tagihan/payment/{id}', 'tagihanPayment')->name('tagihan.payment');

    Route::post('/tagihan', 'store')->name('tagihan.store'); // Create
    Route::get('/tagihan/get/{id}', 'get')->name('tagihan.get'); // Read
    Route::put('/tagihan/{id}', 'update')->name('tagihan.update'); // Update
    Route::delete('/tagihan/{id}', 'destroy')->name('tagihan.destroy'); // Delete
});

Route::post('/tagihan/callback', [TagihanController::class, 'handlePaymentCallback']);


