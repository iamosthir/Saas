<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role !== 'super') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $rates = ExchangeRate::where('merchant_id', $user->merchant_id)->get();

        return response()->json($rates);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'super') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'base_currency' => 'required|string|max:10',
            'target_currency' => 'required|string|max:10',
            'rate' => 'required|numeric|gt:0',
        ]);

        $rate = ExchangeRate::updateOrCreate(
            [
                'merchant_id' => $user->merchant_id,
                'base_currency' => strtoupper($request->base_currency),
                'target_currency' => strtoupper($request->target_currency),
            ],
            [
                'rate' => $request->rate,
            ]
        );

        return response()->json([
            'message' => 'Exchange rate updated successfully',
            'data' => $rate,
        ]);
    }
}
