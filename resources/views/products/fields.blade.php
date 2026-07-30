<div class="grid gap-4 sm:grid-cols-2">
    @foreach (['name' => 'Name', 'sku' => 'SKU', 'category' => 'Category', 'cost_price' => 'Cost Price', 'selling_price' => 'Selling Price', 'stock_quantity' => 'Opening Stock', 'unit' => 'Unit'] as $field => $label)
        <label class="block text-sm font-medium text-slate-600">
            <span class="mb-1 block">{{ $label }}</span>
            <input class="mt-1 w-full rounded-lg border-slate-300" name="{{ $field }}"
                value="{{ old($field, $field === 'stock_quantity' ? $product->stock_quantity ?? 0 : ($field === 'unit' ? $product->unit ?? 'pcs' : $product->$field ?? '')) }}"
                {{ in_array($field, ['cost_price', 'selling_price']) ? 'type=number step=0.01' : ($field === 'stock_quantity' ? 'type=number min=0' : '') }}
                {{ $field === 'category' ? '' : 'required' }}>
        </label>
    @endforeach
    <label class="block text-sm font-medium text-slate-600">
        <span class="mb-1 block">Status</span>
        <select class="mt-1 w-full rounded-lg border-slate-300" name="status">
            <option value="active" @selected(old('status', $product->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactive</option>
        </select>
    </label>
    <label class="block text-sm font-medium text-slate-600 sm:col-span-2">
        <span class="mb-1 block">Image</span>
        <input class="mt-1 w-full" type="file" name="image">
    </label>
</div>
@foreach (($errors ?? collect())->all() as $error)
    <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
@endforeach
