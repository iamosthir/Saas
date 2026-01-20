<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use App\Models\SubscriptionPlans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminMerchantController extends Controller
{
    /**
     * Display a listing of merchants.
     */
    public function index(Request $request)
    {
        $query = Merchant::with(['subscriptionPlan', 'users']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone_primary', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                      ->where(function ($q) {
                          $q->whereNull('subscription_end_date')
                            ->orWhere('subscription_end_date', '>', now());
                      });
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'expired') {
                $query->where('subscription_end_date', '<', now());
            }
        }

        $merchants = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.merchants.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new merchant.
     */
    public function create()
    {
        $plans = SubscriptionPlans::where('is_active', true)->get();
        return view('admin.merchants.create', compact('plans'));
    }

    /**
     * Store a newly created merchant.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'merchant_name' => 'required|string|max:255',
            'phone_primary' => 'required|string|max:255',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'user_name' => 'required|string|max:255',
            'user_phone' => 'required|string|max:255|unique:users,phone',
            'user_email' => 'nullable|email|unique:users,email',
            'user_password' => 'required|string|min:6',
            'description' => 'nullable|string',
            'phone_secondary' => 'nullable|string|max:255',
            'address1' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $plan = SubscriptionPlans::findOrFail($validated['subscription_plan_id']);

            $merchant = Merchant::create([
                'name' => $validated['merchant_name'],
                'description' => $request->description,
                'phone_primary' => $validated['phone_primary'],
                'phone_secondary' => $request->phone_secondary,
                'address1' => $request->address1,
                'city' => $request->city,
                'subscription_start_date' => Carbon::now(),
                'subscription_end_date' => Carbon::now()->addDays($plan->duration),
                'is_active' => true,
                'can_access_pos' => $request->boolean('can_access_pos'),
                'can_access_contracts' => $request->boolean('can_access_contracts'),
                'subscription_plan_id' => $validated['subscription_plan_id'],
            ]);

            User::create([
                'name' => $validated['user_name'],
                'phone' => $validated['user_phone'],
                'email' => $validated['user_email'],
                'password' => Hash::make($validated['user_password']),
                'merchant_id' => $merchant->id,
                'role' => 'super',
            ]);

            DB::commit();

            return redirect()->route('admin.merchants.index')
                ->with('success', 'تم إنشاء التاجر بنجاح.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified merchant.
     */
    public function show(Merchant $merchant)
    {
        $merchant->load(['subscriptionPlan', 'users']);
        return view('admin.merchants.show', compact('merchant'));
    }

    /**
     * Show the form for editing the merchant.
     */
    public function edit(Merchant $merchant)
    {
        $plans = SubscriptionPlans::where('is_active', true)->get();
        return view('admin.merchants.edit', compact('merchant', 'plans'));
    }

    /**
     * Update the specified merchant.
     */
    public function update(Request $request, Merchant $merchant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_primary' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone_secondary' => 'nullable|string|max:255',
            'address1' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $validated['can_access_pos'] = $request->boolean('can_access_pos');
        $validated['can_access_contracts'] = $request->boolean('can_access_contracts');

        $merchant->update($validated);

        return redirect()->route('admin.merchants.show', $merchant)
            ->with('success', 'تم تحديث بيانات التاجر بنجاح.');
    }

    /**
     * Remove the specified merchant (deactivate).
     */
    public function destroy(Merchant $merchant)
    {
        $merchant->update(['is_active' => false]);

        return redirect()->route('admin.merchants.index')
            ->with('success', 'تم إلغاء تفعيل التاجر.');
    }

    /**
     * Toggle merchant active status.
     */
    public function toggleStatus(Merchant $merchant)
    {
        $merchant->update(['is_active' => !$merchant->is_active]);

        $status = $merchant->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return back()->with('success', "تم {$status} التاجر بنجاح.");
    }
}
