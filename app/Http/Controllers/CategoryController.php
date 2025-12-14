<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        $merchantId = auth()->user()->merchant_id;
        $categories = Category::where('merchant_id', $merchantId)
            ->with('parent', 'children')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($categories);
    }

    // Get all categories in hierarchical structure
    public function tree()
    {
        $merchantId = auth()->user()->merchant_id;
        $categories = Category::where('merchant_id', $merchantId)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order', 'asc')
            ->get();
        return response()->json($categories);
    }

    // Store a new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $validated['merchant_id'] = auth()->user()->merchant_id;
        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        return response()->json([
            'status' => 'ok',
            'data' => $category->load('parent', 'children'),
            'msg' => 'Category created successfully'
        ]);
    }

    // Update an existing category
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $category = Category::where('id', $validated['id'])
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

        // Prevent setting parent to itself or its own children
        if (isset($validated['parent_id']) && $validated['parent_id'] == $category->id) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Category cannot be its own parent'
            ], 422);
        }

        $validated['slug'] = Str::slug($validated['name']);
        $category->update($validated);

        return response()->json([
            'status' => 'ok',
            'data' => $category->load('parent', 'children'),
            'msg' => 'Category updated successfully'
        ]);
    }

    // Delete a category
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id'
        ]);

        $merchantId = auth()->user()->merchant_id;
        $category = Category::where('id', $request->id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

        // Check if category has children
        if ($category->children()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Cannot delete category with subcategories'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'status' => 'ok',
            'msg' => 'Category deleted successfully'
        ]);
    }
}
