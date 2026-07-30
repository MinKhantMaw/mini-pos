<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'sku', 'category', 'cost_price', 'selling_price', 'stock_quantity', 'unit', 'image', 'status'];

    protected function casts(): array
    {
        return ['cost_price' => 'decimal:2', 'selling_price' => 'decimal:2', 'stock_quantity' => 'integer'];
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
