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

    // STUDENT
    Route::get('/student/index', [App\Http\Controllers\StudentController::class, 'index']);
    Route::post('/student/create', [App\Http\Controllers\StudentController::class, 'create']);
    Route::post('/student/edit', [App\Http\Controllers\StudentController::class, 'update']);
    Route::post('/student/delete', [App\Http\Controllers\StudentController::class, 'delete']);

    // TEACHER
    Route::get('/teacher/index', [App\Http\Controllers\TeacherController::class, 'index']);
    Route::post('/teacher/create', [App\Http\Controllers\TeacherController::class, 'create']);
    Route::post('/teacher/edit', [App\Http\Controllers\TeacherController::class, 'update']);
    Route::post('/teacher/delete', [App\Http\Controllers\TeacherController::class, 'delete']);

    // RESPONSIBLE
    Route::get('/responsible/index', [App\Http\Controllers\ResponsibleController::class, 'index']);
    Route::post('/responsible/create', [App\Http\Controllers\ResponsibleController::class, 'create']);
    Route::post('/responsible/edit', [App\Http\Controllers\ResponsibleController::class, 'update']);
    Route::post('/responsible/delete', [App\Http\Controllers\ResponsibleController::class, 'delete']);
});

//
Route::middleware(['auth'])->group(function () {

    // HOME
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // SOLICITUDES
    Route::get('/application/index', [App\Http\Controllers\ApplicationController::class, 'index']);
    Route::post('/application/create', [App\Http\Controllers\ApplicationController::class, 'create']);
});

