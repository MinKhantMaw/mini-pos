<x-pos-layout>
    <x-slot name="title">Product Details</x-slot>

    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $product->name }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $product->sku }}</p>
            </div>
            <div class="flex flex-col-reverse gap-2 sm:flex-row">
                <a class="rounded-lg border border-slate-200 px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    href="{{ route('products.index') }}">Back</a>
                <a class="rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-emerald-700"
                    href="{{ route('products.edit', $product) }}">Edit</a>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <p class="text-sm text-slate-500">Category</p>
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
                    <span class="mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClass }}">{{ $product->category->name }}</span>
                @else
                    <p class="font-semibold text-slate-900">Unassigned</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-slate-500">Status</p>
                <p class="font-semibold text-slate-900">{{ ucfirst($product->status) }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Stock</p>
                <p class="font-semibold text-slate-900">{{ $product->stock_quantity }} {{ $product->unit }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Cost price</p>
                <p class="font-semibold text-slate-900">{{ number_format($product->cost_price, 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Selling price</p>
                <p class="font-semibold text-slate-900">{{ number_format($product->selling_price, 2) }}</p>
            </div>
        </div>
    </div>
</x-pos-layout>
