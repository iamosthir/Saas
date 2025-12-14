<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    // List all departments
    public function index()
    {
        $merchantId = auth()->user()->merchant_id;
        $departments = Department::where('merchant_id', $merchantId)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($departments);
    }

    // Store a new department
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['merchant_id'] = auth()->user()->merchant_id;
        $department = Department::create($validated);

        return response()->json([
            'status' => 'ok',
            'data' => $department,
            'msg' => 'Department created'
        ]);
    }

    // Update an existing department
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'required|exists:departments,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $merchantId = auth()->user()->merchant_id;
        $department = Department::where('id', $validated['id'])
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $department->update($validated);

        return response()->json([
            'status' => 'ok',
            'data' => $department,
            'msg' => 'Department updated'
        ]);
    }

    // Delete a department
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:departments,id'
        ]);

        $merchantId = auth()->user()->merchant_id;
        $department = Department::where('id', $request->id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();
        $department->delete();

        return response()->json([
            'status' => 'ok',
            'msg' => 'Department deleted'
        ]);
    }
}

