<div class="mx-auto max-w-2xl rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-16 w-auto" />
            <div>
                <h1 class="text-2xl font-bold">INVOICE</h1>
                <p>{{ $sale->invoice_number }}</p>
            </div>
        </div>
        <div class="sm:text-right">
            <p>{{ $sale->sale_date->format('d M Y') }}</p>
            <p>{{ $sale->customer_name }}</p>
            @if ($sale->customer_phone)
                <p>{{ $sale->customer_phone }}</p>
            @endif
        </div>
    </div>

    <div class="mt-6 overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Item</th>
                    <th class="px-4 py-3">Qty</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @foreach ($sale->items as $item)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $item->product->name }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">{{ number_format($item->selling_price, 2) }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5 ml-auto max-w-xs space-y-1 text-right">
        <p>Subtotal: {{ number_format($sale->subtotal, 2) }}</p>
        <p>Discount: {{ number_format($sale->discount, 2) }}</p>
        <p>Delivery: {{ number_format($sale->delivery_fee, 2) }}</p>
        <p class="border-t pt-2 text-lg font-bold">Total: {{ number_format($sale->total_amount, 2) }}</p>
    </div>
</div>
