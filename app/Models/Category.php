<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function purchaseItems(): HasManyThrough
    {
        return $this->hasManyThrough(PurchaseItem::class, Product::class);
    }
}
