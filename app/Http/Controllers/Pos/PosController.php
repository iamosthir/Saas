<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\PosSetting;
use App\Services\Pos\PosService;
use Illuminate\Http\Request;

class PosController extends Controller
{
    protected PosService $posService;

    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    /**
     * Main POS view
     */
    public function index()
    {
        return view('pages.pos');
    }

    /**
     * Initialize POS with settings and data
     */
    public function initialize(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $settings = PosSetting::getForMerchant($merchantId);

        // Get any draft sales (active carts)
        $draftSales = $this->posService->getDraftSales($merchantId);

        // Get parked sales
        $parkedSales = $this->posService->getParkedSales($merchantId);

        return response()->json([
            'success' => true,
            'data' => [
                'settings' => $settings,
                'draft_sales' => $draftSales,
                'parked_sales' => $parkedSales,
                'user' => [
                    'id' => auth()->id(),
                    'name' => auth()->user()->name,
                ],
            ],
        ]);
    }
}
