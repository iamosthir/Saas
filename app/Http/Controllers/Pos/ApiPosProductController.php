<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Services\Pos\PosInventoryService;
use App\Services\Pos\PosService;
use Illuminate\Http\Request;

class ApiPosProductController extends Controller
{
    protected PosService $posService;
    protected PosInventoryService $inventoryService;

    public function __construct(PosService $posService, PosInventoryService $inventoryService)
    {
        $this->posService = $posService;
        $this->inventoryService = $inventoryService;
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $query = $request->get('q', '');
        $limit = $request->get('limit', 20);

        if (strlen($query) < 1) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $products = $this->posService->searchProducts($merchantId, $query, $limit);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Scan barcode
     */
    public function scanBarcode($barcode)
    {
        $merchantId = auth()->user()->merchant_id;

        $result = $this->posService->findByBarcode($merchantId, $barcode);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * Check stock availability
     */
    public function checkStock(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;
        $variationId = $request->get('variation_id');
        $quantity = $request->get('quantity', 1);

        $product = Product::where('merchant_id', $merchantId)->findOrFail($id);

        $currentStock = $this->inventoryService->getCurrentStock($id, $variationId);
        $hasStock = $this->inventoryService->hasStock($id, $variationId, $quantity);

        return response()->json([
            'success' => true,
            'data' => [
                'product_id' => $id,
                'variation_id' => $variationId,
                'current_stock' => $currentStock,
                'requested_quantity' => $quantity,
                'available' => $hasStock,
                'low_stock_threshold' => $product->low_stock_threshold,
                'is_low_stock' => $currentStock <= $product->low_stock_threshold,
            ],
        ]);
    }

    /**
     * Get product with variations for POS
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $product = Product::where('merchant_id', $merchantId)
            ->with(['variations', 'category'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Get popular products (frequently sold)
     */
    public function popular(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $limit = $request->get('limit', 12);

        // Get products that appear most frequently in completed sales
        $popularProductIds = \DB::table('pos_sale_items')
            ->join('pos_sales', 'pos_sale_items.pos_sale_id', '=', 'pos_sales.id')
            ->where('pos_sales.merchant_id', $merchantId)
            ->where('pos_sales.status', 'completed')
            ->select('pos_sale_items.product_id', \DB::raw('COUNT(*) as sale_count'))
            ->groupBy('pos_sale_items.product_id')
            ->orderBy('sale_count', 'desc')
            ->limit($limit)
            ->pluck('product_id');

        $products = Product::where('merchant_id', $merchantId)
            ->whereIn('id', $popularProductIds)
            ->with('variations')
            ->get()
            ->sortBy(function ($product) use ($popularProductIds) {
                return array_search($product->id, $popularProductIds->toArray());
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Get products by category
     */
    public function byCategory(Request $request, $categoryId)
    {
        $merchantId = auth()->user()->merchant_id;
        $limit = $request->get('limit', 50);

        $products = Product::where('merchant_id', $merchantId)
            ->where('category_id', $categoryId)
            ->with('variations')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
