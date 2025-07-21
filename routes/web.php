<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandeStandController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsEntrepreneur;
use App\Http\Controllers\Produit;
use App\Http\Controllers\StandController;
use App\Http\Controllers\StandManageController;
use App\Models\Stand;

Route::get('/', function () {
    return view('welcome'); 
})->name('welcome');

Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'approuve') {
        return redirect()->route('entrepreneur.dashboard');
    } else {
        return redirect()->route('attente');
    }
})->name('dashboard');

Route::get('/', [StandController::class, 'index'])->name('vitrine');
Route::get('/stand/{id}', [StandController::class, 'show'])->name('stand.detail');

Route::post('/panier/ajouter', [StandManageController::class, 'ajouter'])->name('panier.ajouter');
Route::get('/panier', [StandManageController::class, 'voir'])->name('panier.voir');
Route::delete('/panier/{id}', [StandManageController::class, 'supprimer'])->name('panier.supprimer');

Route::post('/commande', [StandManageController::class, 'passerCommande'])->middleware('auth')->name('commande.valider');



Route::middleware(['auth', 'approuve'])->group(function () {
    Route::resource('produits', Produit::class);
});

Route::middleware('auth')->get('/redirect-by-role', fn () => redirect()->route('dashboard'));

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::post('/admin/desuspendre/{id}', [AdminController::class, 'desuspendre'])->name('admin.desuspendre');
    Route::post('/admin/suspendre/{id}', [AdminController::class, 'suspendre'])->name('admin.suspendre');
    Route::post('/admin/faire-appel/{id}', [AdminController::class, 'faireAppel'])->name('admin.faire_appel');
    Route::get('/admin/afficherEntepreneurs',[AdminController::class, 'afficherEntrepreneurs'])->name('admin.afficher');
});

Route::get('/demande-stand', function () {
    return view('demande-stand'); 
})->name('demande.stand');

Route::post('/demande-stand', [DemandeStandController::class, 'submit'])->name('demande.stand.submit');


Route::middleware(['auth', 'approuve'])->get('/entrepreneur/dashboard', fn () => view('entrepreneur.dashboard'))->name('entrepreneur.dashboard');
Route::middleware(['auth'])->get('/attente-validation', fn () => view('attente'))->name('attente');

require __DIR__ . '/auth.php';
