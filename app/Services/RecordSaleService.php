<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class RecordSaleService
{
    public function create(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $subtotal = '0.00';
            $lines = [];
            foreach ($data['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                if ($product->stock_quantity < $item['quantity']) {
                    throw new InsufficientStockException("Insufficient stock for {$product->name}. Available: {$product->stock_quantity} {$product->unit}.");
                }
                $line = Money::mul((string) $item['quantity'], (string) $item['selling_price']);
                $subtotal = Money::add($subtotal, $line);
                $lines[] = [$product, $item, $line];
            }
            $discount = (string) ($data['discount'] ?? '0.00');
            $delivery = (string) ($data['delivery_fee'] ?? '0.00');
            $total = Money::add(Money::sub($subtotal, $discount), $delivery);
            if (bccomp($total, '0.00', 2) < 0) {
                throw new \InvalidArgumentException('Discount cannot exceed the subtotal plus delivery fee.');
            }
            $last = Sale::lockForUpdate()->latest('id')->value('invoice_number');
            $number = $last && preg_match('/-(\d+)$/', $last, $matches) ? ((int) $matches[1]) + 1 : 1;
            $sale = Sale::create(['invoice_number' => sprintf('INV-%s-%04d', now()->format('Y'), $number), 'customer_name' => $data['customer_name'], 'customer_phone' => $data['customer_phone'] ?? null, 'customer_address' => $data['customer_address'] ?? null, 'sale_date' => $data['sale_date'], 'subtotal' => $subtotal, 'discount' => $discount, 'delivery_fee' => $delivery, 'total_amount' => $total, 'payment_method' => $data['payment_method'], 'payment_status' => $data['payment_status']]);
            foreach ($lines as [$product, $item, $line]) {
                $sale->items()->create(['product_id' => $product->id, 'quantity' => $item['quantity'], 'selling_price' => $item['selling_price'], 'subtotal' => $line]);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            return $sale->load('items.product');
        });
    }
}
