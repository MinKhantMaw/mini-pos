<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('categories', CategoryController::class);
    Route::get('/invoices/{sale}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{sale}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
});
require __DIR__.'/auth.php';
