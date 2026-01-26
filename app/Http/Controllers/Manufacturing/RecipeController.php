<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\ProductRecipe;
use App\Models\Manufacturing\RecipeIngredient;
use App\Services\Manufacturing\ProductionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    protected ProductionService $productionService;

    public function __construct(ProductionService $productionService)
    {
        $this->productionService = $productionService;
    }

    /**
     * Get all recipes
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $query = ProductRecipe::where('merchant_id', $merchantId)
            ->with(['product', 'productVariation', 'ingredients.rawMaterial', 'ingredients.unit']);

        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('active_only') && $request->active_only) {
            $query->active();
        }

        $perPage = $request->get('per_page', 20);
        $recipes = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $recipes->items(),
            'pagination' => [
                'total' => $recipes->total(),
                'per_page' => $recipes->perPage(),
                'current_page' => $recipes->currentPage(),
                'last_page' => $recipes->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new recipe
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'product_variation_id' => 'nullable|exists:product_variations,id',
            'output_quantity' => 'required|numeric|min:0.0001',
            'labor_cost' => 'nullable|numeric|min:0',
            'overhead_cost' => 'nullable|numeric|min:0',
            'instructions' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.raw_material_id' => 'required|exists:raw_materials,id',
            'ingredients.*.unit_id' => 'required|exists:units_of_measure,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.0001',
            'ingredients.*.waste_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $merchantId = auth()->user()->merchant_id;

        return DB::transaction(function () use ($request, $merchantId) {
            $recipe = ProductRecipe::create([
                'merchant_id' => $merchantId,
                'name' => $request->name,
                'product_id' => $request->product_id,
                'product_variation_id' => $request->product_variation_id,
                'output_quantity' => $request->output_quantity,
                'labor_cost' => $request->labor_cost ?? 0,
                'overhead_cost' => $request->overhead_cost ?? 0,
                'instructions' => $request->instructions,
                'prep_time_minutes' => $request->prep_time_minutes,
                'is_active' => true,
            ]);

            // Add ingredients
            foreach ($request->ingredients as $index => $ingredient) {
                RecipeIngredient::create([
                    'recipe_id' => $recipe->id,
                    'raw_material_id' => $ingredient['raw_material_id'],
                    'unit_id' => $ingredient['unit_id'],
                    'quantity' => $ingredient['quantity'],
                    'waste_percentage' => $ingredient['waste_percentage'] ?? 0,
                    'sort_order' => $index,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Recipe created successfully',
                'data' => $recipe->load(['product', 'productVariation', 'ingredients.rawMaterial', 'ingredients.unit']),
            ]);
        });
    }

    /**
     * Get a single recipe
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $recipe = ProductRecipe::where('merchant_id', $merchantId)
            ->with(['product', 'productVariation', 'ingredients.rawMaterial', 'ingredients.unit'])
            ->findOrFail($id);

        // Add calculated costs
        $recipe->calculated_material_cost = $recipe->calculateMaterialCost();
        $recipe->calculated_total_cost = $recipe->calculateTotalCost();
        $recipe->calculated_unit_cost = $recipe->calculateUnitCost();
        $recipe->can_produce = $recipe->canProduce();
        $recipe->max_batches = $recipe->getMaxProducibleBatches();

        return response()->json([
            'success' => true,
            'data' => $recipe,
        ]);
    }

    /**
     * Update a recipe
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'output_quantity' => 'required|numeric|min:0.0001',
            'labor_cost' => 'nullable|numeric|min:0',
            'overhead_cost' => 'nullable|numeric|min:0',
            'instructions' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.raw_material_id' => 'required|exists:raw_materials,id',
            'ingredients.*.unit_id' => 'required|exists:units_of_measure,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.0001',
            'ingredients.*.waste_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $recipe = ProductRecipe::where('merchant_id', $merchantId)
            ->findOrFail($id);

        return DB::transaction(function () use ($request, $recipe) {
            $recipe->update([
                'name' => $request->name,
                'output_quantity' => $request->output_quantity,
                'labor_cost' => $request->labor_cost ?? $recipe->labor_cost,
                'overhead_cost' => $request->overhead_cost ?? $recipe->overhead_cost,
                'instructions' => $request->instructions,
                'prep_time_minutes' => $request->prep_time_minutes,
                'is_active' => $request->is_active ?? $recipe->is_active,
            ]);

            // Delete existing ingredients and re-create
            $recipe->ingredients()->delete();

            foreach ($request->ingredients as $index => $ingredient) {
                RecipeIngredient::create([
                    'recipe_id' => $recipe->id,
                    'raw_material_id' => $ingredient['raw_material_id'],
                    'unit_id' => $ingredient['unit_id'],
                    'quantity' => $ingredient['quantity'],
                    'waste_percentage' => $ingredient['waste_percentage'] ?? 0,
                    'sort_order' => $index,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Recipe updated successfully',
                'data' => $recipe->load(['product', 'productVariation', 'ingredients.rawMaterial', 'ingredients.unit']),
            ]);
        });
    }

    /**
     * Delete a recipe
     */
    public function destroy($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $recipe = ProductRecipe::where('merchant_id', $merchantId)
            ->findOrFail($id);

        // Check if recipe has been used in production
        if ($recipe->productionBatches()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete recipe that has been used in production. Consider deactivating it instead.',
            ], 422);
        }

        $recipe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recipe deleted successfully',
        ]);
    }

    /**
     * Check availability for production
     */
    public function checkAvailability(Request $request, $id)
    {
        $multiplier = $request->get('multiplier', 1);

        try {
            $availability = $this->productionService->checkAvailability($id, $multiplier);

            return response()->json([
                'success' => true,
                'data' => $availability,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get recipe for a specific product
     */
    public function getProductRecipe(Request $request, $productId)
    {
        $merchantId = auth()->user()->merchant_id;
        $variationId = $request->get('variation_id');

        $query = ProductRecipe::where('merchant_id', $merchantId)
            ->where('product_id', $productId)
            ->active()
            ->with(['ingredients.rawMaterial', 'ingredients.unit']);

        if ($variationId) {
            $query->where('product_variation_id', $variationId);
        }

        $recipe = $query->first();

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'No active recipe found for this product',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recipe,
        ]);
    }
}
