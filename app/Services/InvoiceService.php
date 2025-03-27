<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    /**
     * Generate an invoice for an order
     *
     * @param Order $order
     * @return Invoice
     */
    public function generateInvoice(Order $order)
    {
        // Calculate subtotal
        $subtotal = $order->total_price;

        // Calculate tax (assuming 10% tax rate)
        $tax = $subtotal * 0.10;

        // Calculate total
        $total = $subtotal + $tax;

        // Create invoice
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => (new Invoice())->generateInvoiceNumber(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => 'paid',
            'issue_date' => now()
        ]);

        // Generate PDF
        $this->generatePDF($invoice);

        return $invoice;
    }

    /**
     * Generate PDF for the invoice
     *
     * @param Invoice $invoice
     * @return string
     */
    public function generatePDF(Invoice $invoice)
    {
        $pdf = PDF::loadView('pdfs.invoice', [
            'invoice' => $invoice,
            'order' => $invoice->order,
            'user' => $invoice->order->user,
            'items' => $invoice->order->orderItems
        ]);

        // Generate filename
        $filename = 'invoices/' . $invoice->invoice_number . '.pdf';

        // Save PDF to storage
        Storage::put('public/' . $filename, $pdf->output());

        return $filename;
    }

    /**
     * Get invoice PDF path
     *
     * @param Invoice $invoice
     * @return string|null
     */
    public function getInvoicePDFPath(Invoice $invoice)
    {
        $filename = 'invoices/' . $invoice->invoice_number . '.pdf';
        return Storage::exists('public/' . $filename) ? $filename : null;
    }
}
