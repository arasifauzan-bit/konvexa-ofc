<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WebsiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('produk.show');

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('admin.login.store');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'can:access-admin'])
    ->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [WebsiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [WebsiteSettingsController::class, 'update'])->name('settings.update');
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    });