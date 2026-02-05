<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\PosSale;
use App\Models\Pos\PosSaleItem;
use App\Services\Pos\PosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPosSaleController extends Controller
{
    protected PosService $posService;
    protected \App\Services\Pos\PosRefundService $refundService;

    public function __construct(
        PosService $posService,
        \App\Services\Pos\PosRefundService $refundService
    ) {
        $this->posService = $posService;
        $this->refundService = $refundService;
    }

    /**
     * List sales with filters
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $query = PosSale::where('merchant_id', $merchantId)
            ->with(['customer', 'createdBy', 'items'])
            ->orderBy('created_at', 'desc');

        // Status filter - exclude draft sales by default (sales history should show completed/voided/parked)
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        } else {
            // Default: show all except draft
            $query->whereIn('status', ['completed', 'voided', 'parked']);
        }

        // Date range
        if ($request->has('from_date') && $request->from_date !== '') {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date !== '') {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Pagination
        $perPage = $request->get('per_page', 20);
        $sales = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $sales,
        ]);
    }

    /**
     * Create new sale (draft)
     */
    public function store(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = $this->posService->createSale(
            $merchantId,
            $request->customer_id
        );

        // Add items if provided
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $this->posService->addItem($sale, $itemData);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $sale->fresh(['items', 'customer']),
        ]);
    }

    /**
     * Get sale details
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->with(['items.product', 'items.productVariation', 'payments', 'customer', 'createdBy'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $sale,
        ]);
    }

    /**
     * Update sale (add/remove items, apply discount, etc.)
     */
    public function update(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->where('status', 'draft')
            ->findOrFail($id);

        // Update customer
        if ($request->has('customer_id')) {
            $this->posService->setCustomer($sale, $request->customer_id);
        }

        // Update discount
        if ($request->has('discount_type') || $request->has('discount_amount')) {
            $this->posService->applySaleDiscount(
                $sale,
                $request->discount_type,
                $request->discount_amount ?? 0
            );
        }

        // Update notes
        if ($request->has('notes')) {
            $sale->notes = $request->notes;
            $sale->save();
        }

        return response()->json([
            'success' => true,
            'data' => $sale->fresh(['items', 'customer']),
        ]);
    }

    /**
     * Add item to sale
     */
    public function addItem(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_variation_id' => 'nullable|exists:product_variations,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $sale = PosSale::where('merchant_id', $merchantId)
            ->whereIn('status', ['draft', 'parked'])
            ->findOrFail($id);

        $item = $this->posService->addItem($sale, $request->all());

        return response()->json([
            'success' => true,
            'data' => [
                'item' => $item,
                'sale' => $sale->fresh(['items', 'customer']),
            ],
        ]);
    }

    /**
     * Update item quantity
     */
    public function updateItem(Request $request, $saleId, $itemId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->whereIn('status', ['draft', 'parked'])
            ->findOrFail($saleId);

        $item = PosSaleItem::where('pos_sale_id', $sale->id)
            ->findOrFail($itemId);

        if ($request->has('quantity')) {
            $this->posService->updateItemQuantity($item, $request->quantity);
        }

        if ($request->has('discount_type') || $request->has('discount_amount')) {
            $this->posService->applyItemDiscount(
                $item,
                $request->discount_type,
                $request->discount_amount ?? 0
            );
        }

        return response()->json([
            'success' => true,
            'data' => $sale->fresh(['items', 'customer']),
        ]);
    }

    /**
     * Remove item from sale
     */
    public function removeItem($saleId, $itemId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->whereIn('status', ['draft', 'parked'])
            ->findOrFail($saleId);

        $item = PosSaleItem::where('pos_sale_id', $sale->id)
            ->findOrFail($itemId);

        $this->posService->removeItem($item);

        return response()->json([
            'success' => true,
            'data' => $sale->fresh(['items', 'customer']),
        ]);
    }

    /**
     * Complete sale with payment
     */
    public function complete(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'payments' => 'required|array|min:1',
            'payments.*.payment_method' => 'required|in:cash,card,wallet,bank_transfer,other',
            'payments.*.amount' => 'required|numeric|min:0.01',
            'payments.*.tendered_amount' => 'nullable|numeric|min:0',
            'payments.*.reference_number' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $sale = PosSale::where('merchant_id', $merchantId)
            ->whereIn('status', ['draft', 'parked'])
            ->findOrFail($id);

        try {
            $completedSale = $this->posService->completeSale($sale, $request->payments);

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully',
                'data' => $completedSale,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Park sale for later
     */
    public function park(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->where('status', 'draft')
            ->findOrFail($id);

        $this->posService->parkSale($sale, $request->park_name);

        return response()->json([
            'success' => true,
            'message' => 'Sale parked successfully',
            'data' => $sale,
        ]);
    }

    /**
     * Resume parked sale
     */
    public function unpark($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->where('status', 'parked')
            ->findOrFail($id);

        $this->posService->unparkSale($sale);

        return response()->json([
            'success' => true,
            'message' => 'Sale resumed',
            'data' => $sale->fresh(['items', 'customer']),
        ]);
    }

    /**
     * Void a completed sale
     */
    public function void($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->where('status', 'completed')
            ->findOrFail($id);

        try {
            $this->posService->voidSale($sale);

            return response()->json([
                'success' => true,
                'message' => 'Sale voided successfully',
                'data' => $sale,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get parked sales
     */
    public function getParkedSales()
    {
        $merchantId = auth()->user()->merchant_id;
        $sales = $this->posService->getParkedSales($merchantId);

        return response()->json([
            'success' => true,
            'data' => $sales,
        ]);
    }

    /**
     * Get draft sales (active carts)
     */
    public function getDrafts()
    {
        $merchantId = auth()->user()->merchant_id;
        $sales = $this->posService->getDraftSales($merchantId);

        return response()->json([
            'success' => true,
            'data' => $sales,
        ]);
    }

    /**
     * Delete a draft/parked sale
     */
    public function destroy($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->whereIn('status', ['draft', 'parked'])
            ->findOrFail($id);

        $sale->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sale deleted',
        ]);
    }

    /**
     * Get refundable items for a sale
     */
    public function getRefundableItems($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->with('items')
            ->findOrFail($id);

        $items = $this->refundService->getRefundableItems($sale);

        return response()->json([
            'success' => true,
            'data' => [
                'can_refund' => $this->refundService->canRefund($sale),
                'items' => $items,
            ],
        ]);
    }

    /**
     * Process full refund
     */
    public function refundFull(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $sale = PosSale::where('merchant_id', $merchantId)
            ->with(['items', 'payments'])
            ->findOrFail($id);

        try {
            $refundSale = $this->refundService->processFullRefund($sale, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Full refund processed successfully',
                'data' => $refundSale,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Process partial refund (specific items)
     */
    public function refundPartial(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:pos_sale_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $sale = PosSale::where('merchant_id', $merchantId)
            ->with(['items', 'payments'])
            ->findOrFail($id);

        try {
            $refundSale = $this->refundService->processPartialRefund(
                $sale,
                $request->items,
                $request->all()
            );

            return response()->json([
                'success' => true,
                'message' => 'Partial refund processed successfully',
                'data' => $refundSale,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
