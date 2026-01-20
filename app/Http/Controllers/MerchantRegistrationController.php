<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\SubscriptionPlans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class MerchantRegistrationController extends Controller
{
    public function showRegistrationForm($planId)
    {
        $plan = SubscriptionPlans::findOrFail($planId);
        return view('merchant-register', compact('plan'));
    }

    public function register(Request $request)
{
    // Validate request
    $validated = $request->validate([
        'merchant_name'        => 'required|string|max:255',
        'phone_primary'        => 'required|string|max:255',
        'subscription_plan_id' => 'required|exists:subscription_plans,id',

        'user_name'            => 'required|string|max:255',
        'user_phone'           => 'required|string|max:255',
        'user_password'        => 'required|string|min:6|confirmed',
    ]);

    try {
        DB::beginTransaction();

        $plan = SubscriptionPlans::findOrFail($validated['subscription_plan_id']);

        $merchant = Merchant::create([
            'name'                   => $validated['merchant_name'],
            'description'            => $request->description,      // optional
            'phone_primary'          => $validated['phone_primary'],
            'phone_secondary'        => $request->phone_secondary,  // optional
            'address1'               => $request->address1,         // optional
            'address2'               => $request->address2,         // optional
            'city'                   => $request->city,             // optional
            'zip_code'               => $request->zip_code,         // optional
            'subscription_start_date'=> Carbon::now(),
            'subscription_end_date'  => Carbon::now()->addDays($plan->duration),
            'is_active'              => true,
            'subscription_plan_id'   => $validated['subscription_plan_id'],
        ]);

        $user = User::create([
            'name'        => $validated['user_name'],
            'phone'       => $validated['user_phone'],
            // email removed because not in form (or make it nullable in DB if you add it later)
            'password'    => Hash::make($validated['user_password']),
            'merchant_id' => $merchant->id,
            'role'        => 'super',
        ]);

        DB::commit();

        return redirect()
            ->route('login')
            ->with('success', 'تم تسجيل التاجر بنجاح، يرجى تسجيل الدخول للمتابعة.');
    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Merchant registration failed', [
            'message' => $e->getMessage(),
        ]);

        return back()
            ->withInput()
            ->withErrors(['error' => 'حدث خطأ أثناء التسجيل، يرجى المحاولة مرة أخرى.']);
    }
}

}
