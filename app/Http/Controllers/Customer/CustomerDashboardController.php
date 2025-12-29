<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Display customer dashboard.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        // Get invoices for the customer
        $invoices = $customer->invoices()
            ->with(['items', 'installmentSchedules'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate statistics
        $stats = [
            'total_invoices' => $customer->invoices()->count(),
            'total_amount' => $customer->invoices()->sum('total_amount'),
            'paid_amount' => $customer->invoices()->sum('paid_amount'),
            'remaining_amount' => $customer->invoices()->sum('remaining_amount'),
            'fully_paid_count' => $customer->invoices()->where('is_fully_paid', true)->count(),
            'pending_count' => $customer->invoices()->where('payment_status', 'unpaid')->count(),
        ];

        return view('customer.dashboard', compact('customer', 'invoices', 'stats'));
    }
}
