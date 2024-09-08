<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommitController;


Route::get('/', [CommitController::class, 'home']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Route::middleware('auth')->group(function () {
//     Route::get('/commits', [CommitController::class, 'index'])->name('commits.index');
//     Route::get('/add-commit', [CommitController::class, 'create'])->name('commits.create');
//     Route::post('/add-commit', [CommitController::class, 'store'])->name('commits.store');
//     Route::get('/add-commit/{id?}', [CommitController::class, 'editCommit'])->name('commits.editCommit');
// });


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/');
    })->name('dashboard');
    Route::get('/commits', [CommitController::class, 'index'])->name('commits.index');
    Route::get('/add-commit', [CommitController::class, 'create'])->name('commits.create');
    Route::post('/add-commit', [CommitController::class, 'store'])->name('commits.store');
    Route::get('/add-commit/{id?}', [CommitController::class, 'editCommit'])->name('commits.editCommit');
});
