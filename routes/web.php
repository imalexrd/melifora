<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\HiveController;
use App\Http\Controllers\ApiaryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\HiveNoteController;
use App\Http\Controllers\QueenController;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\ScanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\HiveSuperController;

Route::post('/hives/print-qrs', [HiveController::class, 'printQrs'])->name('hives.printQrs')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/hives/download-svgs', [HiveController::class, 'downloadSvgs'])->name('hives.downloadSvgs')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/hives/{hive}/qr', [HiveController::class, 'generateQrCode'])->name('hives.qr')->middleware(['auth', 'role:admin,superadmin']);
Route::resource('hives', HiveController::class)->middleware(['auth', 'role:admin,superadmin']);
Route::post('/hives/bulk-actions', [HiveController::class, 'bulkActions'])->name('hives.bulkActions')->middleware(['auth', 'role:admin,superadmin']);
Route::resource('apiaries', ApiaryController::class)->middleware(['auth', 'role:admin,superadmin']);
Route::get('/apiaries/{apiary}/qr', [ApiaryController::class, 'generateQrCode'])->name('apiaries.qr')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/apiaries/{apiary}/download-qr', [ApiaryController::class, 'downloadQr'])->name('apiaries.downloadQr')->middleware(['auth', 'role:admin,superadmin']);
Route::resource('hive_supers', HiveSuperController::class)->middleware(['auth', 'role:admin,superadmin'])->only(['index', 'store']);
Route::post('/hive_supers/bulk-actions', [HiveSuperController::class, 'bulkActions'])->name('hive_supers.bulkActions')->middleware(['auth', 'role:admin,superadmin']);

Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    // Apiary Notes
    Route::post('/apiaries/{apiary}/notes', [NoteController::class, 'storeApiaryNote'])->name('apiaries.notes.store');
    Route::patch('/apiaries/{apiary}/notes/{note}', [NoteController::class, 'updateApiaryNote'])->name('apiaries.notes.update');
    Route::delete('/apiaries/{apiary}/notes/{note}', [NoteController::class, 'destroyApiaryNote'])->name('apiaries.notes.destroy');

    // Hive Notes
    Route::post('/hives/{hive}/notes', [NoteController::class, 'storeHiveNote'])->name('hives.notes.store');
    Route::patch('/hives/{hive}/notes/{note}', [NoteController::class, 'updateHiveNote'])->name('hives.notes.update');
    Route::delete('/hives/{hive}/notes/{note}', [NoteController::class, 'destroyHiveNote'])->name('hives.notes.destroy');

    // Queen routes
    Route::post('/hives/{hive}/queen', [QueenController::class, 'store'])->name('hives.queen.store');
    Route::patch('/queen/{queen}', [QueenController::class, 'update'])->name('queen.update');
    Route::delete('/queen/{queen}', [QueenController::class, 'destroy'])->name('queen.destroy');
    Route::post('/queen/{queen}/replace', [QueenController::class, 'replace'])->name('queen.replace');

    // Inspection routes
    Route::post('/hives/{hive}/inspections', [App\Http\Controllers\InspectionController::class, 'store'])->name('hives.inspections.store');

    // Hive State routes
    Route::patch('/hives/{hive}/states', [HiveController::class, 'updateStates'])->name('hives.states.update');

    // Harvest routes
    Route::post('/hives/{hive}/harvests', [HarvestController::class, 'store'])->name('hives.harvests.store');

    // Hive Super routes
    Route::patch('/hives/{hive}/supers/assign', [HiveSuperController::class, 'assign'])->name('hive_supers.assign');
    Route::post('/hives/{hive}/supers/assign-random', [HiveSuperController::class, 'assignRandom'])->name('hive_supers.assignRandom');
    Route::patch('/hive_supers/{hive_super}/unassign', [HiveSuperController::class, 'unassign'])->name('hive_supers.unassign');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::get('/hives/find-by-slug/{slug}', [HiveController::class, 'findBySlug'])->name('hives.findBySlug');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

require __DIR__.'/auth.php';
