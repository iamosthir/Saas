<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip subscription check for admin routes
        if ($request->is('admin/*') || $request->is('admin')) {
            return $next($request);
        }

        if (auth()->check()) {
            $user = auth()->user();

            if ($user->merchant_id) {
                $merchant = $user->merchant;

                if ($merchant && $merchant->isSubscriptionExpired()) {
                    if (!$request->is('renew') && !$request->is('logout')) {
                        return redirect()->route('subscription.renew')
                            ->with('error', 'Your subscription has expired. Please renew to continue.');
                    }
                }
            }
        }

        return $next($request);
    }
}
