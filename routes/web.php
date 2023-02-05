<?php

use App\Http\Controllers\AngkatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\DivisiController;


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
Route::controller(AngkatanController::class)->group(function() {
    Route::get('angkatan', 'index');
    Route::post('tambah-angkatan', 'store');
    Route::post('edit-angkatan', 'update');
    Route::post('hapus-angkatan', 'destroy');
});

// Divisi
Route::controller(DivisiController::class)->group(function() {
    Route::get('divisi', 'index');
    Route::post('tambah-divisi', 'store');

});


// Route get data ajax
Route::controller(DataAjaxController::class)->group(function() {
    Route::post('getIdAngkatan', 'getIdAngkatan');
    Route::get('getDataAngkatan', 'getDataAngkatan');

});