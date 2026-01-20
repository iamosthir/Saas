<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Services\Pos\PosSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PosSyncController extends Controller
{
    protected PosSyncService $syncService;

    public function __construct(PosSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Upload offline data for sync
     */
    public function upload(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $validator = Validator::make($request->all(), [
            'actions' => 'required|array',
            'actions.*.offline_id' => 'required|string',
            'actions.*.action_type' => 'required|in:sale,payment,void',
            'actions.*.payload' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $results = $this->syncService->uploadBatch($merchantId, $request->actions);

        return response()->json([
            'success' => true,
            'message' => 'Data uploaded for sync',
            'data' => $results,
        ]);
    }

    /**
     * Get pending sync items
     */
    public function pending()
    {
        $merchantId = auth()->user()->merchant_id;

        $status = $this->syncService->getSyncStatus($merchantId);

        return response()->json([
            'success' => true,
            'data' => $status,
        ]);
    }

    /**
     * Process pending sync queue
     */
    public function process(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $limit = $request->get('limit', 50);

        $results = $this->syncService->processPendingQueue($merchantId, $limit);

        return response()->json([
            'success' => true,
            'message' => 'Sync processing complete',
            'data' => $results,
        ]);
    }

    /**
     * Retry failed sync items
     */
    public function retry()
    {
        $merchantId = auth()->user()->merchant_id;

        $results = $this->syncService->retryFailed($merchantId);

        return response()->json([
            'success' => true,
            'message' => 'Retry processing complete',
            'data' => $results,
        ]);
    }

    /**
     * Get sync status for UI indicator
     */
    public function status()
    {
        $merchantId = auth()->user()->merchant_id;

        $status = $this->syncService->getSyncStatus($merchantId);

        return response()->json([
            'success' => true,
            'data' => [
                'synced' => $status['pending'] === 0 && $status['processing'] === 0,
                'pending_count' => $status['pending'] + $status['processing'],
                'failed_count' => $status['failed'],
                'details' => $status,
            ],
        ]);
    }
}
