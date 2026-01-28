<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\ProductionBatch;
use App\Services\Manufacturing\ProductionService;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    protected ProductionService $productionService;

    public function __construct(ProductionService $productionService)
    {
        $this->productionService = $productionService;
    }

    /**
     * Get all production batches
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $query = $this->productionService->getProductionHistory($merchantId, [
            'status' => $request->status,
            'product_id' => $request->product_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        $perPage = $request->get('per_page', 20);
        $batches = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $batches->items(),
            'pagination' => [
                'total' => $batches->total(),
                'per_page' => $batches->perPage(),
                'current_page' => $batches->currentPage(),
                'last_page' => $batches->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new production batch
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:product_recipes,id',
            'multiplier' => 'nullable|numeric|min:0.1|max:1000',
            'notes' => 'nullable|string|max:1000',
            'production_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:production_date',
        ]);

        try {
            $batch = $this->productionService->createBatch(
                $request->recipe_id,
                $request->get('multiplier', 1),
                $request->notes,
                $request->production_date,
                $request->expiry_date
            );

            return response()->json([
                'success' => true,
                'message' => 'Production batch created',
                'data' => $batch,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get a single production batch
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $batch = ProductionBatch::where('merchant_id', $merchantId)
            ->with([
                'recipe',
                'product',
                'productVariation',
                'ingredients.rawMaterial',
                'ingredients.unit',
                'createdBy',
                'completedBy',
            ])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $batch,
        ]);
    }

    /**
     * Update a production batch (only draft/in_progress)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
            'production_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'labor_cost' => 'nullable|numeric|min:0',
            'overhead_cost' => 'nullable|numeric|min:0',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $batch = ProductionBatch::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $batch->update([
            'notes' => $request->notes ?? $batch->notes,
            'production_date' => $request->production_date ?? $batch->production_date,
            'expiry_date' => $request->expiry_date ?? $batch->expiry_date,
            'labor_cost' => $request->labor_cost ?? $batch->labor_cost,
            'overhead_cost' => $request->overhead_cost ?? $batch->overhead_cost,
        ]);

        // Recalculate costs if labor or overhead changed
        if ($request->has('labor_cost') || $request->has('overhead_cost')) {
            $batch->calculateCosts();
            $batch->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Batch updated successfully',
            'data' => $batch->fresh(['recipe', 'product', 'productVariation', 'ingredients']),
        ]);
    }

    /**
     * Delete a production batch (only draft)
     */
    public function destroy($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $batch = ProductionBatch::where('merchant_id', $merchantId)
            ->findOrFail($id);

        if (!$batch->isDraft()) {
            return response()->json([
                'success' => false,
                'message' => 'Only draft batches can be deleted',
            ], 422);
        }

        $batch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Batch deleted successfully',
        ]);
    }

    /**
     * Start production
     */
    public function start($id)
    {
        try {
            $batch = $this->productionService->startProduction($id);

            return response()->json([
                'success' => true,
                'message' => 'Production started',
                'data' => $batch,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Complete production
     */
    public function complete(Request $request, $id)
    {
        $request->validate([
            'actual_quantity' => 'required|numeric|min:0',
            'actual_ingredients' => 'nullable|array',
            'actual_ingredients.*' => 'numeric|min:0',
        ]);

        try {
            $batch = $this->productionService->completeProduction(
                $id,
                $request->actual_quantity,
                $request->actual_ingredients
            );

            return response()->json([
                'success' => true,
                'message' => 'Production completed successfully',
                'data' => $batch,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Cancel production
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $batch = $this->productionService->cancelBatch($id, $request->reason);

            return response()->json([
                'success' => true,
                'message' => 'Production cancelled',
                'data' => $batch,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Clone a completed production batch
     */
    public function clone($id)
    {
        try {
            $batch = $this->productionService->cloneBatch($id);

            return response()->json([
                'success' => true,
                'message' => 'Production batch cloned successfully',
                'data' => $batch,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get production summary report
     */
    public function summary(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $summary = $this->productionService->getProductionSummary(
            $merchantId,
            $request->date_from,
            $request->date_to
        );

        return response()->json([
            'success' => true,
            'data' => $summary,
        ]);
    }
}
