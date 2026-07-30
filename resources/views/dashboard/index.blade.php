<x-pos-layout>
    <x-slot name="title">Dashboard</x-slot>
    <div class="space-y-6">
        <div class="grid gap-4 lg:grid-cols-4">
            <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">This month's sales</p>
                <p class="mt-2 text-2xl font-semibold">{{ number_format($monthlySales, 2) }}</p>
            </div>
            <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">This month's purchases</p>
                <p class="mt-2 text-2xl font-semibold">{{ number_format($monthlyPurchases, 2) }}</p>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Unpaid invoices</p>
                <p class="mt-2 text-2xl font-semibold">{{ $unpaidInvoices }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Low stock products</p>
                <p class="mt-2 text-2xl font-semibold">{{ $lowStockProducts->count() }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Recent sales</h3>
                    <a href="{{ route('sales.index') }}" class="text-sm font-medium text-emerald-600">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-slate-500">
                                <th class="py-2">Invoice</th>
                                <th class="py-2">Customer</th>
                                <th class="py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Sale::latest('sale_date')->take(5)->get() as $sale)
                                <tr class="border-b">
                                    <td class="py-2"><a class="font-medium text-emerald-600"
                                            href="{{ route('sales.show', $sale) }}">{{ $sale->invoice_number }}</a></td>
                                    <td class="py-2">{{ $sale->customer_name }}</td>
                                    <td class="py-2">{{ number_format($sale->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Recent purchases</h3>
                    <a href="{{ route('purchases.index') }}" class="text-sm font-medium text-emerald-600">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-slate-500">
                                <th class="py-2">Date</th>
                                <th class="py-2">Supplier</th>
                                <th class="py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Purchase::latest('purchase_date')->take(5)->get() as $purchase)
                                <tr class="border-b">
                                    <td class="py-2"><a class="font-medium text-emerald-600"
                                            href="{{ route('purchases.show', $purchase) }}">{{ $purchase->purchase_date->format('d M Y') }}</a>
                                    </td>
                                    <td class="py-2">{{ $purchase->supplier_name }}</td>
                                    <td class="py-2">{{ number_format($purchase->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-pos-layout>
