<x-pos-layout>
    <x-slot name="title">Add Product</x-slot>
    <div class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <form class="space-y-4" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('products.fields', ['product' => new App\Models\Product()])
            <button class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Save Product</button>
        </form>
    </div>
</x-pos-layout>
