<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

// Route Login & Logout
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        $categories = Category::with(['cars.sales'])->get();
        return view('dashboard', compact('categories'));
    })->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('cars', CarController::class);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store']);

    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{car_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/checkout', [CartController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [CartController::class, 'checkoutSubmit'])->name('checkout.submit');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{invoice}/print', [TransaksiController::class, 'print'])->name('transaksi.print');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');

    
    Route::resource('users', App\Http\Controllers\UserController::class)->except(['show', 'destroy']);
    Route::resource('roles', App\Http\Controllers\RoleController::class)->only(['index', 'edit', 'update']);

});
