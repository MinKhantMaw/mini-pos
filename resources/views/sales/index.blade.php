<x-pos-layout>
    <x-slot name="title">Sales</x-slot>
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold">Sales history</h2>
                <p class="text-sm text-slate-500">Review recent invoices and payment status.</p>
            </div>
            <a class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white"
                href="{{ route('sales.create') }}">New sale</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-slate-500">
                        <th class="py-3">Invoice</th>
                        <th class="py-3">Customer</th>
                        <th class="py-3">Total</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr class="border-b">
                            <td class="py-3"><a class="font-medium text-emerald-600"
                                    href="{{ route('sales.show', $sale) }}">{{ $sale->invoice_number }}</a></td>
                            <td class="py-3">{{ $sale->customer_name }}</td>
                            <td class="py-3">{{ number_format($sale->total_amount, 2) }}</td>
                            <td class="py-3"><span
                                    class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($sale->payment_status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-4 text-center text-slate-500" colspan="4">No sales yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $sales->links() }}
    </div>
</x-pos-layout>
