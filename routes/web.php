<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\BlockchainController;
use App\Http\Controllers\frontend\VoteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;

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

//Admin Route
Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Candidate Routes
    Route::post('/candidates/store', [AdminController::class, 'storeCandidate'])->name('admin.candidates.store');
    Route::put('/candidates/{candidate}/update', [AdminController::class, 'updateCandidate'])->name('admin.candidates.update');
    Route::delete('/candidates/{candidate}/delete', [AdminController::class, 'deleteCandidate'])->name('admin.candidates.delete');
});
// Home Route (redirect based on auth status)
Route::get('/home', function () {
    return auth()->check() ? redirect()->route('votes.index') : redirect()->route('login');
});