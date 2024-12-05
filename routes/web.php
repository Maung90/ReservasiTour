<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SopirController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\GuideController;

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
