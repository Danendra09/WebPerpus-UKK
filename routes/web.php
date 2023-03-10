<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;



//Route Untuk User
Route::get('/', [BukuController::class, 'indexPublic'])->name('buku.public.index');
Route::get('/bukus/{id}', [BukuController::class, 'showPublic'])->name('buku.public.show');

//Route Untuk Admin
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [BukuController::class, 'index'])->name('buku.index');
    Route::resource('buku', BukuController::class);
});