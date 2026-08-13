<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class RecordPurchaseService
{
    public function create(array $data): Purchase
    {
        return DB::transaction(function () use ($data) {
            $total = '0.00';
            $lines = [];
            foreach ($data['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                $subtotal = Money::mul((string) $item['quantity'], (string) $item['cost_price']);
                $total = Money::add($total, $subtotal);
                $lines[] = [$product, $item, $subtotal];
            }
            $purchase = Purchase::create(['supplier_name' => $data['supplier_name'], 'purchase_date' => $data['purchase_date'], 'total_amount' => $total, 'payment_status' => $data['payment_status'], 'notes' => $data['notes'] ?? null]);
            foreach ($lines as [$product, $item, $subtotal]) {
                $purchase->items()->create(['product_id' => $product->id, 'quantity' => $item['quantity'], 'cost_price' => $item['cost_price'], 'subtotal' => $subtotal]);
                $product->increment('stock_quantity', $item['quantity']);
            }

            return $purchase->load('items.product');
        });
    }
}
