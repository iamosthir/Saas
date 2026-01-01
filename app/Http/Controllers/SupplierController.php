<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Get suppliers list
     */
    public function index()
    {
        $merchantId = Auth::user()->merchant_id;

        $suppliers = Supplier::where('merchant_id', $merchantId)
            ->orderBy('supplier_name')
            ->paginate(20);

        return response()->json($suppliers);
    }

    /**
     * Get suppliers dropdown (for select/multiselect)
     */
    public function dropdown()
    {
        $merchantId = Auth::user()->merchant_id;

        $suppliers = Supplier::where('merchant_id', $merchantId)
            ->select('id', 'supplier_name', 'phone', 'address')
            ->orderBy('supplier_name')
            ->get();

        return response()->json($suppliers);
    }

    /**
     * Store new supplier
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $data['merchant_id'] = Auth::user()->merchant_id;
        $supplier = Supplier::create($data);

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
            'supplier_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $merchantId = Auth::user()->merchant_id;
        $supplier = Supplier::where('id', $id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

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
        $merchantId = Auth::user()->merchant_id;
        $supplier = Supplier::where('id', $id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

        $supplier->delete();

        return response()->json([
            'status' => 'ok',
            'msg' => 'Supplier deleted successfully.',
        ]);
    }
}
