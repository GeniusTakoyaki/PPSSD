<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\PesticideController;
use App\Http\Controllers\MRLController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;

Route::get('/about', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', function () {
    return Inertia::render('Mainpage');
});


Route::get('/commodities', [CommodityController::class, 'index'])
    ->name('commodities.index');

Route::get('/pesticides', [PesticideController::class, 'index'])
    ->name('pesticides.index');


Route::get('/search', [MRLController::class, 'index'])->name('mrl.index');

require __DIR__.'/auth.php';
