<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route halaman utama (beranda)
Route::get('/', function () {
    return view('login.login');
})->name('login');

// Route halaman home
Route::get('/home', [HomeController::class, 'index'])->name('home.home');

// Halaman About (tanpa autentikasi)
Route::get('/about', function () {
    return view('about.index');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware untuk akses user
Route::middleware(['auth', 'user-access:user'])->prefix('user')->group(function () {
    Route::get('/about', [ProfileController::class, 'index'])->name('about.index');
    Route::get('/about/edit/{id}', [ProfileController::class, 'edit'])->name('about.edit');
    Route::put('/about/update/{id}', [ProfileController::class, 'update'])->name('about.update');
    Route::get('/home', [HomeController::class, 'index'])->name('user.home.home');
    Route::get('/home/laporan', [HomeController::class, 'generatePDF'])->name('home.laporan');
    Route::get('/arsip', [ArsipController::class, 'index'])->name('user.arsip.index');
    Route::get('/arsip/create', [KategoriController::class, 'create'])->name('arsip.create');
    Route::post('/arsip/store', [ArsipController::class, 'store'])->name('arsip.store');
    Route::get('/arsip/show/{id}', [ArsipController::class, 'show'])->name('arsip.show');
    Route::get('/arsip/download/pdf/{id}', [ArsipController::class, 'download'])->name('arsip.download');
    Route::get('/arsip/edit/{id}', [ArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/arsip/update/{id}', [ArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/arsip/delete/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::resource('arsip', ArsipController::class);
});

// Middleware untuk akses admin
Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
    Route::get('/about', [ProfileController::class, 'index'])->name('about.index');
    Route::get('/about/edit/{id}', [ProfileController::class, 'edit'])->name('about.edit');
    Route::put('/about/update/{id}', [ProfileController::class, 'update'])->name('about.update');
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home.home');
    Route::get('/home/laporan', [HomeController::class, 'generatePDF'])->name('home.laporan');
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/create', [KategoriController::class, 'create'])->name('arsip.create');
    Route::post('/arsip/store', [ArsipController::class, 'store'])->name('arsip.store');
    Route::get('/arsip/show/{id}', [ArsipController::class, 'show'])->name('arsip.show');
    Route::get('/arsip/download/pdf/{id}', [ArsipController::class, 'download'])->name('arsip.download');
    Route::get('/arsip/edit/{id}', [ArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/arsip/update/{id}', [ArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/arsip/delete/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::resource('arsip', ArsipController::class);
    Route::resource('kategori', KategoriController::class);

});
