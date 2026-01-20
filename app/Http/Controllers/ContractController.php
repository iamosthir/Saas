<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    /**
     * Display a listing of contracts.
     */
    public function index(Request $request)
    {
        $merchantId = Auth::user()->merchant_id;

        $query = Contract::forMerchant($merchantId)
            ->with(['template', 'creator']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by contract number or title
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('contract_number', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }

        $contracts = $query->orderBy('created_at', 'desc')->get();

        return response()->json($contracts);
    }

    /**
     * Store a newly created contract.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Contract creation started', ['request' => $request->all()]);

            $validator = Validator::make($request->all(), [
                'contract_template_id' => 'required|exists:contract_templates,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'custom_fields' => 'array',
                'footer_text' => 'nullable|string',
                'status' => 'in:draft,active,completed,cancelled',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation failed', ['errors' => $validator->errors()]);
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $merchantId = Auth::user()->merchant_id;
            \Log::info('Merchant ID', ['merchant_id' => $merchantId]);

            // Verify template belongs to merchant
            $template = ContractTemplate::forMerchant($merchantId)->findOrFail($request->contract_template_id);
            \Log::info('Template found', ['template_id' => $template->id]);

            $contractData = [
                'merchant_id' => $merchantId,
                'contract_template_id' => $request->contract_template_id,
                'title' => $request->title,
                'description' => $request->description,
                'custom_fields' => $request->custom_fields ?? [],
                'footer_text' => $request->footer_text,
                'status' => $request->status ?? 'draft',
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'created_by' => Auth::id(),
            ];

            \Log::info('Creating contract with data', $contractData);

            $contract = Contract::create($contractData);

            \Log::info('Contract created successfully', ['contract_id' => $contract->id]);

            // Load relationships
            $contract->load(['template.customFields', 'creator']);

            return response()->json($contract, 201);
        } catch (\Exception $e) {
            \Log::error('Contract creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Failed to create contract: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified contract.
     */
    public function show($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $contract = Contract::forMerchant($merchantId)
            ->with(['template.customFields', 'creator'])
            ->findOrFail($id);

        return response()->json($contract);
    }

    /**
     * Update the specified contract.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'custom_fields' => 'array',
            'footer_text' => 'nullable|string',
            'status' => 'in:draft,active,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $merchantId = Auth::user()->merchant_id;

        $contract = Contract::forMerchant($merchantId)->findOrFail($id);

        $contract->update([
            'title' => $request->title,
            'description' => $request->description,
            'custom_fields' => $request->custom_fields ?? [],
            'footer_text' => $request->footer_text,
            'status' => $request->status ?? 'draft',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Load relationships
        $contract->load(['template.customFields', 'creator']);

        return response()->json($contract);
    }

    /**
     * Remove the specified contract.
     */
    public function destroy($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $contract = Contract::forMerchant($merchantId)->findOrFail($id);

        $contract->delete();

        return response()->json(['message' => 'Contract deleted successfully']);
    }

    /**
     * Update the status of the specified contract.
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $merchantId = Auth::user()->merchant_id;

        $contract = Contract::forMerchant($merchantId)->findOrFail($id);

        $contract->update([
            'status' => $request->status,
        ]);

        // Mark as signed when status changes to active
        if ($request->status === 'active' && !$contract->signed_at) {
            $contract->update(['signed_at' => now()]);
        }

        return response()->json($contract);
    }

    public function print($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $contract = Contract::forMerchant($merchantId)
            ->with(['template.customFields', 'creator'])
            ->findOrFail($id);

        return view("prints.contracts-print", compact('contract'));
    }
}
