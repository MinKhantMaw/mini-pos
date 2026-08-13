<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Services\RecordSaleService;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index', ['sales' => Sale::latest('sale_date')->paginate(15)]);
    }

    public function create()
    {
        return view('sales.create', ['products' => Product::where('status', 'active')->orderBy('name')->get()]);
    }

    public function store(StoreSaleRequest $request, RecordSaleService $service)
    {
        try {
            $sale = $service->create($request->validated());
        } catch (InsufficientStockException|\InvalidArgumentException $exception) {
            return back()->withInput()->withErrors(['items' => $exception->getMessage()]);
        }

        return to_route('sales.show', $sale)->with('success', 'Sale recorded.');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product');

        return view('sales.show', compact('sale'));
    }
}
