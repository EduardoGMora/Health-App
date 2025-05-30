<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Diario
    Route::resource('diary', DiaryController::class)->only([
        'index', 'create', 'store'
    ]);

    // Recursos
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

    // Comunidad
    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::post('/community', [CommunityController::class, 'store'])->name('community.store');

    // Ejercicios
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');

    // profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
