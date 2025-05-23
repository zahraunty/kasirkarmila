<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderTempController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/transaction', [CartController::class, 'store'])->name('transaction.store');
Route::get('/transaction', [CartController::class, 'index'])->name('cart.index');
Route::get('/transaction/{transaction}', [CartController::class, 'show'])->name('cart.transaction.show');

Route::middleware('auth')->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
});

Route::get('/pemesanan', [OrderTempController::class, 'index']);
Route::get('/pemesanan/create', [OrderTempController::class, 'create']);
Route::post('/pemesanan/store', [OrderTempController::class, 'store']);
Route::post('/pemesanan/checkout', [OrderController::class, 'checkout']);
Route::post('/pemesanan/checkout/save', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/print', [OrderController::class, 'print'])->name('orders.print');
Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/orders/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions', [TransactionController::class, 'index'])->name('Transactions.index');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/orders/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
Route::post('/orders/print', [OrderController::class, 'printOrder'])->name('orders.print');
Route::get('/riwayat', [OrderController::class, 'riwayat']);
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/print/{id}', [OrderController::class, 'cetakPDF'])->name('orders.cetak');
Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/transactions/store', [TransactionController::class, 'storeMultiple'])->name('transactions.storeMultiple');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/orders/receipt', [TransactionController::class, 'showReceipt'])->name('orders.receipt');
