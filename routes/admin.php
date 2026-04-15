<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\EvacuationController;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\SupportController;


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // لوحة التحكم الرئيسية
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // إدارة المستخدمين
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('index');
        Route::get('/create', [AdminController::class, 'createUser'])->name('create');
        Route::post('/', [AdminController::class, 'storeUser'])->name('store');
        Route::get('/{user}', [AdminController::class, 'showUser'])->name('show');
        Route::get('/{user}/edit', [AdminController::class, 'editUser'])->name('edit');
        Route::put('/{user}', [AdminController::class, 'updateUser'])->name('update');
        Route::delete('/{user}', [AdminController::class, 'deleteUser'])->name('destroy');
        Route::patch('/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('toggle-status');
    });
    
    // إدارة الخدمات
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::patch('/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{service}/toggle-verification', [ServiceController::class, 'toggleVerification'])->name('toggle-verification');
    });
    
    Route::prefix('evacuation')->name('evacuation.')->group(function () {
        Route::get('/', [EvacuationController::class, 'index'])->name('index');
        Route::get('/create', [EvacuationController::class, 'create'])->name('create');
        Route::post('/', [EvacuationController::class, 'store'])->name('store');
        Route::get('/{evacuation}', [EvacuationController::class, 'show'])->name('show');
        Route::get('/{evacuation}/edit', [EvacuationController::class, 'edit'])->name('edit');
        Route::put('/{evacuation}', [EvacuationController::class, 'update'])->name('update');
        Route::delete('/{evacuation}', [EvacuationController::class, 'destroy'])->name('destroy');
        Route::patch('/{evacuation}/update-status', [EvacuationController::class, 'updateStatus'])->name('update-status');
        Route::post('/bulk-update', [EvacuationController::class, 'bulkUpdate'])->name('bulk-update');
        Route::post('/import', [EvacuationController::class, 'import'])->name('import');
        Route::get('/export', [EvacuationController::class, 'export'])->name('export');
    });


    // إدارة السوق
Route::prefix('market')->name('market.')->group(function () {
    Route::get('/', [MarketController::class, 'index'])->name('index');
    Route::get('/create', [MarketController::class, 'create'])->name('create');
    Route::post('/', [MarketController::class, 'store'])->name('store');
    Route::get('/{market}', [MarketController::class, 'show'])->name('show');
    Route::get('/{market}/edit', [MarketController::class, 'edit'])->name('edit');
    Route::put('/{market}', [MarketController::class, 'update'])->name('update');
    Route::delete('/{market}', [MarketController::class, 'destroy'])->name('destroy');
    Route::patch('/{market}/toggle-status', [MarketController::class, 'toggleStatus'])->name('toggle-status');
    Route::patch('/{market}/toggle-urgent', [MarketController::class, 'toggleUrgent'])->name('toggle-urgent');
    Route::post('/bulk-update', [MarketController::class, 'bulkUpdate'])->name('bulk-update');
    Route::get('/statistics', [MarketController::class, 'statistics'])->name('statistics');
    Route::patch('/{market}/approve', [MarketController::class, 'approve'])->name('approve');
    Route::patch('/{market}/reject', [MarketController::class, 'reject'])->name('reject');
    Route::patch('/{market}/suspend', [MarketController::class, 'suspend'])->name('suspend');
        

});


// إدارة الدعم النفسي
Route::prefix('support')->name('support.')->group(function () {
    Route::get('/', [SupportController::class, 'index'])->name('index');
    Route::get('/create', [SupportController::class, 'create'])->name('create');
    Route::post('/', [SupportController::class, 'store'])->name('store');
    Route::get('/{support}', [SupportController::class, 'show'])->name('show');
    Route::get('/{support}/edit', [SupportController::class, 'edit'])->name('edit');
    Route::put('/{support}', [SupportController::class, 'update'])->name('update');
    Route::delete('/{support}', [SupportController::class, 'destroy'])->name('destroy');
    Route::patch('/{support}/toggle-status', [SupportController::class, 'toggleStatus'])->name('toggle-status');
    Route::patch('/{support}/toggle-verification', [SupportController::class, 'toggleVerification'])->name('toggle-verification');
    Route::patch('/{support}/reset-views', [SupportController::class, 'resetViews'])->name('reset-views');
});



// إدارة قصص الصمود
Route::prefix('stories')->name('stories.')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('index');
    Route::get('/create', [StoryController::class, 'create'])->name('create');
    Route::post('/', [StoryController::class, 'store'])->name('store');
    Route::get('/{story}', [StoryController::class, 'show'])->name('show');
    Route::get('/{story}/edit', [StoryController::class, 'edit'])->name('edit');
    Route::put('/{story}', [StoryController::class, 'update'])->name('update');
    Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
    Route::patch('/{story}/toggle-publish', [StoryController::class, 'togglePublish'])->name('toggle-publish');
    Route::patch('/{story}/toggle-featured', [StoryController::class, 'toggleFeatured'])->name('toggle-featured');
});

    // الإحصائيات
    Route::get('/stats', [AdminController::class, 'systemStats'])->name('stats');
    
    // الإعدادات
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});