<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RedirectController as AdminRedirectController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\CsrController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DigitalizationItemController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EntityDetailController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyRouteController;
use App\Http\Controllers\MediaCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/corporate', [CorporateController::class, 'index'])->name('corporate.index');
Route::get('/corporate/{slug}', [CorporateController::class, 'show'])->name('corporate.show');

Route::redirect('/k3l', '/corporate/hse-overview', 301);
Route::redirect('/career', '/corporate/careers', 301);

Route::get('/business-units', [BusinessUnitController::class, 'index'])->name('business-units.index');
Route::get('/business-units/{slug}', [BusinessUnitController::class, 'show'])->name('business-units.show');

Route::get('/csr', [CsrController::class, 'index'])->name('csr.index');
Route::get('/csr/{slug}', [CsrController::class, 'show'])->name('csr.show');

Route::get('/media-center', [MediaCenterController::class, 'index'])->name('media-center.index');
Route::get('/media-center/{type}', [MediaCenterController::class, 'type'])
    ->where('type', 'news|press-release|multimedia|gallery')
    ->name('media-center.type');
Route::get('/media-center/{type}/{slug}', [MediaCenterController::class, 'show'])
    ->where('type', 'news|press-release|multimedia|gallery')
    ->name('media-center.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Digitalisasi Monitoring Routes
Route::prefix('monitoring')->name('monitoring.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');

    // Entities Management & Detail
    Route::resource('entities', EntityController::class);
    Route::delete('/entities/{entity}/force', [EntityController::class, 'forceDelete'])->name('entities.forceDelete');
    Route::post('/entities/{id}/restore', [EntityController::class, 'restore'])->name('entities.restore');
    
    // Entity Detail dengan tasks
    Route::get('/entities/{entity}/detail', [EntityDetailController::class, 'show'])->name('entities.detail');
    Route::post('/entities/{entity}/tasks', [EntityDetailController::class, 'attachTask'])->name('entities.attachTask');
    Route::put('/entities/{entity}/tasks/{task}', [EntityDetailController::class, 'updateTaskProgress'])->name('entities.updateTaskProgress');
    Route::get('/entities/{entity}/tasks/{task}/history', [EntityDetailController::class, 'getTaskHistory'])->name('entities.taskHistory');
    Route::delete('/entities/{entity}/tasks/{task}', [EntityDetailController::class, 'detachTask'])->name('entities.detachTask');

    // Items Management
    Route::resource('items', DigitalizationItemController::class);
    Route::post('/items/{item}/progress', [DigitalizationItemController::class, 'updateProgress'])->name('items.updateProgress');
    Route::get('/items/entity/{entity}', [DigitalizationItemController::class, 'getByEntity'])->name('items.byEntity');
});

Route::prefix('admin')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
    });

    Route::middleware('auth')->name('admin.')->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Master Digitalization Tasks (MIST only)
        Route::resource('tasks', AdminTaskController::class);

        Route::get('/content/{section}', [AdminContentController::class, 'index'])->name('contents.index');
        Route::get('/content/{section}/create', [AdminContentController::class, 'create'])->name('contents.create');
        Route::post('/content/{section}', [AdminContentController::class, 'store'])->name('contents.store');
        Route::get('/content/{section}/{content}/edit', [AdminContentController::class, 'edit'])->name('contents.edit');
        Route::put('/content/{section}/{content}', [AdminContentController::class, 'update'])->name('contents.update');
        Route::delete('/content/{section}/{content}', [AdminContentController::class, 'destroy'])->name('contents.destroy');

        Route::get('/redirects', [AdminRedirectController::class, 'index'])->name('redirects.index');
        Route::get('/redirects/create', [AdminRedirectController::class, 'create'])->name('redirects.create');
        Route::post('/redirects', [AdminRedirectController::class, 'store'])->name('redirects.store');
        Route::get('/redirects/{redirect}/edit', [AdminRedirectController::class, 'edit'])->name('redirects.edit');
        Route::put('/redirects/{redirect}', [AdminRedirectController::class, 'update'])->name('redirects.update');
        Route::delete('/redirects/{redirect}', [AdminRedirectController::class, 'destroy'])->name('redirects.destroy');
    });
});

Route::get('/{legacyPath}', LegacyRouteController::class)
    ->where('legacyPath', '.*');
