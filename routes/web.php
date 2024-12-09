<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


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
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:DPP,DPC,admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.home');
    Route::get('/search-user', [UserController::class, 'search'])->name('users.search');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

});
