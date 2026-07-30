<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">Product Details</h2>
            <div class="space-x-2">
                <a class="rounded bg-indigo-600 px-4 py-2 text-white"
                    href="{{ route('products.edit', $product) }}">Edit</a>
                <a class="rounded bg-gray-200 px-4 py-2" href="{{ route('products.index') }}">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="bg-white shadow rounded p-6">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-semibold">{{ $product->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">SKU</p>
                    <p class="font-semibold">{{ $product->sku }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Category</p>
                    <p class="font-semibold">{{ $product->category ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold">{{ $product->status }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Cost Price</p>
                    <p class="font-semibold">{{ number_format($product->cost_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Selling Price</p>
                    <p class="font-semibold">{{ number_format($product->selling_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stock</p>
                    <p class="font-semibold">{{ $product->stock_quantity }} {{ $product->unit }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
