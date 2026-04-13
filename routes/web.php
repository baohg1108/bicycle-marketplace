<?php

use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('frontend.home.index');
});


Route::group([ 'middleware'=>['auth', 'verified']], function(){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

// profile route
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

require __DIR__.'/auth.php';