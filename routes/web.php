<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/users/create', function () {
    return view('users.create');
})->name('home');

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

//admin
Route::get('/users', [UserController::class, 'index'])->name('users.home');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/search-user', [UserController::class, 'search'])->name('users.search');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

