<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,'.$this->product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'cost_price' => ['required', 'decimal:0,2', 'min:0'],
            'selling_price' => ['required', 'decimal:0,2', 'min:0'],
            'unit' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('category') && ! $this->filled('category_id')) {
            $category = Category::firstOrCreate(['name' => $this->input('category')]);
            $this->merge(['category_id' => $category->id]);
        }
    }
}
