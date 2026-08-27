<?php

use App\Http\Controllers\PesertaController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MenuController;

use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'login']);
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('actionLogin', [LoginController::class, 'actionLogin'])->name('actionLogin');
// method : GET, POST, PUT, DELETE, PATCH
// GET : Lihat dan baca
// POST : mengirim data dari form, aksinya insert
// PUT : mengirim data dari form, aksinya update
// DELETE : mengirim data dari form, aksinya delete
// PATCH : mengirim data dari form, aksinya update
Route::get('counting', [BelajarController::class, 'index']);
Route::get('salam', [BelajarController::class, 'greeting']);
Route::get('hitung-tambah', [BelajarController::class, 'tambah']);

// kurang
Route::get('hitung-kurang', [BelajarController::class, 'indexKurang']);
Route::post('action-kurang', [BelajarController::class, 'kurang']);

// kali
Route::get('hitung-kali', [BelajarController::class, 'indexKali']);
Route::post('action-kali', [BelajarController::class, 'kali']);

// bagi
Route::get('hitung-bagi', [BelajarController::class, 'indexBagi']);
Route::post('action-bagi', [BelajarController::class, 'bagi']);

//PesertaController
Route::get('peserta', [PesertaController::class, 'index']);
Route::get('create', [PesertaController::class, 'create'])->name('create');
Route::post('store-peserta', [PesertaController::class, 'store'])->name('store-peserta');
Route::get('edit/{id}', [PesertaController::class, 'edit'])->name('edit.peserta');
Route::put('update/{id}', [PesertaController::class, 'update'])->name('update.peserta');
Route::delete('delete/{id}', [PesertaController::class, 'delete'])->name('delete.peserta');

//middleware:
Route::middleware('auth')->group(function(){
    Route::resource('dashboard', DashboardController::class);
    Route::resource('role', RoleController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('menu', MenuController::class);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});
//role
