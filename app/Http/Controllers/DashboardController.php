<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', ['monthlySales' => Sale::whereBetween('sale_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount'), 'monthlyPurchases' => Purchase::whereBetween('purchase_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount'), 'unpaidInvoices' => Sale::whereIn('payment_status', ['unpaid', 'partial'])->count(), 'lowStockProducts' => Product::where('stock_quantity', '<', 5)->get()]);
    }
}
