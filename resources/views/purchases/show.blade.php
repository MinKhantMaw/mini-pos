<x-pos-layout>
    <x-slot name="title">Purchase: {{ $purchase->supplier_name }}</x-slot>

    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $purchase->supplier_name }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $purchase->purchase_date->format('d M Y') }}</p>
            </div>
            <span class="w-fit rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($purchase->payment_status) }}</span>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Cost</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach ($purchase->items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $item->product->name }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">{{ number_format($item->cost_price, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="mt-4 text-right text-lg font-bold text-slate-900">Total: {{ number_format($purchase->total_amount, 2) }}</p>
    </div>
</x-pos-layout>
