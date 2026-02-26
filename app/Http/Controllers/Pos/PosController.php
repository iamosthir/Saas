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
        $draftSales = $this->posService->getDraftSales($merchantId)->map(fn($s) => $this->convertSalePrices($s));

        // Get parked sales
        $parkedSales = $this->posService->getParkedSales($merchantId)->map(fn($s) => $this->convertSalePrices($s));

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

    private function convertSalePrices($sale)
    {
        $sale->subtotal        = convertCurrency($sale->subtotal);
        $sale->discount_amount = convertCurrency($sale->discount_amount);
        $sale->discount_value  = convertCurrency($sale->discount_value);
        $sale->tax_amount      = convertCurrency($sale->tax_amount);
        $sale->total_amount    = convertCurrency($sale->total_amount);
        $sale->paid_amount     = convertCurrency($sale->paid_amount);
        $sale->change_amount   = convertCurrency($sale->change_amount);

        $sale->items->each(function ($item) {
            $item->unit_price      = convertCurrency($item->unit_price);
            $item->unit_cost       = convertCurrency($item->unit_cost);
            $item->discount_amount = convertCurrency($item->discount_amount);
            $item->discount_value  = convertCurrency($item->discount_value);
            $item->line_total      = convertCurrency($item->line_total);
        });

        return $sale;
    }
}
