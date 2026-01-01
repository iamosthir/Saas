<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InstallmentSchedule;
use Illuminate\Support\Facades\Auth;

class QuickInvoiceController extends Controller
{
    /**
     * Get customer summary before quick invoice creation
     */
    public function getCustomerSummary($customerId)
    {
        $merchantId = Auth::user()->merchant_id;

        $customer = Customer::where('id', $customerId)
            ->where('merchant_id', $merchantId)
            ->with(['invoices' => function($q) {
                $q->with('items.product', 'installmentSchedules');
            }])
            ->firstOrFail();

        $totalInvoices = $customer->invoices->count();
        $totalRemaining = $customer->invoices->sum('remaining_amount');
        $totalPaid = $customer->invoices->sum('paid_amount');
        $totalAmount = $customer->invoices->sum('total_amount');

        // Count active (unpaid) installments across all invoices
        $activeInstallments = InstallmentSchedule::whereHas('invoice', function($q) use ($customerId, $merchantId) {
            $q->where('customer_id', $customerId)
              ->where('merchant_id', $merchantId);
        })->where('status', 'unpaid')->count();

        // Get previous purchases (last 10 invoice items)
        $previousPurchases = $customer->invoices()
            ->with('items.product')
            ->latest()
            ->take(10)
            ->get()
            ->flatMap(function($invoice) {
                return $invoice->items->map(function($item) use ($invoice) {
                    return [
                        'invoice_number' => $invoice->invoice_number,
                        'product_name' => $item->product_name,
                        'variation_name' => $item->variation_name,
                        'quantity' => $item->quantity,
                        'price' => $item->custom_price,
                        'total' => $item->line_total,
                        'date' => $invoice->created_at->format('Y-m-d'),
                    ];
                });
            });

        return response()->json([
            'status' => 'ok',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->customer_name,
                'phone1' => $customer->phone1,
                'phone2' => $customer->phone2,
                'address' => $customer->address ?? '',
                'sponsor_name' => $customer->sponsor_name,
                'sponsor_phone' => $customer->sponsor_phone,
            ],
            'stats' => [
                'total_invoices' => $totalInvoices,
                'total_amount' => $totalAmount,
                'total_remaining' => $totalRemaining,
                'total_paid' => $totalPaid,
                'active_installments' => $activeInstallments,
            ],
            'previous_purchases' => $previousPurchases,
        ]);
    }
}
