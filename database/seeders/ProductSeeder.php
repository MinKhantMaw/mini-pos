<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([['Arabica Coffee Beans', 'COF-001', 'Groceries', '12.50', '18.00', 20], ['Green Tea Bags', 'TEA-001', 'Groceries', '3.20', '5.50', 35], ['Whole Milk 1L', 'MLK-001', 'Dairy', '1.30', '2.10', 18], ['Sourdough Bread', 'BRD-001', 'Bakery', '1.80', '3.00', 12], ['Basmati Rice 5kg', 'RIC-001', 'Groceries', '9.00', '13.50', 8], ['Olive Oil 500ml', 'OIL-001', 'Pantry', '6.75', '10.00', 14], ['Dish Soap 750ml', 'CLN-001', 'Household', '2.40', '4.00', 10], ['Notebook A5', 'STA-001', 'Stationery', '1.10', '2.00', 30], ['USB-C Cable', 'TEC-001', 'Electronics', '3.50', '7.50', 9], ['Canvas Tote Bag', 'BAG-001', 'Accessories', '4.00', '8.00', 6]] as [$name, $sku, $category, $cost, $sell, $stock]) {
            Product::create(['name' => $name, 'sku' => $sku, 'category' => $category, 'cost_price' => $cost, 'selling_price' => $sell, 'stock_quantity' => $stock, 'unit' => 'pcs', 'status' => 'active']);
        }
    }
}
