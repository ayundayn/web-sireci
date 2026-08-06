<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\KulinerController;
use App\Http\Controllers\admin\UatAdminController;
use App\Http\Controllers\admin\WisataController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\WisataController as UserWisataController;
use App\Http\Controllers\KulinerController as UserKulinerController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\UatController;
use App\Http\Controllers\BpwController;

Route::get('auth/google', [GoogleController::class, 'redirect']);
Route::get('auth/google/callback', [GoogleController::class, 'callback']);
Route::post('/logout', [GoogleController::class, 'logout'])
    ->name('logout');

Route::get('/', [UserController::class, 'index'])->name('beranda');

Route::get('/wisata', [UserWisataController::class, 'index'])->name('wisata.index');
Route::get('/kuliner', [UserKulinerController::class, 'index'])->name('kuliner.index');

Route::get(
    '/favorit',
    [UserController::class, 'favorit']
)->name('favorit');

Route::post('/preferences', [PreferenceController::class, 'store']);

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/wisata/{id}', [UserController::class, 'detailWisata'])->name('detail.wisata');
Route::get('/kuliner/{id}', [UserController::class, 'detailKuliner'])->name('detail.kuliner');

Route::get('/detail/{type}/{id}', [SearchController::class, 'show'])
    ->name('detail.show');

Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])
    ->name('favorit.toggle');

Route::post('/rating', [RatingController::class, 'store'])
    ->name('rating.store');

Route::post(
    '/generate-itinerary',
    [ItineraryController::class, 'generate']
)->name('itinerary.generate');

Route::post(
    '/generate-itenary',
    [ItineraryController::class, 'generate']
);

Route::post(
    '/group-itinerary',
    [ItineraryController::class, 'group']
)->name('group.itinerary');

Route::get(
    '/group-itinerary',
    [ItineraryController::class,'showGroup']
)->name('group.itinerary.show');

Route::get(
    '/mitra-bpw',
    [BpwController::class,'index']
)->name('bpw.index');

Route::get(
    '/itinerary-page',
    [ItineraryController::class, 'page']
)->name('itinerary.page');

Route::post(
    '/itinerary/export-pdf',
    [ItineraryController::class, 'exportPdf']
)->name('itinerary.pdf');

Route::get('/uat', [UatController::class, 'index'])
    ->name('uat.index');

Route::post('/uat/store', [UatController::class, 'store'])
    ->name('uat.store');

Route::post('/api/preferences', [PreferenceController::class, 'store']);
Route::post('/api/preferences/clear', [PreferenceController::class, 'clear']);

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->name('admin.login');

Route::post(
    '/admin/login',
    [AuthenticatedSessionController::class, 'store']
);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

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

    // WISATA CRUD
    Route::resource('wisata', WisataController::class)
        ->names('admin.wisata');

    // KULINER CRUD
    Route::resource('kuliner', KulinerController::class)
        ->names('admin.kuliner');

    Route::get('/uat', [UatAdminController::class, 'index'])
        ->name('admin.uat.index');

    Route::get('/uat/{id}', [UatAdminController::class, 'show'])
        ->name('admin.uat.show');

    Route::get(
        '/admin/uat/download/rekomendasi',
        [UatController::class, 'downloadRekomendasi']
    )
        ->name('admin.uat.download.rekomendasi');

    Route::get(
        '/admin/uat/download/itinerary',
        [UatController::class, 'downloadItinerary']
    )
        ->name('admin.uat.download.itinerary');

});


require __DIR__ . '/auth.php';
