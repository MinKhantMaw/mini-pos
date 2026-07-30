<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = ['supplier_name', 'purchase_date', 'total_amount', 'payment_status', 'notes'];

    protected function casts(): array
    {
        return ['purchase_date' => 'date', 'total_amount' => 'decimal:2'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
