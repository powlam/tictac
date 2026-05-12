<?php

use App\Http\Controllers\RoutineController;
use App\Http\Controllers\TimerController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home'); // TODO

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('routines', RoutineController::class)->except(['index']);
    Route::resource('routines.timers', TimerController::class)->except(['index', 'show']);
});

require __DIR__.'/settings.php';
