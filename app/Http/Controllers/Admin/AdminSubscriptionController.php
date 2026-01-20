<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\SubscriptionPlans;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminSubscriptionController extends Controller
{
    /**
     * Display subscription management page.
     */
    public function index(Request $request)
    {
        $query = Merchant::with('subscriptionPlan');

        // Filter by subscription status
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'expired':
                    $query->where('subscription_end_date', '<', now());
                    break;
                case 'expiring':
                    $query->whereBetween('subscription_end_date', [now(), now()->addDays(7)]);
                    break;
                case 'active':
                    $query->where('subscription_end_date', '>', now())
                          ->where('is_active', true);
                    break;
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone_primary', 'like', "%{$search}%");
            });
        }

        $merchants = $query->orderBy('subscription_end_date', 'asc')->paginate(20);
        $plans = SubscriptionPlans::where('is_active', true)->get();

        return view('admin.subscriptions.index', compact('merchants', 'plans'));
    }

    /**
     * Display subscription plans management.
     */
    public function plans()
    {
        $plans = SubscriptionPlans::withCount(['merchants' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        return view('admin.subscriptions.plans', compact('plans'));
    }

    /**
     * Store a new subscription plan.
     */
    public function storePlan(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        SubscriptionPlans::create([
            ...$validated,
            'is_active' => true,
        ]);

        return back()->with('success', 'تم إنشاء الباقة بنجاح.');
    }

    /**
     * Update a subscription plan.
     */
    public function updatePlan(Request $request, SubscriptionPlans $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        return back()->with('success', 'تم تحديث الباقة بنجاح.');
    }

    /**
     * Delete a subscription plan.
     */
    public function destroyPlan(SubscriptionPlans $plan)
    {
        // Check if plan is in use
        if (Merchant::where('subscription_plan_id', $plan->id)->exists()) {
            return back()->with('error', 'لا يمكن حذف باقة مستخدمة من قبل تجار.');
        }

        $plan->delete();

        return back()->with('success', 'تم حذف الباقة بنجاح.');
    }

    /**
     * Extend merchant subscription.
     */
    public function extend(Request $request, Merchant $merchant)
    {
        $validated = $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $currentEnd = $merchant->subscription_end_date ?? now();

        // If subscription is expired, extend from today
        if ($currentEnd < now()) {
            $currentEnd = now();
        }

        $newEnd = Carbon::parse($currentEnd)->addDays($validated['days']);

        $merchant->update([
            'subscription_end_date' => $newEnd,
            'is_active' => true,
        ]);

        return back()->with('success', "تم تمديد الاشتراك بـ {$validated['days']} يوم.");
    }

    /**
     * Revoke merchant subscription.
     */
    public function revoke(Merchant $merchant)
    {
        $merchant->update([
            'is_active' => false,
            'subscription_end_date' => now(),
        ]);

        return back()->with('success', 'تم إلغاء الاشتراك.');
    }

    /**
     * Update subscription dates.
     */
    public function updateDates(Request $request, Merchant $merchant)
    {
        $validated = $request->validate([
            'subscription_start_date' => 'required|date',
            'subscription_end_date' => 'required|date|after:subscription_start_date',
        ]);

        $merchant->update($validated);

        return back()->with('success', 'تم تحديث تواريخ الاشتراك.');
    }

    /**
     * Change merchant's subscription plan.
     */
    public function changePlan(Request $request, Merchant $merchant)
    {
        $validated = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'reset_dates' => 'boolean',
        ]);

        $plan = SubscriptionPlans::findOrFail($validated['subscription_plan_id']);

        $updateData = ['subscription_plan_id' => $plan->id];

        if ($request->boolean('reset_dates')) {
            $updateData['subscription_start_date'] = now();
            $updateData['subscription_end_date'] = now()->addDays($plan->duration);
        }

        $merchant->update($updateData);

        return back()->with('success', 'تم تغيير باقة الاشتراك.');
    }
}
