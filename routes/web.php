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
use App\Models\Produits;
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


// Route::post('/panier/ajouter', [StandManageController::class, 'ajouter'])->name('panier.ajouter');
// Route::get('/panier', [StandManageController::class, 'voir'])->name('panier.voir');
// Route::delete('/panier/{id}', [StandManageController::class, 'supprimer'])->name('panier.supprimer');

// Route::post('/commande', [StandManageController::class, 'passerCommande'])->middleware('auth')->name('commande.valider');



// Route::middleware(['auth', 'approuve'])->group(function () {
//     Route::resource('produits', Produits::class);
// });

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

Route::get('/demande-stand', function () {return view('demande-stand'); })->name('demande.stand');

Route::get('/stands/index',function (){return view('stands.index');})->name('stands.index');
Route::get('/exposants', [StandController::class, 'index'])->name('stands.index');
Route::get('/stand/{id}', [StandController::class, 'show'])->name('stands.show');
Route::post('/cart/add', [StandController::class, 'addToCart'])->name('cart.add');
Route::post('/order/store', [StandController::class, 'storeOrder'])->name('order.store');
Route::post('/cart/clear/{stand_id}', [StandController::class, 'clearCart'])->name('cart.clear');
Route::post('/demande-stand', [DemandeStandController::class, 'submit'])->name('demande.stand.submit');

Route::post('/stand/create', [StandController::class, 'createStand'])->middleware('auth')->name('entrepreneur.create');
Route::get('/entrepreneur/create',function (){return view('entrepreneur.create');})->name('entrepreneur.create');
Route::get('/stands/create', [StandController::class, 'create'])->name('stands.create');
Route::post('/stands', [StandController::class, 'createStand'])->name('stands.store');

Route::get ('/entrepreneur/dashboard', function(){return view('entrepreneur.dashboard');})->name('entrepreneur.dashboard');
Route::get('/entrepreneur/panier',function (){return view('entrepreneur.panier'); })->name('entrepreneur.panier');
require __DIR__ . '/auth.php';
