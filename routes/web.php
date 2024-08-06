<?php

use App\Http\Controllers\LiquidController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WasteController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/home', function () {
        return redirect('/');
    })->name('home');

    // about page
    Route::get('/about', function () {
        return view('about');
    })->name('about');

    // contact page
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    // setting page
    Route::get('/setting', function () {
        return view('settings');
    })->name('settings');

    Route::prefix('waste')->group(function () {
        Route::get('/', [WasteController::class, 'index'])->name('waste.index');
        Route::get('/create', [WasteController::class, 'create'])->name('waste.create');
        Route::post('/store', [WasteController::class, 'store'])->name('waste.store');
        Route::get('/edit/{id}', [WasteController::class, 'edit'])->name('waste.edit');
        Route::put('/update/{id}', [WasteController::class, 'update'])->name('waste.update');
        Route::prefix('liquid')->group(function () {
            Route::get('/', [LiquidController::class, 'liquid'])->name('waste.liquid');
            Route::get('/create', [LiquidController::class, 'create'])->name('waste.liquid.create');
            Route::post('/store', [LiquidController::class, 'store'])->name('waste.liquid.store');
            Route::get('/edit/{id}', [LiquidController::class, 'edit'])->name('waste.liquid.edit');
            Route::put('/update/{id}', [LiquidController::class, 'update'])->name('waste.liquid.update');
            Route::delete('/delete/{id}', [LiquidController::class, 'delete'])->name('waste.liquid.delete');

            Route::prefix('datatables')->group(function () {
                Route::get('/', [LiquidController::class, 'datatables'])->name('waste.liquid.datatables');
            });
        });

        Route::prefix('units')->group(function () {
            Route::get('/', [UnitController::class, 'units'])->name('waste.units');
            Route::post('/', [UnitController::class, 'store'])->name('waste.units.store');
            Route::get('/create', [UnitController::class, 'create'])->name('waste.units.create');
            Route::put('{id}', [UnitController::class, 'update'])->name('waste.units.update');
            Route::delete('{id}', [UnitController::class, 'delete'])->name('waste.units.delete');

            Route::prefix('datatables')->group(function () {
                Route::get('/', [UnitController::class, 'datatables'])->name('waste.units.datatables');
            });
        });
    });
});

require __DIR__ . '/auth.php';
