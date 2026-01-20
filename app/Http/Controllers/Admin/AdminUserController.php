<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users for a merchant.
     */
    public function index(Merchant $merchant)
    {
        $users = $merchant->users()->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('merchant', 'users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(Merchant $merchant)
    {
        return view('admin.users.create', compact('merchant'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request, Merchant $merchant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:super,staff',
        ]);

        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'merchant_id' => $merchant->id,
        ]);

        return redirect()->route('admin.users.index', $merchant)
            ->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(Merchant $merchant, User $user)
    {
        $this->ensureUserBelongsToMerchant($merchant, $user);
        return view('admin.users.edit', compact('merchant', 'user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, Merchant $merchant, User $user)
    {
        $this->ensureUserBelongsToMerchant($merchant, $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:super,staff',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index', $merchant)
            ->with('success', 'تم تحديث المستخدم بنجاح.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(Merchant $merchant, User $user)
    {
        $this->ensureUserBelongsToMerchant($merchant, $user);

        $user->delete();

        return redirect()->route('admin.users.index', $merchant)
            ->with('success', 'تم حذف المستخدم بنجاح.');
    }

    /**
     * Ensure user belongs to the merchant.
     */
    private function ensureUserBelongsToMerchant(Merchant $merchant, User $user)
    {
        if ($user->merchant_id !== $merchant->id) {
            abort(404);
        }
    }
}
