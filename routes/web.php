<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\BlockchainController;
use App\Http\Controllers\frontend\VoteController;
use App\Http\Controllers\Auth\LoginController;


// Authentication Routes
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/api/auth/nonce', [LoginController::class, 'getNonce']);
Route::post('/wallet/login', [LoginController::class, 'authenticate'])->name('wallet.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Voting Routes
    Route::get('/', [VoteController::class, 'index'])->name('votes.index');
    Route::post('/votes', [VoteController::class, 'store'])->name('votes.store');
    Route::get('/results', [VoteController::class, 'results'])->name('votes.results');
    
    // Blockchain Explorer
    Route::get('/blockchain', [BlockchainController::class, 'index'])->name('blockchain.index');
});

// Home Route (redirect based on auth status)
Route::get('/home', function () {
    return auth()->check() ? redirect()->route('votes.index') : redirect()->route('login');
});