<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Get suppliers list
     */
    public function index()
    {
        $suppliers = Suppliers::orderBy('name')
            ->paginate(20);

        return response()->json($suppliers);
    }

    /**
     * Get suppliers dropdown (for select/multiselect)
     */
    public function dropdown()
    {
        $suppliers = Suppliers::select('id', 'name', 'phone', 'address', 'contact_person', 'company_name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json($suppliers);
    }

    /**
     * Store new supplier
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $supplier = Suppliers::create($data);

        return response()->json([
            'status' => 'ok',
            'msg' => 'Supplier added successfully.',
            'data' => $supplier,
        ]);
    }

    /**
     * Update supplier
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $supplier = Suppliers::findOrFail($id);
        $supplier->update($data);

        return response()->json([
            'status' => 'ok',
            'msg' => 'Supplier updated successfully.',
            'data' => $supplier,
        ]);
    }

    /**
     * Delete supplier
     */
    public function delete($id)
    {
        $supplier = Suppliers::findOrFail($id);
        $supplier->delete();

        return response()->json([
            'status' => 'ok',
            'msg' => 'Supplier deleted successfully.',
        ]);
    }
}
