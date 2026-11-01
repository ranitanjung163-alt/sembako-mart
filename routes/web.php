<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OrderController; // Controller Pesanan User
use App\Http\Controllers\PurchaseController; // Controller Barang Masuk
use App\Http\Controllers\CartController; // <-- TAMBAHAN: Controller Keranjang Belanja User
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Dashboard yang sudah dihubungkan ke DashboardController agar data produk sinkron
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Rute yang memerlukan login (Auth)
Route::middleware('auth')->group(function () {
    
    // ==========================================
    // 1. HANYA ADMIN: Kelola Master Data Kategori & Barang Masuk (Restock)
    // ==========================================
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        
        // Rute Transaksi & Tabel Riwayat Barang Masuk khusus Admin
        Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    });

    // ==========================================
    // 2. ADMIN & STAFF: Manajemen Produk, Supplier & Penjualan (Sales)
    // ==========================================
    Route::middleware(['role:admin,staff'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        
        // Rute Penjualan / Kasir (Sales) dengan pengaman atomik
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    });

    // ==========================================
    // 3. SEMUA USER (Admin, Staff, User): Sistem Pemesanan & Keranjang Belanja
    // ==========================================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // <-- TAMBAHAN: Rute Keranjang Belanja (Cart) & Checkout User -->
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    
    // Kita sediakan nama rute ganda (cart.checkout & cart.checkout.process) agar cocok dengan tombol di view manapun
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/process-checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
    Route::get('/cart/checkout-form', [CartController::class, 'checkoutForm'])->name('cart.checkout.form');
    
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Profil Bawaan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';