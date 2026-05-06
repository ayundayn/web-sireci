<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PreferenceController;

Route::get('auth/google', [GoogleController::class, 'redirect']);
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/', [UserController::class, 'index'])->name('beranda');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/wisata/{id}', [UserController::class, 'detailWisata'])->name('detail.wisata');
Route::get('/kuliner/{id}', [UserController::class, 'detailKuliner'])->name('detail.kuliner');

Route::get('/detail/wisata/{id}', [SearchController::class, 'show'])->name('detail.wisata');
Route::get('/detail/kuliner/{id}', [SearchController::class, 'show'])->name('detail.kuliner');

Route::get(
    '/favorit',
    [UserController::class, 'favorit']
)->name('favorit');

Route::post('/favorit/toggle', [UserController::class, 'toggleFavorit'])
    ->name('favorit.toggle');

Route::get(
    '/itinerary',
    [UserController::class, 'itinerary']
)->name('itinerary');

Route::post('/api/preferences', [PreferenceController::class, 'store']);
Route::post('/api/preferences/clear', [PreferenceController::class, 'clear']);


Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->name('admin.login');

Route::post(
    '/admin/login',
    [AuthenticatedSessionController::class, 'store']
);



Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get(
        '/kategori',
        [KategoriController::class, 'index']
    )->name('kategori.index');

    Route::post(
        '/kategori/store',
        [KategoriController::class, 'store']
    )->name('kategori.store');

    Route::put(
        '/kategori/{id}',
        [KategoriController::class, 'update']
    )->name('kategori.update');

    Route::delete(
        '/kategori/{id}',
        [KategoriController::class, 'destroy']
    )->name('kategori.destroy');

});


require __DIR__ . '/auth.php';
