<x-pos-layout>
    <x-slot name="title">Edit Product</x-slot>

    <div class="max-w-4xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h2 class="text-xl font-semibold text-slate-900">Edit Product</h2>
            <p class="mt-1 text-sm text-slate-500">Update product details, pricing, status, and category.</p>
        </div>

        <form class="space-y-5" method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products.fields', ['product' => $product, 'categories' => $categories])
            <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('products.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Update Product</button>
            </div>
        </form>
    </div>
</x-pos-layout>
