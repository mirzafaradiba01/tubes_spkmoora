<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DashboardController as ControllersDashboardController;
use App\Http\Controllers\DataPenilaianController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KriteriadanBobotController;
use App\Http\Controllers\LayoutsController;
use App\Models\KriteriadanBobot;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
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


Route::get('/logout', [LoginController::class, 'logout']);

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::post('telo', [AlternatifController::class, 'store']);
    
    Route::resources([
        'kriteriabobot' => KriteriadanBobotController::class,
        'alternatif' => AlternatifController::class,
        'datapenilaian' => DataPenilaianController::class,
    ]);


    Route::post('alternatif/data', [AlternatifController::class, 'data'])->name('alternatif.data'); // Menambahkan rute untuk DataTables
    Route::get('alternatif/delete/{id}', [AlternatifController::class, 'destroy'])->name('alternatif.delete'); // Rute untuk menghapus data
    Route::get('kriteriabobot/{kriteriabobot}/edit', [KriteriadanBobotController::class, 'edit'])->name('kriteriabobot.edit');
});

Route::fallback(function () {
    return redirect('/login');
});






