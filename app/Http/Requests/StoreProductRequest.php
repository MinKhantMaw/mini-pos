<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:255'], 'sku' => ['required', 'string', 'max:255', 'unique:products,sku'], 'category' => ['nullable', 'string', 'max:255'], 'cost_price' => ['required', 'decimal:0,2', 'min:0'], 'selling_price' => ['required', 'decimal:0,2', 'min:0'], 'stock_quantity' => ['nullable', 'integer', 'min:0'], 'unit' => ['required', 'string', 'max:255'], 'image' => ['nullable', 'image', 'max:2048'], 'status' => ['required', 'in:active,inactive']];
    }
}
