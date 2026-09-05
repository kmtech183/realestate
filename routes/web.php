<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyVisitController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. PUBLIC ROUTES
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');
#Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->middleware('track.views')->name('properties.show');
Route::post('/properties/{property:slug}/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
Route::post('/properties/{property:slug}/visits', [PropertyVisitController::class, 'store'])->name('visits.store');

// ==========================================
// 2. AUTHENTICATED BUYER PORTAL
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{property}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Profile Management (Breeze Volt)
    Route::view('/profile', 'profile')->name('profile.edit');
    Route::view('/profile', 'profile')->name('profile');
});

// ==========================================
// 3. AGENT PORTAL (Manage Listings & Inquiries)
// ==========================================
Route::middleware(['auth', 'role:agent,admin'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', AgentDashboardController::class)->name('dashboard');
    Route::resource('properties', PropertyController::class);
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');
    Route::get('/visits', [PropertyVisitController::class, 'index'])->name('visits.index');
    Route::patch('/visits/{visit}/status', [PropertyVisitController::class, 'updateStatus'])->name('visits.update-status');
});

// ==========================================
// 4. ADMIN PANEL (Platform-Wide Oversight)
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
});

require __DIR__ . '/auth.php';
