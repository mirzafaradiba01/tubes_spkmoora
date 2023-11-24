<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DashboardController as ControllersDashboardController;
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


// Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/logout',[LoginController::class,'logout']);
// Route::get('/login',[LoginController::class,'login'])->name('login');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resources([
    'kriteriabobot' => KriteriadanBobotController::class
]);
Route::get('kriteriabobot/{kriteriabobot}/edit', [KriteriadanBobotController::class, 'edit'])->name('kriteriabobot.edit');




