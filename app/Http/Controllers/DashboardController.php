<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function dashboard()
    {
        return view("pages.dashboard");
    }

    /**
     * Get merchant permissions for the current user
     */
    public function getMerchantPermissions()
    {
        $user = auth()->user();

        if (!$user || !$user->merchant) {
            return response()->json([
                'can_access_pos' => false,
                'can_access_contracts' => false
            ]);
        }

        return response()->json([
            'can_access_pos' => $user->merchant->canAccessPos(),
            'can_access_contracts' => $user->merchant->canAccessContracts()
        ]);
    }
}
