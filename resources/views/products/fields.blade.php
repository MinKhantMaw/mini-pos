@php
    $categoryOptions = $categories->map(fn($category) => ['id' => $category->id, 'name' => $category->name])->values();
@endphp

<div x-data="{
    categories: @js($categoryOptions),
    selectedCategory: '{{ old('category_id', $product->category_id) }}',
    categoryModalOpen: false,
    categorySaving: false,
    categoryError: '',
    newCategory: { name: '', description: '' },
    async createCategory() {
        this.categoryError = '';
        this.categorySaving = true;

        try {
            const response = await fetch('{{ route('categories.store') }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify(this.newCategory),
            });
            const payload = await response.json();

            if (!response.ok) {
                this.categoryError = Object.values(payload.errors || {}).flat()[0] || 'Could not save category.';
                return;
            }

            this.categories.push({ id: payload.category.id, name: payload.category.name });
            this.categories.sort((a, b) => a.name.localeCompare(b.name));
            this.selectedCategory = String(payload.category.id);
            this.newCategory = { name: '', description: '' };
            this.categoryModalOpen = false;
        } catch (error) {
            this.categoryError = 'Could not save category.';
        } finally {
            this.categorySaving = false;
        }
    }
}">
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700">
            <span class="mb-1 block">Name</span>
            <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                name="name" value="{{ old('name', $product->name) }}" required>
        </label>

        <label class="block text-sm font-medium text-slate-700">
            <span class="mb-1 block">SKU</span>
            <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                name="sku" value="{{ old('sku', $product->sku) }}" required>
        </label>

        <div class="sm:col-span-2">
            <div class="mb-1 flex items-center justify-between gap-3">
                <label class="text-sm font-medium text-slate-700" for="category_id">Category</label>
                <button type="button"
                    class="rounded-lg border border-emerald-200 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50"
                    @click="categoryModalOpen = true">+ New category</button>
            </div>
            <select id="category_id" name="category_id" x-model="selectedCategory"
                class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                <option value="">Select category</option>
                <template x-for="category in categories" :key="category.id">
                    <option :value="category.id" x-text="category.name"></option>
                </template>
            </select>
        </div>

        <label class="block text-sm font-medium text-slate-700">
            <span class="mb-1 block">Cost Price</span>
            <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}"
                required>
        </label>

        <label class="block text-sm font-medium text-slate-700">
            <span class="mb-1 block">Selling Price</span>
            <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                type="number" step="0.01" name="selling_price"
                value="{{ old('selling_price', $product->selling_price) }}" required>
        </label>

        @if ($product->exists)
            <label class="block text-sm font-medium text-slate-700">
                <span class="mb-1 block">Available stock</span>
                <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-700">
                    {{ number_format($product->stock_quantity ?? 0) }}</div>
            </label>
        @endif

        <label class="block text-sm font-medium text-slate-700">
            <span class="mb-1 block">Unit</span>
            <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                name="unit" value="{{ old('unit', $product->unit ?? 'pcs') }}" required>
        </label>

        <label class="block text-sm font-medium text-slate-700">
            <span class="mb-1 block">Status</span>
            <select class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                name="status">
                <option value="active" @selected(old('status', $product->status ?? 'active') === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactive</option>
            </select>
        </label>

        <label class="block text-sm font-medium text-slate-700 sm:col-span-2">
            <span class="mb-1 block">Image</span>
            <input
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white"
                type="file" name="image">
        </label>
    </div>

    @foreach (($errors ?? collect())->all() as $error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endforeach

    @include('shared.category-quick-create')
</div>
