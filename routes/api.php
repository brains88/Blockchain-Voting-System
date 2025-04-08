<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


Route::post('/auth/nonce', [LoginController::class, 'getNonce']);