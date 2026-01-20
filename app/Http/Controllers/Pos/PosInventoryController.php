<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Pos\PosInventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PosInventoryController extends Controller
{
    protected PosInventoryService $inventoryService;

    public function __construct(PosInventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Adjust stock manually
     */
    public function adjust(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_variation_id' => 'nullable|exists:product_variations,id',
            'quantity' => 'required|integer',
            'unit_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Verify product belongs to merchant
        $product = Product::where('merchant_id', $merchantId)
            ->findOrFail($request->product_id);

        try {
            $movement = $this->inventoryService->adjustStock(
                $merchantId,
                $request->product_id,
                $request->product_variation_id,
                $request->quantity,
                $request->unit_cost,
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock adjusted successfully',
                'data' => [
                    'movement' => $movement,
                    'new_stock' => $this->inventoryService->getCurrentStock(
                        $request->product_id,
                        $request->product_variation_id
                    ),
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
     * Get inventory movements
     */
    public function movements(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $productId = $request->get('product_id');
        $limit = $request->get('limit', 50);

        $movements = $this->inventoryService->getMovements($merchantId, $productId, $limit);

        return response()->json([
            'success' => true,
            'data' => $movements,
        ]);
    }

    /**
     * Get low stock products
     */
    public function lowStock()
    {
        $merchantId = auth()->user()->merchant_id;

        $products = $this->inventoryService->getLowStockProducts($merchantId);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Get stock level for a product
     */
    public function stockLevel(Request $request, $productId)
    {
        $merchantId = auth()->user()->merchant_id;
        $variationId = $request->get('variation_id');

        // Verify product belongs to merchant
        $product = Product::where('merchant_id', $merchantId)
            ->with('variations')
            ->findOrFail($productId);

        $stockData = [
            'product_id' => $productId,
            'product_name' => $product->name,
            'total_stock' => $product->total_stock,
            'low_stock_threshold' => $product->low_stock_threshold,
            'is_low_stock' => $product->total_stock <= $product->low_stock_threshold,
            'variations' => [],
        ];

        foreach ($product->variations as $variation) {
            $stockData['variations'][] = [
                'id' => $variation->id,
                'name' => $variation->var_name,
                'stock' => $variation->quantity,
                'sku' => $variation->sku,
                'barcode' => $variation->barcode,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $stockData,
        ]);
    }
}
