<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth Route
Route::get('/', [AuthController::class, 'index']);
Route::get('register', [AuthController::class, 'register']);

Route::post('/register-valid', [AuthController::class, 'store']);
Route::post('/login-valid', [AuthController::class, 'loginValid']);



// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);


// Angkatan
// Route::get('/angkatan', [AngkatanController::class, 'index']);
// Route::post('/tambah-angkatan', [AngkatanController::class, 'store']);
Route::resource('angkatan', AngkatanController::class);


