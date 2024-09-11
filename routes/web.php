<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListWasteController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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
        return redirect('dashboard');
    })->name('index');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/datatables', [DashboardController::class, 'datatables'])->name('dashboard.summary');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('home', function () {
        return redirect('/');
    })->name('home');

    // about page
    Route::get('about', function () {
        return view('about');
    })->name('about');

    // contact page
    Route::get('contact', function () {
        return view('contact');
    })->name('contact');

    // setting page
    Route::get('settings', function () {
        return view('settings');
    })->name('settings');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('create', [UserController::class, 'create'])->name('users.create');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::prefix('{id}')->group(function () {
            Route::get('show', [UserController::class, 'show'])->name('users.show');
            Route::get('edit', [UserController::class, 'edit'])->name('users.edit');
        });

        Route::prefix('datatables')->group(function () {
            Route::get('/', [UserController::class, 'datatables'])->name('users.datatables');
        });
    });

    Route::prefix('waste')->group(function () {
        Route::get('/', [WasteController::class, 'index'])->name('waste.index');
        Route::get('create', [WasteController::class, 'create'])->name('waste.create');
        Route::post('store', [WasteController::class, 'store'])->name('waste.store');
        Route::prefix('{id}')->group(function () {
            Route::get('show', [WasteController::class, 'show'])->name('waste.show');
            Route::get('edit', [WasteController::class, 'edit'])->name('waste.edit');
        });

        Route::prefix('datatables')->group(function () {
            Route::get('/', [WasteController::class, 'datatables'])->name('waste.datatables');
        });

        Route::prefix('waste-list')->group(function () {
            Route::get('/', [ListWasteController::class, 'liquid'])->name('waste.list');
            Route::get('create', [ListWasteController::class, 'create'])->name('waste.list.create');
            Route::post('store', [ListWasteController::class, 'store'])->name('waste.list.store');
            Route::put('{id}', [ListWasteController::class, 'update'])->name('waste.list.update');
            Route::delete('{id}', [ListWasteController::class, 'delete'])->name('waste.list.delete');
            Route::prefix('datatables')->group(function () {
                Route::get('/', [ListWasteController::class, 'datatables'])->name('waste.list.datatables');
            });

            Route::get('{liquidWaste}', [WasteController::class, 'getUnitByLiquidId'])->name('waste.getUnitByLiquid');
        });

        Route::prefix('units')->group(function () {
            Route::get('/', [UnitController::class, 'units'])->name('waste.units');
            Route::post('/', [UnitController::class, 'store'])->name('waste.units.store');
            Route::get('create', [UnitController::class, 'create'])->name('waste.units.create');
            Route::put('{id}', [UnitController::class, 'update'])->name('waste.units.update');
            Route::delete('{id}', [UnitController::class, 'delete'])->name('waste.units.delete');

            Route::prefix('datatables')->group(function () {
                Route::get('/', [UnitController::class, 'datatables'])->name('waste.units.datatables');
            });
        });
    });
});

Route::get('print', function () {
    return view('print');
})->name('print');

require __DIR__ . '/auth.php';
