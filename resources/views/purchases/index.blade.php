<x-pos-layout>
    <x-slot name="title">Purchases</x-slot>
    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold">Purchase history</h2>
                <p class="text-sm text-slate-500">Track supplier orders and stock additions.</p>
            </div>
            <a class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                href="{{ route('purchases.create') }}">New purchase</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-slate-500">
                        <th class="py-3">Date</th>
                        <th class="py-3">Supplier</th>
                        <th class="py-3">Total</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-3"><a class="font-medium text-emerald-600"
                                    href="{{ route('purchases.show', $purchase) }}">{{ $purchase->purchase_date->format('d M Y') }}</a>
                            </td>
                            <td class="py-3">{{ $purchase->supplier_name }}</td>
                            <td class="py-3">{{ number_format($purchase->total_amount, 2) }}</td>
                            <td class="py-3"><span
                                    class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($purchase->payment_status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-4 text-center text-slate-500" colspan="4">No purchases yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $purchases->links() }}</div>
    </div>
</x-pos-layout>
