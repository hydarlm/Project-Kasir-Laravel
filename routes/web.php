<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::resource('products', ProductController::class);
    // Category Routes
    Route::resource('categories', CategoryController::class);
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::resource('categories', CategoryController::class)->except(['show']);
    // Transaction Routes
    // routes/web.php
Route::get('/transactions/get', [TransactionController::class, 'getTransactions'])->name('transactions.get');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::resource('transactions', TransactionController::class);
Route::get('transactions/statistics', [TransactionController::class, 'getStatistics'])
    ->name('transactions.statistics');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
    ->name('transactions.show');
    Route::resource('transactions', \App\Http\Controllers\TransactionController::class);
Route::get('transactions/get', [\App\Http\Controllers\TransactionController::class, 'getTransactions'])->name('transactions.get');
Route::post('transactions/bulk-delete', [\App\Http\Controllers\TransactionController::class, 'bulkDelete'])->name('transactions.bulk-delete');
    // Home Redirect
    Route::get('/', function () {
        return redirect()->route('products.index');
    });
});
