<?php

use App\Http\Controllers\canviarContrasenyaController;
use App\Http\Controllers\forgotpasswordController;
use App\Http\Controllers\insertarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\passwordAfterMailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/insertar', function () {
    return view('insertar');
})->name('insertar');

Route::get('/logout', function () {
    // Destruir la sesión
    Session::flush(); // Elimina todos los datos de la sesión

    // Redirigir al usuario a la página de inicio de sesión
    return redirect('/login');
})->name('logout');

Route::get('/forgot-password', function () {
    return view('forgotpassword');
})->name('forgot-password-view');

Route::get('/passwordAfterMail', function () {
    return view('passwordAfterMail');
})->name('passwordAfterMail');

Route::get('/canviarContrasenya', function () {
    return view('canviarContrasenya');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::post('/login-controller', [LoginController::class, 'handleLogin'])->name('login-controller');
Route::post('/signup-controller', [SignupController::class, 'handleSignup'])->name('signup-controller');
Route::get('/signup-controller', [SignupController::class, 'handleSignup'])->name('signup-controller');
Route::post('/insertar-controller', [insertarController::class, 'insertar'])->name('insertar-controller');
Route::post('/forgotpassword-controller', [forgotpasswordController::class, 'forgotPassword'])->name('forgot-password-controller');
Route::post('/passwordAfterMail-controller', [passwordAfterMailController::class, 'passwordAfterMail'])->name('passwordAfterMail-controller');
Route::post('/canviarContrasenya-controller', [canviarContrasenyaController::class, 'canviarContrasenya'])->name('canviarContrasenya-controller');
Route::post('/profile-controller', [ProfileController::class, 'profile'])->name('profile_controller');
