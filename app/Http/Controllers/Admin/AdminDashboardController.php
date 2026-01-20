<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use App\Models\SubscriptionPlans;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_merchants' => Merchant::count(),
            'active_merchants' => Merchant::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('subscription_end_date')
                      ->orWhere('subscription_end_date', '>', now());
                })
                ->count(),
            'expired_subscriptions' => Merchant::where('subscription_end_date', '<', now())->count(),
            'expiring_soon' => Merchant::whereBetween('subscription_end_date', [now(), now()->addDays(7)])->count(),
            'total_users' => User::count(),
            'total_plans' => SubscriptionPlans::where('is_active', true)->count(),
        ];

        $recentMerchants = Merchant::with('subscriptionPlan')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $expiringMerchants = Merchant::with('subscriptionPlan')
            ->where('subscription_end_date', '>', now())
            ->where('subscription_end_date', '<', now()->addDays(7))
            ->orderBy('subscription_end_date', 'asc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMerchants', 'expiringMerchants'));
    }
}
