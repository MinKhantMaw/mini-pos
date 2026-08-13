<x-pos-layout>
    <x-slot name="title">Sale {{ $sale->invoice_number }}</x-slot>

    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $sale->invoice_number }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $sale->customer_name }} · {{ $sale->sale_date->format('d M Y') }}</p>
            </div>
            <a class="rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-emerald-700"
                href="{{ route('invoices.show', $sale) }}">View Invoice</a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach ($sale->items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $item->product->name }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">{{ number_format($item->selling_price, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="mt-4 text-right text-lg font-bold text-slate-900">Total: {{ number_format($sale->total_amount, 2) }}</p>
    </div>
</x-pos-layout>
