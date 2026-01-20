<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\PosSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PosSettingsController extends Controller
{
    /**
     * Get POS settings
     */
    public function show()
    {
        $merchantId = auth()->user()->merchant_id;
        $settings = PosSetting::getForMerchant($merchantId);

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    /**
     * Update POS settings
     */
    public function update(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'costing_method' => 'nullable|in:fifo,average',
            'allow_negative_stock' => 'nullable|boolean',
            'show_stock_warning' => 'nullable|boolean',
            'receipt_header' => 'nullable|string|max:255',
            'receipt_footer' => 'nullable|string|max:255',
            'print_receipt_auto' => 'nullable|boolean',
            'receipt_size' => 'nullable|in:58mm,80mm',
            'require_customer' => 'nullable|boolean',
            'payment_methods' => 'nullable|array',
            'payment_methods.*' => 'in:cash,card,wallet,bank_transfer,other',
            'keyboard_shortcuts' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $settings = PosSetting::getForMerchant($merchantId);

        // Update only provided fields
        $fillable = [
            'tax_rate',
            'costing_method',
            'allow_negative_stock',
            'show_stock_warning',
            'receipt_header',
            'receipt_footer',
            'print_receipt_auto',
            'receipt_size',
            'require_customer',
            'payment_methods',
            'keyboard_shortcuts',
        ];

        foreach ($fillable as $field) {
            if ($request->has($field)) {
                $settings->$field = $request->$field;
            }
        }

        $settings->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'data' => $settings,
        ]);
    }

    /**
     * Reset settings to defaults
     */
    public function reset()
    {
        $merchantId = auth()->user()->merchant_id;
        $settings = PosSetting::getForMerchant($merchantId);

        $defaults = PosSetting::defaults();
        foreach ($defaults as $key => $value) {
            $settings->$key = $value;
        }
        $settings->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings reset to defaults',
            'data' => $settings,
        ]);
    }
}
