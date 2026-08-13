<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Sale $sale)
    {
        $sale->load('items.product');

        return view('invoices.show', compact('sale'));
    }

    public function downloadPdf(Sale $sale)
    {
        $sale->load('items.product');

        return Pdf::loadView('invoices.pdf', compact('sale'))
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->download("invoice-{$sale->invoice_number}.pdf");
    }
}
