<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EvacuationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SupportController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('index');
})->name('home');

// مسارات المصادقة
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/sos', [\App\Http\Controllers\FrontendController::class, 'sos'])->name('frontend.sos');
Route::post('/sos', [\App\Http\Controllers\FrontendController::class, 'submitSos'])->middleware('throttle:3,1')->name('frontend.sos.submit');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


// مسارات الخدمات)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');


// مسارات خريطة الإخلاء)
Route::get('/evacuation', [EvacuationController::class, 'index'])->name('evacuation.index');
Route::post('/evacuation/search', [EvacuationController::class, 'search'])->name('evacuation.search');
Route::get('/evacuation/{id}', [EvacuationController::class, 'show'])->name('evacuation.show');
Route::post('/evacuation/{id}/update-status', [EvacuationController::class, 'updateStatus'])->name('evacuation.update-status');
Route::get('/evacuation-data', [EvacuationController::class, 'getMapData'])->name('evacuation.data');



// مسارات السوق (الواجهة الأمامية)
Route::get('/market', [MarketController::class, 'index'])->name('market.index');
Route::post('/market', [MarketController::class, 'store'])->name('market.store');
Route::get('/market/{id}', [MarketController::class, 'show'])->name('market.show');
Route::get('/market/search', [MarketController::class, 'search'])->name('market.search');
Route::get('/market-data', [MarketController::class, 'getMarketData'])->name('market.data');




// مسارات قصص الصمود (الواجهة الأمامية)
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/search', [StoryController::class, 'search'])->name('stories.search');
Route::get('/stories/{slug}', [StoryController::class, 'show'])->name('stories.show');
Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');




// مسارات الدعم النفسي
Route::get('/support', [SupportController::class, 'index'])->name('support.index');
Route::get('/support/exercises', [SupportController::class, 'exercises'])->name('support.exercises');
Route::get('/support/search', [SupportController::class, 'search'])->name('support.search');
Route::get('/support/{id}', [SupportController::class, 'show'])->name('support.show');



Route::middleware(['auth', 'verified'])->group(function () {
  // Distress Calls
    Route::resource('admin/distress-calls', \App\Http\Controllers\Admin\DistressCallController::class)->except(['show', 'create', 'edit']);

});




require __DIR__.'/admin.php';
