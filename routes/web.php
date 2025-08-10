<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\HiveController;
use App\Http\Controllers\ApiaryController;
use App\Http\Controllers\HiveNoteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('hives', HiveController::class)->middleware(['auth', 'role:admin,superadmin']);
Route::post('/hives/bulk-actions', [HiveController::class, 'bulkActions'])->name('hives.bulkActions')->middleware(['auth', 'role:admin,superadmin']);
Route::resource('apiaries', ApiaryController::class)->middleware(['auth', 'role:admin,superadmin']);

Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::post('/apiaries/{apiary}/notes', [ApiaryController::class, 'storeNote'])->name('apiaries.notes.store');
    Route::patch('/apiaries/{apiary}/notes/{note}', [ApiaryController::class, 'updateNote'])->name('apiaries.notes.update');
    Route::delete('/apiaries/{apiary}/notes/{note}', [ApiaryController::class, 'destroyNote'])->name('apiaries.notes.destroy');

    Route::post('/hives/{hive}/notes', [HiveNoteController::class, 'store'])->name('hives.notes.store');
    Route::patch('/hives/{hive}/notes/{note}', [HiveNoteController::class, 'update'])->name('hives.notes.update');
    Route::delete('/hives/{hive}/notes/{note}', [HiveNoteController::class, 'destroy'])->name('hives.notes.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

require __DIR__.'/auth.php';
