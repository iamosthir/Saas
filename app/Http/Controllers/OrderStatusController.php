<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    public function index()
    {
        $merchantId = Auth::user()->merchant_id;

        $statuses = OrderStatus::where('merchant_id', $merchantId)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 'ok',
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'color'      => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        $merchantId = Auth::user()->merchant_id;

        // If this is being set as default, unset others
        if ($request->boolean('is_default')) {
            OrderStatus::where('merchant_id', $merchantId)->update(['is_default' => false]);
        }

        $orderStatus = OrderStatus::create([
            'merchant_id' => $merchantId,
            'name'        => $request->name,
            'color'       => $request->color ?? '#6c757d',
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
            'is_default'  => $request->boolean('is_default', false),
        ]);

        return response()->json([
            'status'       => 'ok',
            'msg'          => 'تم إنشاء الحالة بنجاح',
            'order_status' => $orderStatus,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'color'      => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        $merchantId = Auth::user()->merchant_id;

        $orderStatus = OrderStatus::where('id', $id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

        // If this is being set as default, unset others
        if ($request->boolean('is_default')) {
            OrderStatus::where('merchant_id', $merchantId)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $orderStatus->update([
            'name'       => $request->name,
            'color'      => $request->color ?? $orderStatus->color,
            'sort_order' => $request->sort_order ?? $orderStatus->sort_order,
            'is_active'  => $request->boolean('is_active', $orderStatus->is_active),
            'is_default' => $request->boolean('is_default', false),
        ]);

        return response()->json([
            'status'       => 'ok',
            'msg'          => 'تم تحديث الحالة بنجاح',
            'order_status' => $orderStatus->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $orderStatus = OrderStatus::where('id', $id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

        // Check if used by invoices
        if ($orderStatus->invoices()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'لا يمكن حذف هذه الحالة لأنها مرتبطة بفواتير موجودة',
            ], 422);
        }

        $orderStatus->delete();

        return response()->json([
            'status' => 'ok',
            'msg'    => 'تم حذف الحالة بنجاح',
        ]);
    }

    public function toggleActive($id)
    {
        $merchantId = Auth::user()->merchant_id;

        $orderStatus = OrderStatus::where('id', $id)
            ->where('merchant_id', $merchantId)
            ->firstOrFail();

        $orderStatus->update(['is_active' => !$orderStatus->is_active]);

        return response()->json([
            'status'       => 'ok',
            'msg'          => $orderStatus->is_active ? 'تم تفعيل الحالة' : 'تم تعطيل الحالة',
            'order_status' => $orderStatus->fresh(),
        ]);
    }

    /**
     * Return only active statuses (for use in dropdowns).
     */
    public function activeList()
    {
        $merchantId = Auth::user()->merchant_id;

        $statuses = OrderStatus::where('merchant_id', $merchantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'color', 'is_default']);

        return response()->json([
            'status'   => 'ok',
            'statuses' => $statuses,
        ]);
    }
}
