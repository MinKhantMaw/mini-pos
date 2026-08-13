<x-pos-layout>
    <x-slot name="title">Invoice {{ $sale->invoice_number }}</x-slot>

    <style>
        @media print {
            aside,
            header,
            .no-print {
                display: none !important;
            }

            main {
                background: white !important;
                padding: 0 !important;
            }
        }
    </style>

    <div class="space-y-4">
        <div class="no-print flex flex-col gap-2 sm:flex-row sm:justify-end">
            <a class="rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-emerald-700"
                href="{{ route('invoices.pdf', $sale) }}">Download PDF</a>
            <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                onclick="window.print()">Print</button>
        </div>

        @include('invoices.document')
    </div>
</x-pos-layout>
