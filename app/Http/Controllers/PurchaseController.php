<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Services\RecordPurchaseService;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchases.index', ['purchases' => Purchase::latest('purchase_date')->paginate(15)]);
    }

    public function create()
    {
        return view('purchases.create', ['products' => Product::with('category')->where('status', 'active')->orderBy('name')->get()]);
    }

    public function store(StorePurchaseRequest $request, RecordPurchaseService $service)
    {
        $purchase = $service->create($request->validated());

        return to_route('purchases.show', $purchase)->with('success', 'Purchase recorded.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('items.product');

        return view('purchases.show', compact('purchase'));
    }
}
