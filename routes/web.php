<?php

use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

Route::get('/', function () {
    return view('frontend.home.index');
});


Route::group([ 'middleware'=>['auth', 'verified']], function(){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});


require __DIR__.'/auth.php';