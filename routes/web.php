<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SopirController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\UserController;

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

