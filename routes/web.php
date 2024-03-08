<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\InventoryLabController;
use App\Http\Controllers\KodeAsistenController;
use App\Http\Controllers\LapRapatController;
use App\Http\Controllers\NamaLabController;
use App\Http\Controllers\PjLabController;
use App\Http\Controllers\RegistrasiAsistenControlller;

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
Route::controller(AngkatanController::class)->group(function () {
    Route::get('angkatan', 'index');
    Route::post('tambah-angkatan', 'store');
    Route::post('hapus-angkatan', 'destroy');
});

// Divisi
Route::controller(DivisiController::class)->group(function () {
    Route::get('divisi', 'index');
    Route::post('tambah-divisi', 'store');
    Route::post('hapus-divisi', 'destroy');
});

// Kode Asisten
Route::controller(KodeAsistenController::class)->group(function () {
    Route::get('kode-asisten', 'index');
    Route::post('tambah-kode', 'store');
    Route::post('hapus-kode', 'destroy');
});

// Profile
Route::controller(BiodataController::class)->group(function () {
    Route::get('profile', 'profile');
});

// Nama Lab
Route::controller(NamaLabController::class)->group(function () {
    Route::get('nama-lab', 'index');
    Route::post('tambah-lab', 'store');
    Route::post('edit-lab', 'update');
    Route::post('hapus-lab', 'destroy');
});

// Pj Lab
Route::controller(PjLabController::class)->group(function () {
    Route::get('pj-lab', 'index');
    Route::post('pj-lab', 'store');
    Route::post('hapus-pj-lab', 'destroy');
    Route::post('nonaktif-pj-lab', 'nonaktif');
});

// Lap Rapat
Route::controller(LapRapatController::class)->group(function () {
    Route::get('lap-rapat', 'index');
    Route::post('tambah-lap-rapat', 'store');
    Route::get('lap-rapat-cetak/{id}', 'cetak');
    Route::post('lap-rapat-hapus', 'destroy');
});

// Route get data ajax
Route::controller(DataAjaxController::class)->group(function () {
    // angkatan
    Route::post('getIdAngkatan', 'getIdAngkatan');
    Route::get('getDataAngkatan', 'getDataAngkatan');

    // divisi
    Route::post('getIdDivisi', 'getIdDivisi');

    // kode asisten
    Route::post('getIdKode', 'getIdKode');

    // nama lab
    Route::post('getIdLab', 'getIdLab');

    // lap rapat
    Route::post('getIdLapRapat', 'getIdLapRapat');

    // Biodata
    Route::post('getIdBiodata', 'getIdBiodata');

    // Pj Lab
    Route::post('getIdPjLab', 'getIdPjLab');

    // Pj Lab
    Route::post('getIdInventoryLab', 'getIdInventoryLab');
});

// Registrasi Asisten
Route::controller(RegistrasiAsistenControlller::class)->group(function () {
    Route::get('registrasi-asisten', 'index');
    Route::get('tambah-asisten', 'tambah_asisten');
    Route::post('tambah-asisten', 'store');
    Route::post('hapus-asisten', 'destroy');
});

Route::controller(InventoryLabController::class)->group(function () {
    Route::get('inventory-lab', 'index');
    Route::post('inventory-lab', 'store');
    Route::post('addnew-item-lab', 'addNewRow');
    Route::post('delete-item-lab', 'deleteItem');
    // Route::get('tambah-asisten', 'tambah_asisten');
    // Route::post('tambah-asisten', 'store');
    // Route::post('hapus-asisten', 'destroy');
});
