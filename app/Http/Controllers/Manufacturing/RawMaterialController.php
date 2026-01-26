<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\RawMaterial;
use App\Services\Manufacturing\RawMaterialInventoryService;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    protected RawMaterialInventoryService $inventoryService;

    public function __construct(RawMaterialInventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Get all raw materials
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $query = RawMaterial::where('merchant_id', $merchantId)
            ->with(['unit', 'category', 'supplier']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by supplier
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by active status
        if ($request->has('active_only') && $request->active_only) {
            $query->active();
        }

        // Filter by low stock
        if ($request->has('low_stock') && $request->low_stock) {
            $query->lowStock();
        }

        $perPage = $request->get('per_page', 20);
        $materials = $query->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $materials->items(),
            'pagination' => [
                'total' => $materials->total(),
                'per_page' => $materials->perPage(),
                'current_page' => $materials->currentPage(),
                'last_page' => $materials->lastPage(),
            ],
        ]);
    }

    /**
     * Get low stock materials
     */
    public function lowStock()
    {
        $merchantId = auth()->user()->merchant_id;
        $materials = $this->inventoryService->getLowStockMaterials($merchantId);

        return response()->json([
            'success' => true,
            'data' => $materials,
        ]);
    }

    /**
     * Create a new raw material
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units_of_measure,id',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'min_stock_level' => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::create([
            'merchant_id' => $merchantId,
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'description' => $request->description,
            'min_stock_level' => $request->min_stock_level ?? 0,
            'purchase_price' => $request->purchase_price ?? 0,
            'average_price' => $request->purchase_price ?? 0,
            'current_stock' => 0,
            'is_active' => true,
            'track_inventory' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Raw material created successfully',
            'data' => $material->load(['unit', 'category', 'supplier']),
        ]);
    }

    /**
     * Get a single raw material
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::where('merchant_id', $merchantId)
            ->with(['unit', 'category', 'supplier'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $material,
        ]);
    }

    /**
     * Update a raw material
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units_of_measure,id',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'min_stock_level' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $material->update([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'description' => $request->description,
            'min_stock_level' => $request->min_stock_level ?? $material->min_stock_level,
            'is_active' => $request->is_active ?? $material->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Raw material updated successfully',
            'data' => $material->load(['unit', 'category', 'supplier']),
        ]);
    }

    /**
     * Delete a raw material
     */
    public function destroy($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::where('merchant_id', $merchantId)
            ->findOrFail($id);

        // Check if material is used in any recipes
        if ($material->recipeIngredients()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete raw material that is used in recipes',
            ], 422);
        }

        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Raw material deleted successfully',
        ]);
    }

    /**
     * Get movement history for a material
     */
    public function movements($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $movements = $this->inventoryService->getMovementHistory($id);

        return response()->json([
            'success' => true,
            'data' => $movements,
        ]);
    }

    /**
     * Adjust stock for a material
     */
    public function adjust(Request $request, $id)
    {
        $request->validate([
            'new_stock_level' => 'required|numeric|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::where('merchant_id', $merchantId)
            ->findOrFail($id);

        try {
            $movement = $this->inventoryService->adjustStock(
                $merchantId,
                $id,
                $request->new_stock_level,
                $request->unit_cost,
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock adjusted successfully',
                'data' => $movement,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Purchase stock (add inventory)
     */
    public function purchase(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.0001',
            'unit_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $material = RawMaterial::where('merchant_id', $merchantId)
            ->findOrFail($id);

        try {
            $movement = $this->inventoryService->addStock(
                $merchantId,
                $id,
                $request->quantity,
                $request->unit_cost,
                null,
                null,
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock purchased successfully',
                'data' => [
                    'movement' => $movement,
                    'material' => $material->fresh(['unit']),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
