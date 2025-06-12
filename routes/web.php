<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\MasterKaryawanController;
use App\Http\Controllers\LapabsenController;
use App\Http\Controllers\LaplemburController;
use App\Http\Controllers\LapizinController;
use App\Http\Controllers\LapcutiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AbsenPimpinanController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\PengajuanController;


Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get("/produk", [ProdukController::class, 'index'])->name('index.index');
Route::get('/create', [ProdukController::class, 'create'])->name('index.create');
route::get('/produk/edit{id}', [ProdukController::class, 'edit'])->name('index.edit');
route::put('/produk/update{id}', [ProdukController::class, 'update'])->name('index.update');
Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('index.destroy');
route::post('/produk/store', [ProdukController::class, 'store'])->name('index.store');
Route::get('/produk/show/{id}', [ProdukController::class, 'show'])->name('index.show');


Route::resource('karyawan', MasterKaryawanController::class);

Route::get('/absen/pimpinan', [AbsenPimpinanController::class, 'index'])->name('absen.pimpinan');
Route::post('/absen/pimpinan/store', [AbsenPimpinanController::class, 'store'])->name('absen.pimpinan.store');


Route::get("/lapabsen", [LapabsenController::class, 'index'])->name('lapabsen.index');
Route::delete('/lapabsen/{id}', [LapabsenController::class, 'destroy'])->name('lapabsen.destroy');


Route::get('/laplembur', [LaplemburController::class, 'index'])->name('laplembur.index');
Route::get('/selengkapnya/{id}/edit', [LaplemburController::class, 'edit'])->name('laplembur.edit');
Route::put('/laplembur/{id}', [LaplemburController::class, 'update'])->name('laplembur.update');
Route::delete('/laplembur/{id}', [LaplemburController::class, 'destroy'])->name('laplembur.destroy');

Route::get("/lapizin", [LapizinController::class, 'index'])->name('lapizin.index');
Route::get('/lapizin/{id}/edit', [LapizinController::class, 'edit'])->name('lapizin.edit');
Route::put('/lapizin/{id}', [LapizinController::class, 'update'])->name('lapizin.update');
Route::delete('/lapizin/{id}', [LapizinController::class, 'destroy'])->name('lapizin.destroy');


Route::get("/lapcuti", [LapcutiController::class, 'index'])->name('lapcuti.index');
Route::get('/selengkapnya/{id}', [LapcutiController::class, 'edit'])->name('lapcuti.edit');
Route::put('/lapcuti/{id}', [LapcutiController::class, 'update'])->name('lapcuti.update');
Route::delete('/lapcuti/{id}', [LapcutiController::class, 'destroy'])->name('lapcuti.destroy');


Route::get('/absen', [AbsenController::class, 'create'])->name('absen.create');
Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
Route::get('/izin/pdf/{id}', [LapizinController::class, 'downloadPDF'])->name('izin.download.pdf');


Route::get('/izin', [PengajuanController::class, 'createIzin'])->name('pengajuan.izin');
Route::post('/izin', [PengajuanController::class, 'storeIzin'])->name('pengajuan.izin.store');

Route::get('/cuti', [PengajuanController::class, 'createCuti'])->name('pengajuan.cuti');
Route::post('/cuti', [PengajuanController::class, 'storeCuti'])->name('pengajuan.cuti.store');

Route::get('/lembur', [PengajuanController::class, 'createLembur'])->name('pengajuan.lembur');
Route::post('/lembur', [PengajuanController::class, 'storeLembur'])->name('pengajuan.lembur.store');



