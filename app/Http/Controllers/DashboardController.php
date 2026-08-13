<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlySales = Sale::whereBetween('sale_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount');
        $monthlyPurchases = Purchase::whereBetween('purchase_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount');
        $monthlyProfit = $monthlySales - $monthlyPurchases;

        return view('dashboard.index', [
            'monthlySales' => $monthlySales,
            'monthlyPurchases' => $monthlyPurchases,
            'monthlyProfit' => $monthlyProfit,
            'unpaidInvoices' => Sale::whereIn('payment_status', ['unpaid', 'partial'])->count(),
            'lowStockProducts' => Product::where('stock_quantity', '<', 5)->get(),
        ]);
    }
}
