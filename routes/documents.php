<?php

use App\Http\Controllers\DocumentController;
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

Route::prefix('documents')->group(function () {
    Route::prefix('electrocardiography')->group(function () {
        Route::get('/', [DocumentController::class, 'electrocardiography'])->name('documents.electrocardiography');
        Route::get('print', [DocumentController::class, 'electrocardiographyPrint'])->name('documents.electrocardiography.print');
    });
});
