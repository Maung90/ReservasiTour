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
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\EnsureAuthenticated;




Route::get('/', function () {
    return view('auth/login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login');
    Route::post('/login', 'submit')->name('auth.login'); 
    Route::post('/logout', 'logout')->name('logout'); 
});

Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard');
        Route::get('/dashboard/getAgentWeekChart','getAgentWeekChart')->name('dashboard.getAgentWeekChart');
        Route::get('/dashboard/getAgentYearChart','getAgentYearChart')->name('dashboard.getAgentYearChart');
        Route::get('/dashboard/getTopProgram','getTopProgram')->name('dashboard.getTopProgram');
        Route::get('/dashboard/getDailyIncome/{days}','getDailyIncome')->name('dashboard.getDailyIncome');
    }); 
});


Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(VendorController::class)->group(function () {
        Route::get('/vendor/table/vendor', 'tableVendor')->name('Vendor.tableVendor');
        Route::get('/vendor', 'vendor');

        Route::post('/vendor', 'store')->name('vendor.store'); 
        Route::get('/vendor/get/{id}', 'get')->name('vendor.get'); 
        Route::put('/vendor/{id}', 'update')->name('vendor.update');
        Route::delete('/vendor/{id}', 'destroy')->name('vendor.destroy');
    }); 
});


Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(SopirController::class)->group(function () {
        Route::get('/sopir/table/sopir', 'tableSopir')->name('sopir.tableSopir');
        Route::get('/sopir', 'sopir');

        Route::post('/sopir', 'store')->name('sopir.store'); 
        Route::get('/sopir/get/{id}', 'get')->name('sopir.get'); 
        Route::put('/sopir/{id}', 'update')->name('sopir.update');
        Route::delete('/sopir/{id}', 'destroy')->name('sopir.destroy');
    });
});
Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(BahasaController::class)->group(function () {
        Route::get('/bahasa/table/bahasa', 'tableBahasa')->name('bahasa.tableBahasa');
        Route::get('/bahasa', 'bahasa');
        Route::get('/bahasa/getAllBahasa','getAllBahasa')->name('bahasa.getAllBahasa');

        Route::post('/bahasa', 'store')->name('bahasa.store'); 
        Route::get('/bahasa/get/{id}', 'get')->name('bahasa.get'); 
        Route::put('/bahasa/{id}', 'update')->name('bahasa.update');
        Route::delete('/bahasa/{id}', 'destroy')->name('bahasa.destroy');
    });
});

Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/table/user', 'tableUser')->name('user.tableUser');
        Route::get('/user', 'user');

        Route::post('/user', 'store')->name('user.store'); 
        Route::get('/user/get/{id}', 'get')->name('user.get'); 
        Route::put('/user/{id}', 'update')->name('user.update');
        Route::delete('/user/{id}', 'destroy')->name('user.destroy');
    });
});
Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(KendaraanController::class)->group(function () {
        Route::get('/kendaraan/table/kendaraan', 'tableKendaraan')->name('kendaraan.tableKendaraan');
        Route::get('/kendaraan', 'kendaraan');

        Route::post('/kendaraan', 'store')->name('kendaraan.store'); 
        Route::get('/kendaraan/get/{id}', 'get')->name('kendaraan.get'); 
        Route::put('/kendaraan/{id}', 'update')->name('kendaraan.update');
        Route::delete('/kendaraan/{id}', 'destroy')->name('kendaraan.destroy');
    });
});
Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(GuideController::class)->group(function () {
        Route::get('/guide/table/guide', 'tableGuide')->name('guide.tableGuide');
        Route::get('/guide', 'guide');

        Route::post('/guide', 'store')->name('guide.store'); 
        Route::get('/guide/get/{id}', 'get')->name('guide.get'); 
        Route::put('/guide/{id}', 'update')->name('guide.update');
        Route::delete('/guide/{id}', 'destroy')->name('guide.destroy');
    });
});
Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(ReservasiController::class)->group(function () {
        Route::get('/reservasi/table/reservasi', 'tableReservasi')->name('reservasi.tableReservasi');
        Route::get('/reservasi', 'reservasi');

        Route::get('reservasi-paket', 'paketReservasi');
        Route::get('reservasi-custom', 'customReservasi');

        Route::post('/reservasi', 'store')->name('reservasi.store'); 
        Route::get('/reservasi/all/', 'getReservasi')->name('reservasi.getReservasi'); 
        Route::get('/reservasi/get/{id}', 'get')->name('reservasi.get'); 
        Route::put('/reservasi/{id}', 'update')->name('reservasi.update');
        Route::delete('/reservasi/{id}', 'destroy')->name('reservasi.destroy');
    });
});
Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(TagihanController::class)->group(function () {
        Route::get('/tagihan', 'tagihan');
        Route::get('/tagihan/table/tagihan', 'tabletagihan')->name('tagihan.tableTagihan');
        Route::get('/tagihan/payment/{id}', 'tagihanPayment')->name('tagihan.payment');

        Route::post('/tagihan', 'store')->name('tagihan.store'); 
        Route::get('/tagihan/get/{id}', 'get')->name('tagihan.get'); 
        Route::put('/tagihan/{id}', 'update')->name('tagihan.update');
        Route::delete('/tagihan/{id}', 'destroy')->name('tagihan.destroy'); 
    });
});
Route::post('/tagihan/callback', [TagihanController::class, 'handlePaymentCallback']);

Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(ProgramController::class)->group(function () {
        Route::get('/guide/table/program', 'tableProgram')->name('program.tableProgram');
        Route::get('/program', 'program');

        Route::post('/program', 'store')->name('program.store'); 
        Route::get('/program/get/{id}', 'get')->name('program.get'); 
        Route::put('/program/{id}', 'update')->name('program.update');
        Route::delete('/program/{id}', 'destroy')->name('program.destroy');
    });
});

Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::controller(ProdukController::class)->group(function () {
        Route::get('/guide/table/produk', 'tableProduk')->name('produk.tableProduk');
        Route::get('/produk', 'produk');

        Route::post('/produk', 'store')->name('produk.store'); 
        Route::get('/produk/get/{id}', 'get')->name('produk.get'); 
        Route::put('/produk/{id}', 'update')->name('produk.update');
        Route::delete('/produk/{id}', 'destroy')->name('produk.destroy');
    });
});