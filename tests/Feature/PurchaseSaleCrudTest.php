<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseSaleCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_and_sale_creation_flows_work(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::create([
            'name' => 'Ink',
            'sku' => 'INK-001',
            'category' => 'Supplies',
            'cost_price' => '5.00',
            'selling_price' => '8.00',
            'stock_quantity' => 10,
            'unit' => 'pcs',
            'status' => 'active',
        ]);

        $purchaseResponse = $this->post('/purchases', [
            'supplier_name' => 'Supplier One',
            'purchase_date' => '2026-07-30',
            'payment_status' => 'paid',
            'notes' => 'Initial stock',
            'items' => [[
                'product_id' => $product->id,
                'quantity' => 3,
                'cost_price' => '6.00',
            ]],
        ]);

        $purchaseResponse->assertRedirect();
        $purchase = Purchase::latest()->firstOrFail();
        $this->assertSame(3, $purchase->items()->first()->quantity);
        $this->assertSame(13, $product->fresh()->stock_quantity);

        $saleResponse = $this->post('/sales', [
            'customer_name' => 'Acme Ltd',
            'customer_phone' => '001',
            'customer_address' => 'Main Street',
            'sale_date' => '2026-07-30',
            'discount' => '0.00',
            'delivery_fee' => '0.00',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'items' => [[
                'product_id' => $product->id,
                'quantity' => 2,
                'selling_price' => '8.00',
            ]],
        ]);

        $saleResponse->assertRedirect();
        $sale = Sale::latest()->firstOrFail();
        $this->assertSame(2, $sale->items()->first()->quantity);
        $this->assertSame(11, $product->fresh()->stock_quantity);
    }
}
