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
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\StandManageController;
use App\Models\Produits;
use App\Models\Stand;
use App\Http\Middleware\CheckStand;

Route::get('/', function () {
    return view('welcome'); 
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
});

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
Route::get('/stands/create', [StandController::class, 'create'])->name('entrepreneur.create');
Route::post('/stands', [StandController::class, 'createStand'])->name('stands.store');

Route::middleware(['auth', 'entrepreneur', 'check.stand'])->group(function () {
    Route::get('/entrepreneur/dashboard', [StandController::class, 'dashboard'])->name('entrepreneur.dashboard');
        Route::post('/products', [StandController::class, 'storeProduct'])->name('entrepreneur.products.store');
    Route::get('/entrepreneur/orders', [StandController::class, 'orders'])->name('entrepreneur.orders');
    Route::get('/entrepreneur/products', [StandController::class, 'productsIndex'])->name('entrepreneur.products.index');
    Route::get('/entrepreneur/products/{id}/edit', [StandController::class, 'editProduct'])->name('entrepreneur.products.edit');
    Route::put('/entrepreneur/products/{id}', [StandController::class, 'updateProduct'])->name('entrepreneur.products.update');
    Route::delete('/entrepreneur/products/{id}', [StandController::class, 'destroyProduct'])->name('entrepreneur.products.destroy');
    Route::get('/entrepreneur/panier', function () {
        return view('entrepreneur.panier');
    })->name('entrepreneur.panier');
});
Route::get('/products/create', [StandController::class, 'createProduct'])->name('products.create');
Route::get('/orders', [StandController::class, 'orders'])->name('orders.index');
Route::get('/attente', function () {
    return view('attente');
})->name('attente');
require __DIR__ . '/auth.php';
