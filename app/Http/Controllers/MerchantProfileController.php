<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MerchantProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Get merchant profile for logged-in user
     */
    public function show()
    {
        // Only super users can access
        if (auth()->user()->role != "super") {
            return response()->json([
                'status' => 'error',
                'msg' => 'غير مصرح لك بالوصول'
            ], 403);
        }

        $merchantId = auth()->user()->merchant_id;
        $merchant = Merchant::find($merchantId);

        if (!$merchant) {
            return response()->json([
                'status' => 'error',
                'msg' => 'التاجر غير موجود'
            ], 404);
        }

        // Normalize response for Vue component
        $data = [
            'id' => $merchant->id,
            'name' => $merchant->name,
            'phone' => $merchant->phone_primary,
            'address' => $merchant->address1,
            'logo' => $merchant->logo,
        ];

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }

    /**
     * Update merchant profile
     */
    public function update(Request $request)
    {
        // Only super users can update
        if (auth()->user()->role != "super") {
            return response()->json([
                'status' => 'error',
                'msg' => 'غير مصرح لك بالوصول'
            ], 403);
        }

        $merchantId = auth()->user()->merchant_id;
        $merchant = Merchant::find($merchantId);

        if (!$merchant) {
            return response()->json([
                'status' => 'error',
                'msg' => 'التاجر غير موجود'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update basic info
        $merchant->name = $validated['name'];
        $merchant->phone_primary = $validated['phone'] ?? null;
        $merchant->address1 = $validated['address'] ?? null;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($merchant->logo) {
                $oldLogoPath = str_replace(url('/'), '', $merchant->logo);
                if (file_exists(public_path($oldLogoPath))) {
                    unlink(public_path($oldLogoPath));
                }
            }

            // Upload new logo
            $logo = $request->file('logo');
            $logoName = time() . '_' . $merchant->id . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/merchants'), $logoName);

            // Store full URL
            $merchant->logo = url('/uploads/merchants/' . $logoName);
        }

        $merchant->save();

        return response()->json([
            'status' => 'ok',
            'msg' => 'تم تحديث الملف التجاري بنجاح',
            'data' => $merchant
        ]);
    }

    /**
     * Remove merchant logo
     */
    public function removeLogo()
    {
        // Only super users can remove logo
        if (auth()->user()->role != "super") {
            return response()->json([
                'status' => 'error',
                'msg' => 'غير مصرح لك بالوصول'
            ], 403);
        }

        $merchantId = auth()->user()->merchant_id;
        $merchant = Merchant::find($merchantId);

        if (!$merchant) {
            return response()->json([
                'status' => 'error',
                'msg' => 'التاجر غير موجود'
            ], 404);
        }

        // Delete logo file if exists
        if ($merchant->logo) {
            $logoPath = str_replace(url('/'), '', $merchant->logo);
            if (file_exists(public_path($logoPath))) {
                unlink(public_path($logoPath));
            }
            $merchant->logo = null;
            $merchant->save();
        }

        return response()->json([
            'status' => 'ok',
            'msg' => 'تم حذف الشعار بنجاح'
        ]);
    }
}
