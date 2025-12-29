<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
{
    /**
     * Display a listing of customer invoices.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $invoices = $customer->invoices()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('customer.invoices', compact('invoices', 'customer'));
    }

    /**
     * Display invoice details.
     */
    public function show($id)
    {
        $customer = Auth::guard('customer')->user();

        // Verify the invoice belongs to this customer
        // Using firstOrFail returns 404 if not found or doesn't belong to customer
        $invoice = $customer->invoices()
            ->with(['items.product', 'items.productVariation', 'installmentSchedules', 'merchant'])
            ->where('id', $id)
            ->firstOrFail();

        // Additional security check for merchant_id
        if ($invoice->merchant_id !== $customer->merchant_id) {
            abort(404);
        }

        return view('customer.invoice-details', compact('invoice', 'customer'));
    }
}
