<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\PosSale;
use App\Services\Pos\PosPaymentService;
use App\Services\Pos\PosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPosPaymentController extends Controller
{
    protected PosService $posService;
    protected PosPaymentService $paymentService;

    public function __construct(PosService $posService, PosPaymentService $paymentService)
    {
        $this->posService = $posService;
        $this->paymentService = $paymentService;
    }

    /**
     * Process payment(s) for a sale
     */
    public function process(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'sale_id' => 'required|exists:pos_sales,id',
            'payments' => 'required|array|min:1',
            'payments.*.payment_method' => 'required|in:cash,card,wallet,bank_transfer,other',
            'payments.*.amount' => 'required|numeric|min:0.01',
            'payments.*.tendered_amount' => 'nullable|numeric|min:0',
            'payments.*.reference_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $sale = PosSale::where('merchant_id', $merchantId)
            ->whereIn('status', ['draft', 'parked'])
            ->findOrFail($request->sale_id);

        try {
            $completedSale = $this->posService->completeSale($sale, $request->payments);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'data' => [
                    'sale' => $completedSale,
                    'payment_summary' => $this->paymentService->getPaymentSummary($completedSale),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get payment summary for a sale
     */
    public function summary($saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->with('payments')
            ->findOrFail($saleId);

        return response()->json([
            'success' => true,
            'data' => $this->paymentService->getPaymentSummary($sale),
        ]);
    }

    /**
     * Get quick cash amounts for a sale
     */
    public function quickAmounts($saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->findOrFail($saleId);

        $remainingAmount = $this->paymentService->getRemainingAmount($sale);

        return response()->json([
            'success' => true,
            'data' => [
                'remaining' => $remainingAmount,
                'quick_amounts' => $this->paymentService->getQuickCashAmounts($remainingAmount),
            ],
        ]);
    }
}
