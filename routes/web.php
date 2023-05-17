<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KafeController;

Route::get('/', function () {
    return view('welcome');
});

//ambil data baru
Route::get('/kafe', [KafeController::class, 'index'])->name('index');
//tambah data baru
Route::post('/kafe/tambah-data',[KafeController::class, 'store'])->name('store');
//generet token csrf
Route::get('/generate-token',[KafeController::class,'createToken'])->name('createToken');
//menampilkan data yang sudah di hapus sementara oleh sofdeletes
Route::get('/kafe/show/trash', [KafeController::class, 'trash'])->name('trash');
//menghapus data permanent
Route::get('/kafe/trash/delete/permanent', [KafeController::class, 'permanentDelete'])->name('permanentDelete');
//ambil satu data spesifik
Route::get('/kafe/{id}', [KafeController::class, 'show'])->name('show');
//mengubah data tertentu
Route::patch('/kafe/update/{id}', [KafeController::class, 'update'])->name('update');
//menghapus data tertentu
Route::delete('/kafe/delete/{id}', [KafeController::class, 'destroy'])->name('destroy');
Route::get('/kafe/show/trash/{id}', [KafeController::class, 'restore'])->name('kafe');