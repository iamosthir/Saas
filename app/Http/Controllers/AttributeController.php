<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    // List all attributes
    public function index()
    {
        $merchantId = auth()->user()->merchant_id;
        $attributes = Attribute::where('merchant_id', $merchantId)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($attributes);
    }

    // Store a new attribute
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['merchant_id'] = auth()->user()->merchant_id;
        $attribute = Attribute::create($validated);

        return response()->json([
            'status' => 'ok',
            'data' => $attribute,
            'msg' => 'Attribute created successfully'
        ]);
    }

    // Update an existing attribute
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'        => 'required|exists:attributes,id',
            'name'      => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $attribute = Attribute::where('id', $validated['id'])
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $attribute->update($validated);

        return response()->json([
            'status' => 'ok',
            'data' => $attribute,
            'msg' => 'Attribute updated successfully'
        ]);
    }

    // Delete an attribute
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:attributes,id'
        ]);

        $merchantId = auth()->user()->merchant_id;
        $attribute = Attribute::where('id', $request->id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $attribute->delete();

        return response()->json([
            'status' => 'ok',
            'msg' => 'Attribute deleted successfully'
        ]);
    }
}
