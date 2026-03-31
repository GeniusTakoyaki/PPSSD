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


Route::resource('commodities', CommodityController::class);

Route::resource('pesticides', PesticideController::class);

Route::get('/search', [MRLController::class, 'index'])->name('mrl.index');

Route::get('/mrl/commodity/{id}', [MrlController::class, 'byCommodity']);
Route::get('/mrl/pesticide/{id}', [MrlController::class, 'byPesticide']);

require __DIR__.'/auth.php';
