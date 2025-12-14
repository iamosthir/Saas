<?php

namespace App\Http\Controllers;

use App\Models\CustomerSaleInvoice;
use App\Models\CustomerSalePayments;
use Illuminate\Http\Request;

class CustomerSalePaymentsController extends Controller
{
    public function storePayment(Request $request)
{
    $data = $request->validate([
        'invoice_id' => 'required|exists:customer_sale_invoices,id',
        'amount'     => 'required|numeric|min:1',
        'remarks'    => 'nullable|string|max:255',
    ]);

    // Check if invoice belongs to merchant
    $merchantId = auth()->user()->merchant_id;
    $invoice = CustomerSaleInvoice::where('id', $data['invoice_id'])
        ->where('merchant_id', $merchantId)
        ->first();

    if (!$invoice) {
        return response()->json([
            'status' => 'fail',
            'msg'    => 'Invoice not found'
        ], 404);
    }

    // Calculate the current total paid
    $currentPaid = $invoice->payments()->sum('amount');
    $due = $invoice->total_price - $currentPaid;

    // Check that payment does not exceed due
    if ($data['amount'] > $due) {
        return response()->json([
            'status' => 'error',
            'msg'    => 'Payment amount exceeds the due amount.'
        ], 422);
    }

    // Create payment
    $payment = CustomerSalePayments::create([
        'customer_sale_invoice_id' => $invoice->id,
        'amount'                   => $data['amount'],
        'remarks'                  => $data['remarks'] ?? null,
    ]);

    return response()->json([
        'status' => 'ok',
        'msg'    => 'Payment added successfully',
        'data'   => $payment
    ]);
}
}
