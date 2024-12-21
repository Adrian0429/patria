<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventAttendanceController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/users/create', function () {
    return view('users.create');
})->name('home');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:DPP,DPC,admin,Anggota'])->group(function () {
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

});

Route::middleware(['auth', 'role:DPP,DPC,admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.home');
    Route::get('/search-user', [UserController::class, 'search'])->name('users.search');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});


// Event Routes
Route::get('/events', [EventAttendanceController::class, 'getEvents'])->name('events.index');
Route::get('/events/create', [EventAttendanceController::class, 'createEventForm'])->name('events.createEventForm');
Route::get('/events/{id}', [EventAttendanceController::class, 'getEvent'])->name('events.attend');
Route::post('/events', [EventAttendanceController::class, 'createEvent'])->name('events.create');
Route::get('/events/{id}/edit', [EventAttendanceController::class, 'editEventForm'])->name('events.edit');
Route::put('/events/{id}', [EventAttendanceController::class, 'updateEvent'])->name('events.update');
Route::delete('/events/{id}', [EventAttendanceController::class, 'deleteEvent'])->name('events.delete');

Route::post('/attendance', [EventAttendanceController::class, 'recordAttendance'])->name('attendance.record');
Route::get('/attendance/{event_id}', [EventAttendanceController::class, 'getAttendance'])->name('attendance.index');
Route::delete('/attendance/{id}', [EventAttendanceController::class, 'deleteAttendance'])->name('attendance.delete');

// Download Attendance
Route::get('/attendance/download/{event_id}', [EventAttendanceController::class, 'downloadAttendance'])->name('attendance.download');