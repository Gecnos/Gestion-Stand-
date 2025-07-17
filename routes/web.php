<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandeStandController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsEntrepreneur;


Route::get('/', function () {
    return view('welcome'); 
})->name('welcome');

Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'approuve' => redirect()->route('entrepreneur.dashboard'),
        default => redirect()->route('attente'),
    };
})->name('dashboard');

Route::middleware('auth')->get('/redirect-by-role', fn () => redirect()->route('dashboard'));

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
});

Route::get('/demande-stand', function () {
    return view('demande-stand'); 
})->name('demande.stand');

Route::post('/demande-stand', [DemandeStandController::class, 'submit'])->name('demande.stand.submit');


Route::middleware(['auth', 'entrepreneur'])->get('/entrepreneur/dashboard', fn () => view('entrepreneur.dashboard'))->name('entrepreneur.dashboard');
Route::middleware(['auth'])->get('/attente-validation', fn () => view('attente'))->name('attente');

require __DIR__ . '/auth.php';
