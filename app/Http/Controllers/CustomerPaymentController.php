<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InstallmentSchedule;
use App\Services\TreasuryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerPaymentController extends Controller
{
    /**
     * Get all outstanding invoices for a customer
     */
    public function getOutstandingInvoices($customerId)
    {
        $merchantId = Auth::user()->merchant_id;

        $invoices = Invoice::where('customer_id', $customerId)
            ->where('merchant_id', $merchantId)
            ->where('is_fully_paid', false)
            ->with(['installmentSchedules' => function ($query) {
                $query->orderBy('installment_number');
            }])
            ->get();

        $totalRemaining = $invoices->sum('remaining_amount');

        return response()->json([
            'status' => 'ok',
            'invoices' => $invoices,
            'total_remaining' => $totalRemaining,
            'invoice_count' => $invoices->count(),
        ]);
    }

    /**
     * Process bulk payment for multiple invoices
     */
    public function bulkPayment(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_amount' => 'required|numeric|min:0.01',
            'invoices' => 'required|array|min:1',
            'invoices.*.id' => 'required|exists:invoices,id',
            'invoices.*.amount_to_pay' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $merchantId = Auth::user()->merchant_id;
            $totalPaidAmount = 0;

            foreach ($request->invoices as $invoiceData) {
                $invoice = Invoice::where('id', $invoiceData['id'])
                    ->where('merchant_id', $merchantId)
                    ->firstOrFail();

                $amountToPay = $invoiceData['amount_to_pay'];

                if ($amountToPay > 0) {
                    $this->applyPaymentToInvoice($invoice, $amountToPay);
                    $totalPaidAmount += $amountToPay;
                }
            }

            // Record in treasury
            if ($totalPaidAmount > 0) {
                app(TreasuryService::class)->recordTransaction(
                    'income',
                    'installment',
                    $totalPaidAmount,
                    "Bulk payment for Customer ID #{$request->customer_id}",
                    null
                );
            }

            DB::commit();

            return response()->json([
                'status' => 'ok',
                'msg' => 'تم تسجيل الدفع بنجاح',
                'total_paid' => $totalPaidAmount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to process bulk payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Apply payment to a single invoice
     */
    private function applyPaymentToInvoice($invoice, $paymentAmount)
    {
        if ($invoice->payment_type === 'full_payment') {
            // For full payment invoices
            $invoice->paid_amount += $paymentAmount;
            $invoice->remaining_amount = $invoice->total_amount - $invoice->paid_amount;

            if ($invoice->remaining_amount <= 0) {
                $invoice->payment_status = 'paid';
                $invoice->is_fully_paid = true;
                $invoice->remaining_amount = 0;
            } else {
                $invoice->payment_status = 'partial';
            }

            $invoice->save();

        } else {
            // For installment invoices
            $remainingPayment = $paymentAmount;
            $schedules = $invoice->installmentSchedules()
                ->whereIn('status', ['unpaid', 'partial'])
                ->orderBy('installment_number')
                ->get();

            foreach ($schedules as $schedule) {
                if ($remainingPayment <= 0) break;

                $amountDue = $schedule->amount - $schedule->paid_amount;
                $amountToPay = min($remainingPayment, $amountDue);

                $schedule->paid_amount += $amountToPay;
                $remainingPayment -= $amountToPay;

                if ($schedule->paid_amount >= $schedule->amount) {
                    $schedule->status = 'paid';
                    $schedule->paid_date = Carbon::now();
                } else if ($schedule->paid_amount > 0) {
                    $schedule->status = 'partial';
                }

                $schedule->save();
            }

            // Update invoice totals
            $totalPaidFromInstallments = $invoice->installmentSchedules()->sum('paid_amount');
            $invoice->paid_amount = $totalPaidFromInstallments + ($invoice->deposit_amount ?? 0);
            $invoice->remaining_amount = $invoice->total_amount - $invoice->paid_amount;

            if ($invoice->remaining_amount <= 0) {
                $invoice->payment_status = 'paid';
                $invoice->is_fully_paid = true;
                $invoice->remaining_amount = 0;
            } else if ($invoice->paid_amount > 0) {
                $invoice->payment_status = 'partial';
            }

            $invoice->save();
        }
    }
}
