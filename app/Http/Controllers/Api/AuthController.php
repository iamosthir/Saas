<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Merchant;

class AuthController extends Controller
{
    /**
     * Login user and create API token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string', // Changed to string to accept phone or email
            'password' => 'required|string'
        ]);

        // Determine if login field is email or phone
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Find user by email or phone
        $user = User::where($loginField, $request->email)->first();

        // Check credentials
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user has merchant_id
        if (!$user->merchant_id) {
            return response()->json([
                'message' => 'User is not associated with any merchant.'
            ], 403);
        }

        // Check merchant subscription status
        $merchant = $user->merchant;
        $accountExpired = !$merchant->subscription_end_date || $merchant->subscription_end_date->isPast();

        // Create token
        $token = $user->createToken('pos-app', ['pos:access'])->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration', 525600),
            'account_status' => $accountExpired ? 'expired' : 'active',
            'subscription' => [
                'start_date' => $merchant->subscription_start_date,
                'end_date' => $merchant->subscription_end_date,
                'is_expired' => $accountExpired,
            ],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'merchant_id' => $user->merchant_id,
                'role' => $user->roles->first()->name ?? 'user',
                'permissions' => $user->getAllPermissions()->pluck('name')
            ]
        ], 200);
    }

    /**
     * Logout user (revoke current token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Get current authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'merchant_id' => $user->merchant_id,
                'role' => $user->roles->first()->name ?? 'user',
                'permissions' => $user->getAllPermissions()->pluck('name')
            ]
        ], 200);
    }

    /**
     * Refresh token (revoke current and create new)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $token = $user->createToken('pos-app', ['pos:access'])->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration', 525600)
        ], 200);
    }

    /**
     * Logout from all devices (revoke all tokens)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutAll(Request $request)
    {
        // Revoke all tokens
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out from all devices successfully'
        ], 200);
    }
}
