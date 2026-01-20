<?php

namespace App\Http\Controllers;

use App\Models\InvoiceTemplate;
use App\Models\InvoiceCustomField;
use App\Models\InvoiceItemCustomField;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class InvoiceTemplateController extends Controller
{
    /**
     * Display a listing of invoice templates for the authenticated merchant.
     */
    public function index(Request $request)
    {
        $merchantId = Auth::user()->merchant_id;

        $templates = InvoiceTemplate::forMerchant($merchantId)
            ->with(['headerFields', 'itemFields'])
            ->orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'ok',
            'templates' => $templates,
        ]);
    }

    /**
     * Store a newly created template.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_default' => 'boolean',
            'header_fields' => 'array',
            'header_fields.*.field_key' => 'required|string|max:100',
            'header_fields.*.field_label' => 'required|string|max:255',
            'header_fields.*.field_type' => 'required|in:text,number,date,select',
            'header_fields.*.select_options' => 'required_if:header_fields.*.field_type,select|array',
            'header_fields.*.is_required' => 'boolean',
            'item_fields' => 'array',
            'item_fields.*.field_key' => 'required|string|max:100',
            'item_fields.*.field_label' => 'required|string|max:255',
            'item_fields.*.field_type' => 'required|in:text,number,date,select',
            'item_fields.*.select_options' => 'required_if:item_fields.*.field_type,select|array',
            'item_fields.*.is_required' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $merchantId = Auth::user()->merchant_id;

            // If setting as default, unset other defaults
            if ($request->is_default) {
                InvoiceTemplate::forMerchant($merchantId)->update(['is_default' => false]);
            }

            $template = InvoiceTemplate::create([
                'merchant_id' => $merchantId,
                'name' => $request->name,
                'description' => $request->description,
                'is_default' => $request->is_default ?? false,
            ]);

            // Create header fields
            foreach ($request->header_fields ?? [] as $index => $field) {
                InvoiceCustomField::create([
                    'invoice_template_id' => $template->id,
                    'field_key' => $field['field_key'],
                    'field_label' => $field['field_label'],
                    'field_type' => $field['field_type'],
                    'select_options' => $field['select_options'] ?? null,
                    'is_required' => $field['is_required'] ?? false,
                    'display_order' => $index,
                ]);
            }

            // Create item fields
            foreach ($request->item_fields ?? [] as $index => $field) {
                InvoiceItemCustomField::create([
                    'invoice_template_id' => $template->id,
                    'field_key' => $field['field_key'],
                    'field_label' => $field['field_label'],
                    'field_type' => $field['field_type'],
                    'select_options' => $field['select_options'] ?? null,
                    'is_required' => $field['is_required'] ?? false,
                    'display_order' => $index,
                ]);
            }

            DB::commit();

            // Clear cache
            $this->clearTemplateCache($merchantId);

            return response()->json([
                'status' => 'ok',
                'msg' => 'Template created successfully',
                'template' => $template->load(['headerFields', 'itemFields']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to create template: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified template.
     */
    public function show($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $template = InvoiceTemplate::forMerchant($merchantId)
            ->with(['headerFields', 'itemFields'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'ok',
            'template' => $template,
        ]);
    }

    /**
     * Update the specified template.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_default' => 'boolean',
            'header_fields' => 'array',
            'header_fields.*.field_key' => 'required|string|max:100',
            'header_fields.*.field_label' => 'required|string|max:255',
            'header_fields.*.field_type' => 'required|in:text,number,date,select',
            'header_fields.*.select_options' => 'required_if:header_fields.*.field_type,select|array',
            'header_fields.*.is_required' => 'boolean',
            'item_fields' => 'array',
            'item_fields.*.field_key' => 'required|string|max:100',
            'item_fields.*.field_label' => 'required|string|max:255',
            'item_fields.*.field_type' => 'required|in:text,number,date,select',
            'item_fields.*.select_options' => 'required_if:item_fields.*.field_type,select|array',
            'item_fields.*.is_required' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $merchantId = Auth::user()->merchant_id;

            $template = InvoiceTemplate::forMerchant($merchantId)->findOrFail($id);

            // If setting as default, unset other defaults
            if ($request->is_default && !$template->is_default) {
                InvoiceTemplate::forMerchant($merchantId)
                    ->where('id', '!=', $id)
                    ->update(['is_default' => false]);
            }

            $template->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_default' => $request->is_default ?? false,
            ]);

            // Delete existing fields
            InvoiceCustomField::where('invoice_template_id', $template->id)->delete();
            InvoiceItemCustomField::where('invoice_template_id', $template->id)->delete();

            // Recreate header fields
            foreach ($request->header_fields ?? [] as $index => $field) {
                InvoiceCustomField::create([
                    'invoice_template_id' => $template->id,
                    'field_key' => $field['field_key'],
                    'field_label' => $field['field_label'],
                    'field_type' => $field['field_type'],
                    'select_options' => $field['select_options'] ?? null,
                    'is_required' => $field['is_required'] ?? false,
                    'display_order' => $index,
                ]);
            }

            // Recreate item fields
            foreach ($request->item_fields ?? [] as $index => $field) {
                InvoiceItemCustomField::create([
                    'invoice_template_id' => $template->id,
                    'field_key' => $field['field_key'],
                    'field_label' => $field['field_label'],
                    'field_type' => $field['field_type'],
                    'select_options' => $field['select_options'] ?? null,
                    'is_required' => $field['is_required'] ?? false,
                    'display_order' => $index,
                ]);
            }

            DB::commit();

            // Clear cache
            $this->clearTemplateCache($merchantId);

            return response()->json([
                'status' => 'ok',
                'msg' => 'Template updated successfully',
                'template' => $template->load(['headerFields', 'itemFields']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to update template: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified template.
     */
    public function destroy($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $template = InvoiceTemplate::forMerchant($merchantId)->findOrFail($id);

        // Check if template is in use
        $invoiceCount = Invoice::where('invoice_template_id', $id)->count();

        if ($invoiceCount > 0) {
            return response()->json([
                'status' => 'warning',
                'msg' => "$invoiceCount invoices use this template. The template will be soft deleted but invoices will retain their data.",
                'invoice_count' => $invoiceCount,
            ]);
        }

        // Soft delete the template
        $template->delete();

        // Clear cache
        $this->clearTemplateCache($merchantId);

        return response()->json([
            'status' => 'ok',
            'msg' => 'Template deleted successfully',
        ]);
    }

    /**
     * Toggle the active status of a template.
     */
    public function toggleActive($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $template = InvoiceTemplate::forMerchant($merchantId)->findOrFail($id);
        $template->is_active = !$template->is_active;
        $template->save();

        // Clear cache
        $this->clearTemplateCache($merchantId);

        return response()->json([
            'status' => 'ok',
            'msg' => 'Template status updated successfully',
            'is_active' => $template->is_active,
        ]);
    }

    /**
     * Clear the template cache for a merchant.
     */
    private function clearTemplateCache($merchantId)
    {
        Cache::forget("merchant_{$merchantId}_invoice_templates");
    }
}
