<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCurrencyController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|in:USD,IQD',
        ]);

        $user = auth()->user();
        $user->currency = $request->currency;
        $user->save();

        return response()->json([
            'message' => 'Currency updated successfully',
            'currency' => $user->currency,
        ]);
    }
}
