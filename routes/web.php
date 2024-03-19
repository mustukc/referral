<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', [UserController::class,'loadRegister']);
Route::post('/user-registered', [UserController::class,'registered'])->name('registered');

Route::get('/login',[UserController::class,'loadLogin']);
Route::post('/login',[UserController::class,'userLogin'])->name('login');

Route::get('/dashboard',[UserController::class,'loadDashboard']);
