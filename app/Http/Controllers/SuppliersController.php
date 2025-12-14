<?php

namespace App\Http\Controllers;

use App\Models\PurchasePayments;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    // List
    public function list(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $suppliers = Suppliers::where('merchant_id', $merchantId)
            ->orderBy("created_at", "desc")
            ->paginate(20);

        // Attach total_debts to each supplier
        $suppliers->getCollection()->transform(function ($row) {
            $row->total_debts = $this->calculateSupplierDebt($row->id);
            return $row;
        });

        return response()->json($suppliers);
    }

    // Helper function to calculate total debts for a supplier
    protected function calculateSupplierDebt($supplier_id)
    {
        // Get all invoices for this supplier
        $invoices = \App\Models\PurchaseInvoice::where('supplier_id', $supplier_id)->get();

        // Sum total_price of invoices
        $total_price = $invoices->sum('total_price');

        // Get all invoice IDs
        $invoiceIds = $invoices->pluck('id');

        // Sum all payments for these invoices
        $total_paid = PurchasePayments::whereIn('invoice_id', $invoiceIds)->sum('amount');

        // Return debts (will be 0 if none)
        return max(0, $total_price - $total_paid);
    }


    // Store (Create)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'company_name'   => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:255',
            'notes'          => 'nullable|string',
        ]);

        $validated['merchant_id'] = auth()->user()->merchant_id;
        $supplier = Suppliers::create($validated);

        return response()->json([
            'status' => 'ok',
            'msg'    => 'تمت الإضافة بنجاح',
            'data'   => $supplier,
        ]);
    }

    // Update
    public function update(Request $request)
    {
        $validated = $request->validate([
            'supplierId'     => 'required|exists:suppliers,id',
            'name'           => 'required|string|max:255',
            'company_name'   => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:255',
            'notes'          => 'nullable|string',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $supplier = Suppliers::where('id', $request->supplierId)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $supplier->update($validated);

        return response()->json([
            'status' => 'ok',
            'msg'    => 'تم التحديث بنجاح',
            'data'   => $supplier,
        ]);
    }

    // Delete
    public function delete(Request $request)
    {
        $request->validate([
            'supplierId' => 'required|exists:suppliers,id',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $supplier = Suppliers::where('id', $request->supplierId)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $supplier->delete();

        return response()->json([
            'status' => 'ok',
            'msg'    => 'تم الحذف بنجاح'
        ]);
    }
}
