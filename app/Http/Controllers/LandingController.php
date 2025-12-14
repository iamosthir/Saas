<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlans;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlans::where('is_active', true)->get();
        return view('landing', compact('plans'));
    }
}
