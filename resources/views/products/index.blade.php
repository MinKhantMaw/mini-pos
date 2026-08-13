<x-pos-layout>
    <x-slot name="title">Products</x-slot>

    <div class="space-y-5">
        @if (session('success'))
            <div
                class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Inventory</h2>
                    <p class="mt-1 text-sm text-slate-500">Search, track, and manage your stock.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <form method="GET" action="{{ route('products.index') }}"
                        class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <select name="category_id"
                            class="rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            onchange="this.form.submit()">
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @if (request('category_id'))
                            <a href="{{ route('products.index') }}"
                                class="rounded-lg border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Clear</a>
                        @endif
                    </form>
                    <a class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                        href="{{ route('products.create') }}" aria-label="Add product">Add product</a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $product->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $product->sku }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($product->category)
                                        @php
                                            $palette = [
                                                'bg-emerald-100 text-emerald-800',
                                                'bg-sky-100 text-sky-800',
                                                'bg-amber-100 text-amber-800',
                                                'bg-rose-100 text-rose-800',
                                                'bg-violet-100 text-violet-800',
                                                'bg-cyan-100 text-cyan-800',
                                            ];
                                            $badgeClass = $palette[crc32($product->category->name) % count($palette)];
                                        @endphp
                                        <span
                                            class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClass }}">{{ $product->category->name }}</span>
                                    @else
                                        <span class="text-slate-400">Unassigned</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php($stockLevel = $product->stock_quantity < 5 ? 'low' : ($product->stock_quantity < 10 ? 'medium' : 'high'))
                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $stockLevel === 'low' ? 'bg-rose-100 text-rose-700' : ($stockLevel === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">{{ $product->stock_quantity }}
                                        {{ $product->unit }}</span>
                                </td>
                                <td class="px-4 py-3">{{ number_format($product->selling_price, 2) }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a class="font-semibold text-emerald-700 hover:text-emerald-800"
                                            href="{{ route('products.edit', $product) }}">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold text-red-600 hover:text-red-700"
                                                onclick="return confirm('Delete this product?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-8 text-center text-slate-500" colspan="5">No products yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        </div>
    </div>
</x-pos-layout>
