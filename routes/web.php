<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;

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
