<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProductController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Route login yang tadinya di api.php, pindah ke sini
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });


    Route::get('/transaction', [TransactionController::class, 'index']);

    Route::get('/api/search-products', [ProductController::class, 'search']);
    
    Route::get('/api/product/{identifier}', [TransactionController::class, 'getProduct']);
    Route::get('/api/member/{identifier}', [MemberController::class, 'getMember']);

});