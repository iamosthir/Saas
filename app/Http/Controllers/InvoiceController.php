<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InstallmentSchedule;
use App\Models\InvoiceActivityLog;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\TreasuryService;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone1' => 'required|string|max:20',
            'customer_phone2' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_address' => 'nullable|string',
            'customer_state' => 'nullable|string',
            'customer_city' => 'nullable|string',
            'sponsor_name' => 'nullable|string|max:255',
            'sponsor_phone' => 'nullable|string|max:20',
            'payment_type' => 'required|in:full_payment,installment',
            'installment_months' => 'required_if:payment_type,installment|nullable|integer|min:1',
            'has_deposit' => 'nullable|boolean',
            'deposit_amount' => 'required_if:has_deposit,true|nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount_amount' => 'nullable|numeric|min:0',
            'extra_charge' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_variation_id' => 'nullable|exists:product_variations,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.custom_price' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $merchantId = $user->merchant_id;

            // Find or create customer
            $customer = Customer::where('phone1', $request->customer_phone1)
                ->orWhere('phone', $request->customer_phone1)
                ->first();

            if (!$customer) {
                $customer = Customer::create([
                    'merchant_id' => $merchantId,
                    'customer_name' => $request->customer_name,
                    'phone' => $request->customer_phone1,
                    'phone1' => $request->customer_phone1,
                    'phone2' => $request->customer_phone2,
                    'state' => $request->customer_state,
                    'city' => $request->customer_city,
                    'sponsor_name' => $request->sponsor_name,
                    'sponsor_phone' => $request->sponsor_phone,
                ]);
            }

            // Calculate subtotal with dual pricing
            $subtotal = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $variation = isset($item['product_variation_id']) ? ProductVariation::find($item['product_variation_id']) : null;

                // Use dual pricing based on payment type
                $priceToUse = $variation
                    ? $variation->getPriceForPaymentType($request->payment_type)
                    : $product->getPriceForPaymentType($request->payment_type);

                // Use custom_price if provided, otherwise use calculated price
                $finalPrice = $item['custom_price'] ?? $priceToUse;

                $subtotal += $finalPrice * $item['quantity'];
            }

            // Calculate discount
            $discountAmount = $request->discount_amount ?? 0;
            if ($request->discount_type === 'percentage') {
                $discountAmount = ($subtotal * $discountAmount) / 100;
            }

            // Calculate total
            $extraCharge = $request->extra_charge ?? 0;
            $totalAmount = $subtotal - $discountAmount + $extraCharge;

            // Create invoice
            $hasDeposit = $request->payment_type === 'installment' && $request->has_deposit;
            $depositAmount = $hasDeposit ? ($request->deposit_amount ?? 0) : 0;

            $invoice = Invoice::create([
                'merchant_id' => $merchantId,
                'customer_id' => $customer->id,
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'subtotal' => $subtotal,
                'discount_type' => $request->discount_type ?? 'fixed',
                'discount_amount' => $request->discount_amount ?? 0,
                'extra_charge' => $extraCharge,
                'total_amount' => $totalAmount,
                'payment_type' => $request->payment_type,
                'installment_months' => $request->installment_months,
                'has_deposit' => $hasDeposit,
                'deposit_amount' => $depositAmount,
                'paid_amount' => $depositAmount,
                'remaining_amount' => $totalAmount - $depositAmount,
                'payment_status' => $depositAmount > 0 ? 'partial' : 'unpaid',
                'is_fully_paid' => false,
                'notes' => $request->notes,
                'created_by' => $user->id,
            ]);

            // Create invoice items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $variation = isset($item['product_variation_id']) ? ProductVariation::find($item['product_variation_id']) : null;

                // Use dual pricing based on payment type
                $priceToUse = $variation
                    ? $variation->getPriceForPaymentType($request->payment_type)
                    : $product->getPriceForPaymentType($request->payment_type);

                // Use custom_price if provided, otherwise use calculated price
                $finalPrice = $item['custom_price'] ?? $priceToUse;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'product_variation_id' => $item['product_variation_id'] ?? null,
                    'product_name' => $product->name,
                    'variation_name' => $variation ? $variation->var_name : null,
                    'quantity' => $item['quantity'],
                    'original_price' => $priceToUse,
                    'custom_price' => $finalPrice,
                    'line_total' => $finalPrice * $item['quantity'],
                ]);
            }

            // Handle payment type
            if ($request->payment_type === 'full_payment') {
                $paidAmount = $request->paid_amount ?? $totalAmount;
                $invoice->update([
                    'paid_amount' => $paidAmount,
                    'remaining_amount' => $totalAmount - $paidAmount,
                    'payment_status' => $paidAmount >= $totalAmount ? 'paid' : ($paidAmount > 0 ? 'partial' : 'unpaid'),
                    'is_fully_paid' => $paidAmount >= $totalAmount,
                ]);

                // Record full payment in treasury
                if ($paidAmount > 0) {
                    app(TreasuryService::class)->recordTransaction(
                        'income',
                        'invoice_payment',
                        $paidAmount,
                        "Full payment for Invoice #{$invoice->invoice_number}",
                        $invoice
                    );
                }
            } else {
                // Create installment schedules (amount to finance = total - deposit)
                $amountToFinance = $totalAmount - $depositAmount;
                $baseInstallmentAmount = $amountToFinance / $request->installment_months;

                // Round up to nearest 100 for a round figure
                $roundedInstallmentAmount = ceil($baseInstallmentAmount / 100) * 100;

                // Calculate last month amount (remainder)
                $regularMonths = $request->installment_months - 1;
                $lastMonthAmount = $amountToFinance - ($roundedInstallmentAmount * $regularMonths);

                $currentDate = Carbon::now();

                for ($i = 1; $i <= $request->installment_months; $i++) {
                    // Use rounded amount for first (n-1) months, remainder for last month
                    $installmentAmount = ($i < $request->installment_months)
                        ? $roundedInstallmentAmount
                        : $lastMonthAmount;

                    InstallmentSchedule::create([
                        'invoice_id' => $invoice->id,
                        'installment_number' => $i,
                        'due_date' => $currentDate->copy()->addMonths($i),
                        'amount' => $installmentAmount,
                        'paid_amount' => 0,
                        'status' => 'unpaid',
                    ]);
                }

                // Record deposit in treasury if applicable
                if ($depositAmount > 0) {
                    app(TreasuryService::class)->recordTransaction(
                        'income',
                        'deposit',
                        $depositAmount,
                        "Deposit for Invoice #{$invoice->invoice_number}",
                        $invoice
                    );
                }

                // Apply additional initial paid amount if any (beyond deposit)
                if ($request->paid_amount && $request->paid_amount > 0) {
                    $this->applyPaymentToInstallments($invoice, $request->paid_amount);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'ok',
                'msg' => 'Invoice created successfully',
                'invoice' => $invoice->load(['items', 'installmentSchedules']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to create invoice: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function applyPaymentToInstallments($invoice, $paymentAmount)
    {
        $remainingPayment = $paymentAmount;
        $schedules = $invoice->installmentSchedules()->orderBy('installment_number')->get();

        foreach ($schedules as $schedule) {
            if ($remainingPayment <= 0) break;

            $amountToPay = min($remainingPayment, $schedule->amount - $schedule->paid_amount);
            $schedule->paid_amount += $amountToPay;
            $remainingPayment -= $amountToPay;

            if ($schedule->paid_amount >= $schedule->amount) {
                $schedule->status = 'paid';
                $schedule->paid_date = Carbon::now();
            } else {
                $schedule->status = 'partial';
            }
            $schedule->save();
        }

        $totalPaid = $invoice->installmentSchedules()->sum('paid_amount');
        $invoice->update([
            'paid_amount' => $totalPaid,
            'remaining_amount' => $invoice->total_amount - $totalPaid,
            'payment_status' => $totalPaid >= $invoice->total_amount ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid'),
            'is_fully_paid' => $totalPaid >= $invoice->total_amount,
        ]);
    }

    public function getCustomers(Request $request)
    {
        $search = $request->query('search');
        $merchantId = Auth::user()->merchant_id;

        $customers = Customer::where('merchant_id', $merchantId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('phone1', 'like', "%{$search}%");
                });
            })
            ->limit(20)
            ->get(['id', 'customer_name as name', 'phone', 'phone1', 'phone2', 'state', 'city']);

        return response()->json($customers);
    }

    public function markAsPaid($id)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($id);

            $amountToRecord = $invoice->remaining_amount;

            $invoice->update([
                'paid_amount' => $invoice->total_amount,
                'remaining_amount' => 0,
                'payment_status' => 'paid',
                'is_fully_paid' => true,
            ]);

            // Mark all installments as paid
            if ($invoice->payment_type === 'installment') {
                $invoice->installmentSchedules()->update([
                    'paid_amount' => DB::raw('amount'),
                    'status' => 'paid',
                    'paid_date' => Carbon::now(),
                ]);
            }

            // Record remaining amount in treasury
            if ($amountToRecord > 0) {
                app(TreasuryService::class)->recordTransaction(
                    'income',
                    $invoice->payment_type === 'installment' ? 'installment' : 'invoice_payment',
                    $amountToRecord,
                    "Mark as paid for Invoice #{$invoice->invoice_number}",
                    $invoice
                );
            }

            DB::commit();

            return response()->json([
                'status' => 'ok',
                'msg' => 'Invoice marked as fully paid',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to update invoice: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getList(Request $request)
    {
        try {
            $merchantId = Auth::user()->merchant_id;

            $invoices = Invoice::where('merchant_id', $merchantId)
                ->with(['customer', 'items.product', 'items.productVariation', 'createdBy'])
                ->orderBy('id', 'desc')
                ->paginate(20);

            // Calculate totals
            $totalQuantity = 0;
            $totalPrice = 0;

            foreach ($invoices->items() as $invoice) {
                $totalQuantity += $invoice->items->sum('quantity');
                $totalPrice += $invoice->total_amount;
            }

            return response()->json([
                'invoices' => $invoices,
                'total_qnt' => $totalQuantity,
                'total_price' => $totalPrice,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to fetch invoices: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $invoice = Invoice::with(['customer', 'items', 'installmentSchedules', 'createdBy'])
                ->findOrFail($id);

            // Check if user has access to this invoice
            if ($invoice->merchant_id !== Auth::user()->merchant_id) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Unauthorized access',
                ], 403);
            }

            $installments = $invoice->installmentSchedules()->orderBy('installment_number')->get();

            return response()->json([
                'invoice' => $invoice,
                'installments' => $installments,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to fetch invoice details: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function payInstallment(Request $request, $installmentId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            $installment = InstallmentSchedule::findOrFail($installmentId);
            $invoice = $installment->invoice;

            // Check if user has access to this invoice
            if ($invoice->merchant_id !== Auth::user()->merchant_id) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Unauthorized access',
                ], 403);
            }

            $paymentAmount = $request->amount;
            $remainingForInstallment = $installment->amount - $installment->paid_amount;
            $userName = Auth::user()->name;

            if ($paymentAmount >= $remainingForInstallment) {
                // Full payment or overpayment
                $installment->paid_amount += $remainingForInstallment;
                $installment->status = 'paid';
                $installment->paid_date = Carbon::now();
                $installment->save();

                // Log full payment
                InvoiceActivityLog::create([
                    'invoice_id' => $invoice->id,
                    'installment_schedule_id' => $installment->id,
                    'user_id' => Auth::id(),
                    'action_type' => 'payment_full',
                    'description' => "تم دفع القسط رقم {$installment->installment_number} بالكامل بمبلغ " . number_format($remainingForInstallment, 0) . " د.ع بواسطة {$userName}",
                    'amount' => $remainingForInstallment,
                ]);

                $overpayment = $paymentAmount - $remainingForInstallment;

                // Continue cascade to next installments if overpayment
                if ($overpayment > 0) {
                    $this->applyPaymentToInstallments($invoice, $overpayment);
                }
            } else {
                // PARTIAL PAYMENT - Mark as paid and add shortfall to LAST installment
                $shortfall = $remainingForInstallment - $paymentAmount;

                // Mark this installment as fully paid (even though it was partial)
                $installment->paid_amount = $installment->amount; // Set to full amount
                $installment->status = 'paid'; // Mark as paid
                $installment->paid_date = Carbon::now();
                $installment->save();

                // Log partial payment
                InvoiceActivityLog::create([
                    'invoice_id' => $invoice->id,
                    'installment_schedule_id' => $installment->id,
                    'user_id' => Auth::id(),
                    'action_type' => 'payment_partial',
                    'description' => "تم دفع جزء من القسط رقم {$installment->installment_number} بمبلغ " . number_format($paymentAmount, 0) . " د.ع من أصل " . number_format($installment->amount, 0) . " د.ع بواسطة {$userName} (المتبقي " . number_format($shortfall, 0) . " د.ع تم إضافته للقسط الأخير)",
                    'amount' => $paymentAmount,
                ]);

                // Find last unpaid installment
                $lastInstallment = InstallmentSchedule::where('invoice_id', $invoice->id)
                    ->where('status', 'unpaid')
                    ->orderBy('installment_number', 'desc')
                    ->first();

                if ($lastInstallment && $lastInstallment->id !== $installment->id) {
                    $lastInstallment->amount += $shortfall;
                    $lastInstallment->notes = "Added shortfall of " . number_format($shortfall, 0) . " IQD from Installment #{$installment->installment_number}";
                    $lastInstallment->save();

                    // Log shortfall added to last installment
                    InvoiceActivityLog::create([
                        'invoice_id' => $invoice->id,
                        'installment_schedule_id' => $lastInstallment->id,
                        'user_id' => Auth::id(),
                        'action_type' => 'shortfall_added',
                        'description' => "تمت إضافة المبلغ المتبقي " . number_format($shortfall, 0) . " د.ع من القسط رقم {$installment->installment_number} إلى القسط الأخير رقم {$lastInstallment->installment_number}",
                        'amount' => $shortfall,
                    ]);
                }
            }

            // Update invoice totals (include deposit in paid amount)
            $totalPaidFromInstallments = $invoice->installmentSchedules()->sum('paid_amount');
            $invoice->paid_amount = $totalPaidFromInstallments + ($invoice->deposit_amount ?? 0);
            $invoice->remaining_amount = $invoice->total_amount - $invoice->paid_amount;

            if ($invoice->remaining_amount <= 0) {
                $invoice->payment_status = 'paid';
                $invoice->is_fully_paid = true;
            } else if ($invoice->paid_amount > 0) {
                $invoice->payment_status = 'partial';
                $invoice->is_fully_paid = false;
            } else {
                $invoice->payment_status = 'unpaid';
                $invoice->is_fully_paid = false;
            }

            $invoice->save();

            // Record payment in treasury
            app(TreasuryService::class)->recordTransaction(
                'income',
                'installment',
                $paymentAmount,
                "Installment payment for Invoice #{$invoice->invoice_number}",
                $invoice
            );

            DB::commit();

            return response()->json([
                'status' => 'ok',
                'msg' => 'تم تسجيل الدفع بنجاح',
                'invoice' => $invoice->fresh(['installmentSchedules']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to process payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getActivityLogs($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            // Check if user has access to this invoice
            if ($invoice->merchant_id !== Auth::user()->merchant_id) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Unauthorized access',
                ], 403);
            }

            $activityLogs = InvoiceActivityLog::where('invoice_id', $id)
                ->with(['user', 'installmentSchedule'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'ok',
                'activity_logs' => $activityLogs,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to fetch activity logs: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function print($id)
    {
        try {
            // Load invoice with all relationships
            $invoice = Invoice::with(['customer', 'items', 'installmentSchedules', 'createdBy'])
                ->findOrFail($id);

            // Check if user has access to this invoice
            if ($invoice->merchant_id !== Auth::user()->merchant_id) {
                abort(403, 'Unauthorized access to this invoice');
            }

            // Get merchant information
            $merchant = Auth::user()->merchant;

            // Get installments
            $installments = $invoice->installmentSchedules()->orderBy('installment_number')->get();

            // Return the print view
            return view('pages.invoice-print', compact('invoice', 'merchant', 'installments'));

        } catch (\Exception $e) {
            abort(404, 'Invoice not found');
        }
    }
}
