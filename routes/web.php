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
    Route::get('/application/new', [App\Http\Controllers\ApplicationController::class, 'new'])->name('application.new');
    Route::get('/application/details/{id}', [App\Http\Controllers\ApplicationController::class, 'details']);
    Route::get('/application/downloadWorkPlan/{id}', [App\Http\Controllers\ApplicationController::class, 'downloadWorkPlan']);

    Route::get('/application/downloadWeeklyTracking/{id}', [App\Http\Controllers\WeeklyTrackingController::class, 'download']);
    Route::post('/application/uploadWeeklyTracking', [App\Http\Controllers\WeeklyTrackingController::class, 'upload']);
    Route::post('/application/deleteWeeklyTracking', [App\Http\Controllers\WeeklyTrackingController::class, 'delete']);
    Route::post('/application/acceptWeeklyTracking', [App\Http\Controllers\WeeklyTrackingController::class, 'accept']);

    Route::get('/application/downloadFinalReport/{id}', [App\Http\Controllers\FinalReportController::class, 'download']);
    Route::post('/application/uploadFinalReport', [App\Http\Controllers\FinalReportController::class, 'upload']);

    Route::post('/application/create', [App\Http\Controllers\ApplicationController::class, 'create']);
    Route::post('/application/editObservation', [App\Http\Controllers\TeacherController::class, 'editObservation']);
    Route::post('/application/takeApplication/{id}', [App\Http\Controllers\ResponsibleController::class, 'takeApplication']);
    Route::post('/application/assignTeacher', [App\Http\Controllers\ResponsibleController::class, 'assignTeacher']);
});