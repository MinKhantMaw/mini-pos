<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = ['invoice_number', 'customer_name', 'customer_phone', 'customer_address', 'sale_date', 'subtotal', 'discount', 'delivery_fee', 'total_amount', 'payment_method', 'payment_status'];

    protected function casts(): array
    {
        return ['sale_date' => 'date', 'subtotal' => 'decimal:2', 'discount' => 'decimal:2', 'delivery_fee' => 'decimal:2', 'total_amount' => 'decimal:2'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
