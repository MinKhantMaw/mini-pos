<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_crud_flow_works(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $createResponse = $this->post('/products', [
            'name' => 'Notebook',
            'sku' => 'NB-001',
            'category' => 'Office',
            'cost_price' => '10.00',
            'selling_price' => '15.00',
            'stock_quantity' => '5',
            'unit' => 'pcs',
            'status' => 'active',
        ]);

        $createResponse->assertRedirect(route('products.index'));

        $product = Product::latest()->firstOrFail();

        $this->get("/products/{$product->id}")
            ->assertOk()
            ->assertSee('Notebook');

        $this->put("/products/{$product->id}", [
            'name' => 'Updated Notebook',
            'sku' => 'NB-001',
            'category' => 'Office',
            'cost_price' => '10.00',
            'selling_price' => '18.00',
            'stock_quantity' => '8',
            'unit' => 'pcs',
            'status' => 'active',
        ])->assertRedirect(route('products.index'));

        $this->assertSame('Updated Notebook', $product->fresh()->name);

        $this->delete("/products/{$product->id}")
            ->assertRedirect();

        $this->assertSoftDeleted($product);
    }
}
