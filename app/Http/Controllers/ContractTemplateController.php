<?php

namespace App\Http\Controllers;

use App\Models\ContractTemplate;
use App\Models\ContractCustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContractTemplateController extends Controller
{
    /**
     * Display a listing of contract templates.
     */
    public function index()
    {
        $merchantId = Auth::user()->merchant_id;

        $templates = ContractTemplate::forMerchant($merchantId)
            ->with('customFields')
            ->orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();

        return response()->json($templates);
    }

    /**
     * Store a newly created contract template.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'is_default' => 'boolean',
            'custom_fields' => 'array',
            'custom_fields.*.field_key' => 'required|string|max:100',
            'custom_fields.*.field_label' => 'required|string|max:255',
            'custom_fields.*.field_type' => 'required|in:text,number,date,textarea,select',
            'custom_fields.*.select_options' => 'required_if:custom_fields.*.field_type,select|array',
            'custom_fields.*.is_required' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $merchantId = Auth::user()->merchant_id;

        DB::beginTransaction();

        try {
            // If this template is set as default, unset other defaults
            if ($request->is_default) {
                ContractTemplate::forMerchant($merchantId)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            // Create the template
            $template = ContractTemplate::create([
                'merchant_id' => $merchantId,
                'name' => $request->name,
                'description' => $request->description,
                'footer_text' => $request->footer_text,
                'is_default' => $request->is_default ?? false,
                'is_active' => $request->is_active ?? true,
            ]);

            // Create custom fields
            if ($request->has('custom_fields')) {
                foreach ($request->custom_fields as $index => $field) {
                    ContractCustomField::create([
                        'contract_template_id' => $template->id,
                        'field_key' => $field['field_key'],
                        'field_label' => $field['field_label'],
                        'field_type' => $field['field_type'],
                        'select_options' => $field['select_options'] ?? null,
                        'is_required' => $field['is_required'] ?? false,
                        'display_order' => $index,
                    ]);
                }
            }

            DB::commit();

            // Load the template with custom fields
            $template->load('customFields');

            return response()->json($template, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create template: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified contract template.
     */
    public function show($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $template = ContractTemplate::forMerchant($merchantId)
            ->with('customFields')
            ->findOrFail($id);

        return response()->json($template);
    }

    /**
     * Update the specified contract template.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'is_default' => 'boolean',
            'custom_fields' => 'array',
            'custom_fields.*.field_key' => 'required|string|max:100',
            'custom_fields.*.field_label' => 'required|string|max:255',
            'custom_fields.*.field_type' => 'required|in:text,number,date,textarea,select',
            'custom_fields.*.select_options' => 'required_if:custom_fields.*.field_type,select|array',
            'custom_fields.*.is_required' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $merchantId = Auth::user()->merchant_id;

        $template = ContractTemplate::forMerchant($merchantId)->findOrFail($id);

        DB::beginTransaction();

        try {
            // If this template is set as default, unset other defaults
            if ($request->is_default) {
                ContractTemplate::forMerchant($merchantId)
                    ->where('id', '!=', $id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            // Update the template
            $template->update([
                'name' => $request->name,
                'description' => $request->description,
                'footer_text' => $request->footer_text,
                'is_default' => $request->is_default ?? false,
                'is_active' => $request->is_active ?? true,
            ]);

            // Delete existing custom fields
            $template->customFields()->delete();

            // Create new custom fields
            if ($request->has('custom_fields')) {
                foreach ($request->custom_fields as $index => $field) {
                    ContractCustomField::create([
                        'contract_template_id' => $template->id,
                        'field_key' => $field['field_key'],
                        'field_label' => $field['field_label'],
                        'field_type' => $field['field_type'],
                        'select_options' => $field['select_options'] ?? null,
                        'is_required' => $field['is_required'] ?? false,
                        'display_order' => $index,
                    ]);
                }
            }

            DB::commit();

            // Load the template with custom fields
            $template->load('customFields');

            return response()->json($template);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update template: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified contract template.
     */
    public function destroy($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $template = ContractTemplate::forMerchant($merchantId)->findOrFail($id);

        // Check if template is in use
        if ($template->contracts()->count() > 0) {
            return response()->json([
                'error' => 'Cannot delete template. It is being used by ' . $template->contracts()->count() . ' contract(s).'
            ], 400);
        }

        $template->delete();

        return response()->json(['message' => 'Template deleted successfully']);
    }

    /**
     * Toggle active status of the template.
     */
    public function toggleActive($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $template = ContractTemplate::forMerchant($merchantId)->findOrFail($id);

        $template->update([
            'is_active' => !$template->is_active
        ]);

        return response()->json($template);
    }
}
