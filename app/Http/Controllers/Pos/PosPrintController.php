<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Pos\PosSale;
use App\Services\Pos\PosReceiptService;
use Illuminate\Http\Request;

class PosPrintController extends Controller
{
    protected PosReceiptService $receiptService;
    protected \App\Services\WhatsAppService $whatsappService;

    public function __construct(
        PosReceiptService $receiptService,
        \App\Services\WhatsAppService $whatsappService
    ) {
        $this->receiptService = $receiptService;
        $this->whatsappService = $whatsappService;
    }

    /**
     * Get receipt data (JSON)
     */
    public function receipt($saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->findOrFail($saleId);

        $receiptData = $this->receiptService->generateReceiptData($sale);

        return response()->json([
            'success' => true,
            'data' => $receiptData,
        ]);
    }

    /**
     * Get ESC/POS commands for thermal printer
     */
    public function escpos($saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->findOrFail($saleId);

        $commands = $this->receiptService->generateEscPosCommands($sale);

        return response($commands)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="receipt.bin"');
    }

    /**
     * Get HTML receipt for preview/printing
     */
    public function html($saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->findOrFail($saleId);

        $html = $this->receiptService->generateHtmlReceipt($sale);

        return response($html)
            ->header('Content-Type', 'text/html');
    }

    /**
     * Print receipt (trigger print on client)
     */
    public function print(Request $request, $saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $sale = PosSale::where('merchant_id', $merchantId)
            ->findOrFail($saleId);

        $format = $request->get('format', 'html');

        switch ($format) {
            case 'escpos':
                return $this->escpos($saleId);
            case 'json':
                return $this->receipt($saleId);
            default:
                return $this->html($saleId);
        }
    }

    /**
     * Send receipt via WhatsApp
     */
    public function sendWhatsApp(Request $request, $saleId)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = \Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $sale = PosSale::where('merchant_id', $merchantId)
            ->findOrFail($saleId);

        if (!$this->whatsappService->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp is not configured. Please contact administrator.',
            ], 400);
        }

        try {
            $receiptData = $this->receiptService->generateReceiptData($sale);
            $result = $this->whatsappService->sendReceipt($request->phone, $receiptData);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Receipt sent successfully via WhatsApp',
                    'data' => $result,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['error'] ?? 'Failed to send WhatsApp message',
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Check if WhatsApp is configured
     */
    public function whatsappStatus()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'configured' => $this->whatsappService->isConfigured(),
            ],
        ]);
    }
}
