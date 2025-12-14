<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function list()
    {
        $merchantId = auth()->user()->merchant_id;
        $cities = City::where('merchant_id', $merchantId)
            ->orderBy("name","asc")
            ->get();
        return response()->json($cities);
    }
}
