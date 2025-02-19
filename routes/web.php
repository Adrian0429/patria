<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataAnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventAttendanceController;
use App\Http\Controllers\AksesController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/show/anggota/{id}', [DataAnggotaController::class, 'show'])->name('anggota.show');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('template', [DataAnggotaController::class, 'template'])->name('template');

Route::middleware(['auth', 'role:admin'])->group(function () {
    //akun patria
    Route::get('/users', [UserController::class, 'index'])->name('users.home');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/edit/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    //data DPD
    Route::get('/dpd', [UserController::class, 'index_dpd'])->name('users.index_dpd');
    Route::post('/dpd/store', [UserController::class, 'store_dpd'])->name('users.store_dpd');
    Route::put('/dpd/update/{id}', [UserController::class, 'update_dpd'])->name('users.update_dpd');
    Route::delete('/dpd/destroy/{id}', [UserController::class, 'destroy_dpd'])->name('users.destroy_dpd');

    //data DPC - DPAC
    Route::get('/dpc', [UserController::class, 'index_dpc'])->name('users.index_dpc');
    Route::post('/dpc/store', [UserController::class, 'store_dpc'])->name('users.store_dpc');
    Route::put('/dpc/update/{id}', [UserController::class, 'update_dpc'])->name('users.update_dpc');
    Route::delete('/dpc/destroy/{id}', [UserController::class, 'destroy_dpc'])->name('users.destroy_dpc');

    Route::get('/akses', [AksesController::class, 'index'])->name('akses.home');

    Route::post('/uploadImage', [DataAnggotaController::class, 'uploadImage'])->name('anggota.uploadImage');
    Route::delete('/anggota/{id}', [DataAnggotaController::class, 'destroy'])->name('anggota.destroy');
});

Route::middleware(['auth'])->group(function () {
    //data Anggota
    Route::get('/anggota', [DataAnggotaController::class, 'index'])->name('anggota.home');
    Route::get('/anggota/{id}', [DataAnggotaController::class, 'detail'])->name('anggota.detail');
    Route::get('/create/anggota', [DataAnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/store/anggota', [DataAnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/edit/anggota/{id}', [DataAnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/update/anggota/{id}', [DataAnggotaController::class, 'update'])->name('anggota.update');
    Route::get('/download-csv', [DataAnggotaController::class, 'exportCSV'])->name('download.csv');
    Route::post('/importCSV', [DataAnggotaController::class, 'importCSV'])->name('anggota.importCSV');

    Route::get('/dataDPD', [DataAnggotaController::class, 'exportDPDCSV'])->name('download.dpd');
    Route::get('/dataDPC', [DataAnggotaController::class, 'exportDPCCSV'])->name('download.dpc');

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