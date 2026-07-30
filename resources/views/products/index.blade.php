<x-pos-layout>
    <x-slot name="title">Products</x-slot>
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold">Inventory</h2>
                <p class="text-sm text-slate-500">Search, track, and manage your stock.</p>
            </div>
            <a class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white"
                href="{{ route('products.create') }}">Add product</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-slate-500">
                        <th class="py-3">Product</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Stock</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b">
                            <td class="py-3">
                                <div class="font-medium">{{ $product->name }}</div>
                                <div class="text-xs text-slate-500">{{ $product->sku }}</div>
                            </td>
                            <td class="py-3">{{ $product->category ?? '—' }}</td>
                            <td class="py-3">
                                @php($stockLevel = $product->stock_quantity < 5 ? 'low' : ($product->stock_quantity < 10 ? 'medium' : 'high'))
                                <span
                                    class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $stockLevel === 'low' ? 'bg-rose-100 text-rose-700' : ($stockLevel === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">{{ $product->stock_quantity }}
                                    {{ $product->unit }}</span>
                            </td>
                            <td class="py-3">{{ number_format($product->selling_price, 2) }}</td>
                            <td class="py-3">
                                <a class="font-medium text-emerald-600"
                                    href="{{ route('products.edit', $product) }}">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-4 text-center text-slate-500" colspan="5">No products yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-pos-layout>
