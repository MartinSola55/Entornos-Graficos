<?php
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes();

// ADMIN
Route::middleware(['auth', 'admin'])->group(function () {

    // HOME
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// STUDENT
Route::middleware(['auth'])->group(function () {

    // HOME
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // SOLICITUDES
    Route::get('/application/index', [App\Http\Controllers\ApplicationController::class, 'index']);
    Route::post('/application/create', [App\Http\Controllers\ApplicationController::class, 'create']);
});

