<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMerchantPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission  The permission to check: 'pos' or 'contracts'
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        if (!$user || !$user->merchant_id) {
            return $this->denyAccess($request, $permission);
        }

        $merchant = $user->merchant;

        if (!$merchant) {
            return $this->denyAccess($request, $permission);
        }

        // Check specific permission
        switch ($permission) {
            case 'pos':
                if (!$merchant->canAccessPos()) {
                    return $this->denyAccess($request, $permission);
                }
                break;

            case 'contracts':
                if (!$merchant->canAccessContracts()) {
                    return $this->denyAccess($request, $permission);
                }
                break;

            case 'manufacturing':
                if (!$merchant->canAccessManufacturing()) {
                    return $this->denyAccess($request, $permission);
                }
                break;

            default:
                return $this->denyAccess($request, $permission);
        }

        return $next($request);
    }

    /**
     * Deny access and return appropriate response.
     */
    private function denyAccess(Request $request, string $permission): Response
    {
        $permissionNames = [
            'pos' => 'نظام نقاط البيع',
            'contracts' => 'إدارة العقود',
            'manufacturing' => 'نظام التصنيع',
        ];
        $permissionName = $permissionNames[$permission] ?? $permission;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => "ليس لديك صلاحية الوصول إلى {$permissionName}. يرجى التواصل مع الإدارة.",
            ], 403);
        }

        return redirect()->route('dashboard')
            ->with('error', "ليس لديك صلاحية الوصول إلى {$permissionName}. يرجى التواصل مع الإدارة لتفعيل هذه الخدمة.");
    }
}
