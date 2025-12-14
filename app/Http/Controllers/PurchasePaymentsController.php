<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\PurchasePayments;
use Illuminate\Http\Request;

class PurchasePaymentsController extends Controller
{
    public function storePayment(Request $request)
    {
        // Validate the request
        $data = $request->validate([
            'invoice_id' => 'required|exists:purchase_invoices,id',
            'amount'     => 'required|numeric|min:1',
            'remarks'    => 'nullable|string',
        ]);

        // Check if invoice belongs to merchant
        $merchantId = auth()->user()->merchant_id;
        $invoice = PurchaseInvoice::where('id', $data['invoice_id'])
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$invoice) {
            return response()->json(['status' => 'fail', 'msg' => 'Invoice not found'], 404);
        }

        // Store the payment
        $payment = PurchasePayments::create([
            'invoice_id' => $data['invoice_id'],
            'amount'     => $data['amount'],
            'remarks'    => $data['remarks'] ?? null,
        ]);
        $totalPaid = $invoice->payments()->sum('amount');
        if ($totalPaid >= $invoice->total_price) {
            $invoice->payment_status = 'paid';
        } elseif ($totalPaid > 0) {
            $invoice->payment_status = 'partial';
        } else {
            $invoice->payment_status = 'pending';
        }
        $invoice->save();

        return response()->json(['status' => 'ok', 'msg' => 'Payment recorded successfully', 'data' => $payment]);
    }

}
