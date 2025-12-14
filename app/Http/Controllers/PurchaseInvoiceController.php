<?php
namespace App\Http\Controllers;

use App\Models\CustomerSaleInvoice;
use App\Models\ProductVariation;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id'    => 'required|exists:suppliers,id',
            'note'           => 'nullable|string',
            'products'       => 'required|array',
            'products.*.product_id'   => 'required|integer',
            'products.*.variant_id'   => 'required|integer',
            'products.*.qnt'          => 'required|integer|min:1',
            'products.*.product_name' => 'nullable|string',
            'products.*.variant_name' => 'nullable|string',
            'products.*.price'        => 'nullable|numeric',
            'payment_status' => 'required|string',
            'order_status'   => 'required|string',
        ]);

        // Calculate average price for ALL products in this invoice
        $totalQty = 0;
        $totalCost = 0;
        foreach ($data['products'] as $p) {
            $qty = $p['qnt'];
            $price = $p['price'] ?? 0;
            $totalQty += $qty;
            $totalCost += $qty * $price;
        }
        $avgPrice = $totalQty ? round($totalCost / $totalQty, 2) : 0;

        // Prepare products for saving
        $total_price = 0;
        $products = [];

        foreach ($data['products'] as $product) {
            $variation = ProductVariation::where('id', $product['variant_id'])
                ->where('product_id', $product['product_id'])
                ->first();

            if (!$variation) {
                return response()->json(['status' => 'error', 'msg' => 'Product variation not found'], 422);
            }

            $line_total = $avgPrice * $product['qnt'];
            $total_price += $line_total;

            // *** Increase the quantity column ***
            $variation->quantity += $product['qnt'];
            $variation->save();

            $products[] = [
                'product_id'    => $product['product_id'],
                'product_name'  => $product['product_name'] ?? null,
                'variant_id'    => $product['variant_id'],
                'variant_name'  => $product['variant_name'] ?? null,
                'qnt'           => $product['qnt'],
                'unit_price'    => $product['price'] ?? $variation->price,
                'average_price' => $avgPrice,
                'total_price'   => $line_total,
            ];
        }


        $invoice = PurchaseInvoice::create([
            'supplier_id'    => $data['supplier_id'],
            'note'           => $data['note'] ?? null,
            'products'       => json_encode($products),
            'total_price'    => $total_price,
            'payment_status' => $data['payment_status'],
            'order_status'   => $data['order_status'],
            'merchant_id'    => auth()->user()->merchant_id,
        ]);

        // Update all included ProductVariation's average_price to the calculated avgPrice
        $variantIds = array_unique(array_column($data['products'], 'variant_id'));
        ProductVariation::whereIn('id', $variantIds)->update(['average_price' => $avgPrice]);

        return response()->json(['status' => 'ok', 'data' => $invoice]);
    }






    // List all invoices (add pagination as needed)
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $query = PurchaseInvoice::where('merchant_id', $merchantId);

        // Filter by from_date and to_date if provided
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Eager load supplier name and payments
        $query->with(['supplier:id,name', 'payments']);

        $invoices = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate total purchases in the current month (regardless of filter)
        $now = now();
        $total_purchases_month = PurchaseInvoice::where('merchant_id', $merchantId)
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total_price');

        // Add supplier_name and total_paid to each item
        $invoices->getCollection()->transform(function ($item) {
            $item->supplier_name = $item->supplier->name ?? null;
            // total_paid is the sum of all related payment amounts
            $item->total_paid = $item->payments->sum('amount');
            return $item;
        });

        $result = $invoices->toArray();
        $result['total_purchases_month'] = $total_purchases_month;

        return response()->json($result);
    }



    // Show single invoice
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;
        $invoice = PurchaseInvoice::where('merchant_id', $merchantId)
            ->with('supplier')
            ->findOrFail($id);
        return response()->json($invoice);
    }

    public function profitLoss(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        // Purchases total
        $purchaseQuery = PurchaseInvoice::where('merchant_id', $merchantId);
        if ($from_date) {
            $purchaseQuery->whereDate('created_at', '>=', $from_date);
        }
        if ($to_date) {
            $purchaseQuery->whereDate('created_at', '<=', $to_date);
        }
        $purchases = $purchaseQuery->sum('total_price');

        // Sales total
        $salesQuery = CustomerSaleInvoice::where('merchant_id', $merchantId);
        if ($from_date) {
            $salesQuery->whereDate('created_at', '>=', $from_date);
        }
        if ($to_date) {
            $salesQuery->whereDate('created_at', '<=', $to_date);
        }
        $sales = $salesQuery->sum('total_price');

        // Profit/Loss
        $profit_loss = $sales - $purchases;

        return response()->json([
            'purchases' => $purchases,
            'sales' => $sales,
            'profit_loss' => $profit_loss,
        ]);
    }

    public function invoice($id)
    {
        $merchantId = auth()->user()->merchant_id;
        $invoice = PurchaseInvoice::where('merchant_id', $merchantId)
            ->with("supplier")
            ->findOrFail($id);
        $merchant = auth()->user()->merchant;
        return view("pages.purchase-print-invoice",compact("invoice", "merchant"));
    }

}
