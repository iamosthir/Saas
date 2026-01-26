<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Get all employees
     */
    public function index(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $query = Employee::where('merchant_id', $merchantId);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 20);
        $employees = $query->orderBy('full_name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $employees->items(),
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
            ],
        ]);
    }

    /**
     * Get salary list summary
     */
    public function salaryList(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $employees = Employee::where('merchant_id', $merchantId)
            ->active()
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'job_title', 'monthly_salary']);

        $totalSalary = $employees->sum('monthly_salary');

        return response()->json([
            'success' => true,
            'data' => [
                'employees' => $employees,
                'total_salary' => $totalSalary,
                'employee_count' => $employees->count(),
            ],
        ]);
    }

    /**
     * Create a new employee
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'job_title' => 'required|string|max:255',
            'monthly_salary' => 'required|numeric|min:0',
            'hire_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $employee = Employee::create([
            'merchant_id' => $merchantId,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'job_title' => $request->job_title,
            'monthly_salary' => $request->monthly_salary,
            'hire_date' => $request->hire_date,
            'notes' => $request->notes,
            'status' => Employee::STATUS_ACTIVE,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'data' => $employee,
        ]);
    }

    /**
     * Get a single employee
     */
    public function show($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $employee = Employee::where('merchant_id', $merchantId)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $employee,
        ]);
    }

    /**
     * Update an employee
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'job_title' => 'required|string|max:255',
            'monthly_salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'hire_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $merchantId = auth()->user()->merchant_id;

        $employee = Employee::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $employee->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'job_title' => $request->job_title,
            'monthly_salary' => $request->monthly_salary,
            'status' => $request->status,
            'hire_date' => $request->hire_date,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully',
            'data' => $employee,
        ]);
    }

    /**
     * Delete an employee
     */
    public function destroy($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $employee = Employee::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully',
        ]);
    }

    /**
     * Toggle employee status
     */
    public function toggleStatus($id)
    {
        $merchantId = auth()->user()->merchant_id;

        $employee = Employee::where('merchant_id', $merchantId)
            ->findOrFail($id);

        $employee->status = $employee->isActive()
            ? Employee::STATUS_INACTIVE
            : Employee::STATUS_ACTIVE;
        $employee->save();

        return response()->json([
            'success' => true,
            'message' => 'Employee status updated',
            'data' => $employee,
        ]);
    }
}
