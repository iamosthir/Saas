<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\UnitOfMeasure;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Get all units of measure
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $query = UnitOfMeasure::where('merchant_id', $merchantId);

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('active_only') && $request->active_only) {
            $query->active();
        }

        $units = $query->orderBy('category')
            ->orderBy('is_base_unit', 'desc')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $units,
        ]);
    }

    /**
     * Create a new unit of measure
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'category' => 'required|string|in:weight,volume,piece',
            'conversion_factor' => 'required|numeric|min:0.000001',
            'is_base_unit' => 'boolean',
        ]);

        $merchantId = auth()->user()->merchant_id;

        // Check for duplicate symbol
        $exists = UnitOfMeasure::where('merchant_id', $merchantId)
            ->where('symbol', $request->symbol)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'A unit with this symbol already exists',
            ], 422);
        }

        // If setting as base unit, unset other base units in same category
        if ($request->is_base_unit) {
            UnitOfMeasure::where('merchant_id', $merchantId)
                ->where('category', $request->category)
                ->update(['is_base_unit' => false]);
        }

        $unit = UnitOfMeasure::create([
            'merchant_id' => $merchantId,
            'name' => $request->name,
            'symbol' => $request->symbol,
            'category' => $request->category,
            'conversion_factor' => $request->conversion_factor,
            'is_base_unit' => $request->is_base_unit ?? false,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unit created successfully',
            'data' => $unit,
        ]);
    }

    /**
     * Update a unit of measure
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'conversion_factor' => 'required|numeric|min:0.000001',
            'is_base_unit' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $unit = UnitOfMeasure::where('merchant_id', $merchantId)
            ->findOrFail($id);

        // Check for duplicate symbol (excluding current)
        $exists = UnitOfMeasure::where('merchant_id', $merchantId)
            ->where('symbol', $request->symbol)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'A unit with this symbol already exists',
            ], 422);
        }

        // If setting as base unit, unset other base units in same category
        if ($request->is_base_unit && !$unit->is_base_unit) {
            UnitOfMeasure::where('merchant_id', $merchantId)
                ->where('category', $unit->category)
                ->update(['is_base_unit' => false]);
        }

        $unit->update([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'conversion_factor' => $request->conversion_factor,
            'is_base_unit' => $request->is_base_unit ?? $unit->is_base_unit,
            'is_active' => $request->is_active ?? $unit->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unit updated successfully',
            'data' => $unit,
        ]);
    }

    /**
     * Delete a unit of measure
     */
    public function destroy($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $unit = UnitOfMeasure::where('merchant_id', $merchantId)
            ->findOrFail($id);

        // Check if unit is in use
        if ($unit->rawMaterials()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete unit that is in use by raw materials',
            ], 422);
        }

        $unit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unit deleted successfully',
        ]);
    }
}
