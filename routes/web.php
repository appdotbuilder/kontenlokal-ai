<?php

use App\Http\Controllers\ContentCalendarController;
use App\Http\Controllers\ContentGeneratorController;
use App\Http\Controllers\ContentHistoryController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page - main functionality
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public pages
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/calendar', [ContentCalendarController::class, 'index'])->name('calendar.index');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - main functionality
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Content generation routes
    Route::controller(ContentGeneratorController::class)->group(function () {
        Route::get('/content', 'index')->name('content.index');
        Route::post('/content', 'store')->name('content.store');
        Route::get('/content/{content}', 'show')->name('content.show');

    });
    
    // Content history
    Route::controller(ContentHistoryController::class)->group(function () {
        Route::get('/content/history', 'index')->name('content.history');
        Route::delete('/content/{content}', 'destroy')->name('content.destroy');
    });
    
    // Profile management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('/profile/brand-voice', 'updateBrandVoice')->name('profile.brand-voice.update');
    });
    

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
