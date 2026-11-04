<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | CRUD Buku
    |--------------------------------------------------------------------------
    |
    | Hak akses mengikuti matriks pada lembar tugas dan diperiksa di sisi server
    | memakai middleware "permission:..." dari Spatie (bukan hanya menyembunyikan
    | tombol di view).
    |
    | Rute "items/create" sengaja didaftarkan sebelum "items/{item}" supaya
    | /items/create tidak dianggap sebagai detail buku.
    |
    */

    // Admin, Dosen, Mahasiswa
    Route::middleware('permission:view-books')->group(function () {
        Route::get('items', [ItemController::class, 'index'])->name('items.index');
    });

    // Admin, Dosen
    Route::middleware('permission:create-books')->group(function () {
        Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('items', [ItemController::class, 'store'])->name('items.store');
    });

    // Admin, Dosen
    Route::middleware('permission:edit-books')->group(function () {
        Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('items/{item}', [ItemController::class, 'update'])->name('items.update');
    });

    // Admin saja
    Route::middleware('permission:delete-books')->group(function () {
        Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    });

    // Detail buku (didokumentasikan setelah create agar urutan rute benar)
    Route::middleware('permission:view-books')->group(function () {
        Route::get('items/{item}', [ItemController::class, 'show'])->name('items.show');
    });

    // Kategori buku: data master, hanya Admin
    Route::middleware('permission:manage-categories')->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    // Kelola role pengguna: hanya Admin
    Route::middleware('permission:manage-users')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
