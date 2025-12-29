<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    /**
     * Show the customer login form.
     */
    public function showLoginForm()
    {
        return view('customer.login');
    }

    /**
     * Handle customer login (passwordless - phone number only).
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Find customer by phone1 field
        $customer = Customer::where('phone1', $request->phone)->first();

        if (!$customer) {
            return back()->withErrors([
                'phone' => 'لم يتم العثور على حساب بهذا الرقم. يرجى التواصل مع التاجر.'
            ])->withInput();
        }

        // Log the customer in using the customer guard
        Auth::guard('customer')->login($customer, $request->filled('remember'));

        // Update last login timestamp
        $customer->update(['last_login_at' => now()]);

        return redirect()->route('customer.dashboard');
    }

    /**
     * Handle customer logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}
