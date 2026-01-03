<?php

namespace App\Http\Controllers;

use App\Models\CustomerSaleInvoice;
use App\Models\Invoice;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class CustomerSaleInvoiceController extends Controller
{

    // List all sales invoices (add pagination as needed)
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        // Query from invoices table (the main invoice system)
        $query = Invoice::where('merchant_id', $merchantId);

        // Filter by from_date and to_date if provided
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Eager load customer and items
        $query->with(['customer:id,customer_name', 'items']);

        $invoices = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate total sales in the current month (regardless of filter)
        $now = now();
        $total_sales_month = Invoice::where('merchant_id', $merchantId)
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total_amount');

        // Transform data to match the frontend expectations
        $invoices->getCollection()->transform(function ($item) {
            // Format products as JSON string for compatibility
            $products = $item->items->map(function ($invoiceItem) {
                return [
                    'product_id' => $invoiceItem->product_id,
                    'product_name' => $invoiceItem->product_name,
                    'variant_id' => $invoiceItem->product_variation_id,
                    'variant_name' => $invoiceItem->variation_name ?? 'N/A',
                    'qnt' => $invoiceItem->quantity,
                    'unit_price' => $invoiceItem->custom_price,
                    'total_price' => $invoiceItem->line_total,
                ];
            })->toArray();

            return [
                'id' => $item->id,
                'customer_name' => $item->customer->customer_name ?? 'N/A',
                'products' => json_encode($products),
                'total_price' => $item->total_amount,
                'total_paid' => $item->paid_amount,
                'payment_status' => $item->payment_status,
                'order_status' => $item->payment_type === 'installment' ? 'تقسيط' : 'دفع كامل',
                'created_at' => $item->created_at,
                'payments' => [], // Can be expanded if needed
            ];
        });

        $result = $invoices->toArray();
        $result['total_sales_month'] = $total_sales_month;

        return response()->json($result);
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'note'           => 'nullable|string',
            'products'       => 'required|array',
            'products.*.product_id'   => 'required|integer',
            'products.*.variant_id'   => 'required|integer',
            'products.*.qnt'          => 'required|integer|min:1',
            // Optional fields if sent from frontend
            'products.*.product_name' => 'nullable|string',
            'products.*.variant_name' => 'nullable|string',
            'payment_status' => 'required|string',
            'order_status'   => 'required|string',
        ]);

        $total_price = 0;
        $products = [];

        foreach ($data['products'] as $product) {
            // Fetch price from ProductVariation
            $variation = ProductVariation::where('id', $product['variant_id'])
                ->where('product_id', $product['product_id'])
                ->first();

            if (!$variation) {
                return response()->json(['status' => 'error', 'msg' => 'Product variation not found'], 422);
            }

            $line_total = $variation->price * $product['qnt'];
            $total_price += $line_total;

            // Include product_name and variant_name if sent from frontend
            $products[] = [
                'product_id'    => $product['product_id'],
                'product_name'  => $product['product_name'] ?? null,
                'variant_id'    => $product['variant_id'],
                'variant_name'  => $product['variant_name'] ?? null,
                'qnt'           => $product['qnt'],
                'unit_price'    => $variation->price,
                'total_price'   => $line_total,
            ];
        }

        $invoice = CustomerSaleInvoice::create([
            'customer_id'    => $data['customer_id'],
            'note'           => $data['note'] ?? null,
            'products'       => json_encode($products),
            'total_price'    => $total_price,
            'payment_status' => $data['payment_status'],
            'order_status'   => $data['order_status'],
            'merchant_id'    => auth()->user()->merchant_id,
        ]);

        return response()->json(['status' => 'ok', 'data' => $invoice]);
    }

    public function invoice($id)
    {
        $merchantId = auth()->user()->merchant_id;
        $invoice = CustomerSaleInvoice::where('merchant_id', $merchantId)
            ->with("customer")
            ->findOrFail($id);
        $merchant = auth()->user()->merchant;
        return view("pages.sales-print-invoice",compact("invoice", "merchant"));
    }

}
