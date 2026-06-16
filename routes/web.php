<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Kasir\SalesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Dashboard Redirect
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isKasir()) {
            return redirect()->route('kasir.pos');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['show', 'edit', 'update']);
    Route::resource('products', ProductController::class);
});

// Kasir Routes
Route::middleware(['auth', 'kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/pos', [SalesController::class, 'index'])->name('pos');
    Route::post('/cart/add/{product}', [SalesController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [SalesController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [SalesController::class, 'checkout'])->name('checkout');
});

// Profile Routes (Breeze Default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
