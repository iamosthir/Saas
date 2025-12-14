<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    // Fetch expenses with pagination (20 per page)
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $query = Expense::where('merchant_id', $merchantId);

        // Filter by from_date and to_date if provided
        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        // Eager load department name if relation exists
        $query->with('departmentRelation:id,name');

        $expenses = $query->orderBy('date', 'desc')->paginate(20);

        // Calculate total expense in the current month (regardless of filter)
        $now = now();
        $total_expense_month = Expense::where('merchant_id', $merchantId)
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('amount');

        // Add department_name to each item
        $expenses->getCollection()->transform(function ($item) {
            $item->department_name = $item->departmentRelation->name ?? null;
            return $item;
        });

        $result = $expenses->toArray();
        $result['total_expense_month'] = $total_expense_month;

        return response()->json($result);
    }


    // Store a new expense
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'amount'     => 'required|numeric|min:0',
            'date'       => 'required|date',
            'department' => 'required|integer|exists:departments,id',
            'reference'  => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
        ]);

        $validated['merchant_id'] = auth()->user()->merchant_id;
        $expense = Expense::create($validated);

        return response()->json([
            'status' => 'ok',
            'data'   => $expense,
            'msg'    => 'Expense created successfully',
        ]);
    }
}
