<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventAttendanceController;

Route::middleware(['auth', 'role:DPP,DPC,DPD,admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.home');
});

Route::middleware(['auth', 'role:DPC,admin'])->group(function () {
    // Place static routes first
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/csv', [UserController::class, 'storeCSV'])->name('users.storeCSV');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/search-user', [UserController::class, 'search'])->name('users.search');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/uploadimage', [UserController::class, 'uploadimage'])->name('users.uploadimage');
});

Route::middleware(['auth', 'role:DPD, DPC, DPAC, DPP,admin'])->group(function () {
    // Event Routes
    Route::get('/events', [EventAttendanceController::class, 'getEvents'])->name('events.index');
    Route::get('/events/create', [EventAttendanceController::class, 'createEventForm'])->name('events.createEventForm');
    Route::get('/events/{id}', [EventAttendanceController::class, 'getEvent'])->name('events.attend');
    Route::post('/events', [EventAttendanceController::class, 'createEvent'])->name('events.create');
    Route::get('/events/{id}/edit', [EventAttendanceController::class, 'editEventForm'])->name('events.edit');
    Route::put('/events/{id}', [EventAttendanceController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{id}', [EventAttendanceController::class, 'deleteEvent'])->name('events.delete');

    // Attendance Routes
    Route::post('/attendance', [EventAttendanceController::class, 'recordAttendance'])->name('attendance.record');
    Route::get('/attendance/{event_id}', [EventAttendanceController::class, 'getAttendance'])->name('attendance.index');
    Route::delete('/attendance/{id}', [EventAttendanceController::class, 'deleteAttendance'])->name('attendance.delete');
    Route::get('/attendance/{event_id}/download', [EventAttendanceController::class, 'downloadAttendanceCSV'])->name('attendance.download');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/users/template', [UserController::class, 'downloadTemplate'])->name('users.template');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

