<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/login-controller', [LoginController::class, 'handleLogin'])->name('login-controller');
Route::post('/signup-controller', [SignupController::class, 'handleSignup'])->name('signup-controller');
Route::get('/signup-controller', [SignupController::class, 'handleSignup'])->name('signup-controller');
