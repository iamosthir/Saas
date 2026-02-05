<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Pos\PosSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPosCustomerController extends Controller
{
    /**
     * Search customers
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $query = $request->get('q', '');
        $limit = $request->get('limit', 20);

        $customers = Customer::where('merchant_id', $merchantId)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQ) use ($query) {
                    $subQ->where('customer_name', 'like', "%{$query}%")
                        ->orWhere('phone1', 'like', "%{$query}%")
                        ->orWhere('phone2', 'like', "%{$query}%");
                });
            })
            ->orderBy('customer_name')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customers,
        ]);
    }

    /**
     * Quick create customer from POS
     */
    public function store(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if customer with phone already exists
        $existing = Customer::where('merchant_id', $merchantId)
            ->where('phone1', $request->phone1)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => 'Customer already exists',
                'data' => $existing,
                'is_existing' => true,
            ]);
        }

        $customer = Customer::create([
            'merchant_id' => $merchantId,
            'customer_name' => $request->customer_name,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'state' => $request->state,
            'city' => $request->city,
            'customer_link' => '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'data' => $customer,
            'is_existing' => false,
        ]);
    }

    /**
     * Get customer details
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $customer = Customer::where('merchant_id', $merchantId)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    /**
     * Get customer purchase history
     */
    public function purchaseHistory(Request $request, $id)
    {
        $merchantId = auth()->user()->merchant_id;
        $limit = $request->get('limit', 20);

        $customer = Customer::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $sales = PosSale::where('merchant_id', $merchantId)
            ->where('customer_id', $id)
            ->where('status', 'completed')
            ->with(['items', 'payments'])
            ->orderBy('completed_at', 'desc')
            ->limit($limit)
            ->get();

        $summary = [
            'total_purchases' => $sales->count(),
            'total_spent' => $sales->sum('total_amount'),
            'average_purchase' => $sales->count() > 0 ? $sales->avg('total_amount') : 0,
            'last_purchase' => $sales->first()?->completed_at,
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'customer' => $customer,
                'summary' => $summary,
                'sales' => $sales,
            ],
        ]);
    }

    /**
     * Find customer by phone
     */
    public function findByPhone(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $phone = $request->get('phone');

        if (!$phone) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number is required',
            ], 422);
        }

        $customer = Customer::where('merchant_id', $merchantId)
            ->where(function ($q) use ($phone) {
                $q->where('phone1', $phone)
                    ->orWhere('phone2', $phone);
            })
            ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }
}
