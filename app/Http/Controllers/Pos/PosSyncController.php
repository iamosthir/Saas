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

    /**
     * Batch sync sales from Electron offline app
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncSales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sales' => 'required|array',
            'sales.*.offline_id' => 'required|string',
            'sales.*.sale' => 'required|array',
            'sales.*.items' => 'required|array',
            'sales.*.payments' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $merchantId = auth()->user()->merchant_id;
        $userId = auth()->id();

        $results = [
            'synced' => [],
            'errors' => []
        ];

        foreach ($request->sales as $saleData) {
            try {
                $result = $this->syncService->createSaleFromOffline(
                    $merchantId,
                    $userId,
                    $saleData
                );

                $results['synced'][] = [
                    'offline_id' => $saleData['offline_id'],
                    'server_id' => $result['sale_id'],
                    'status' => $result['status']
                ];

            } catch (\Exception $e) {
                $results['errors'][] = [
                    'offline_id' => $saleData['offline_id'],
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    /**
     * Get products updated after timestamp for Electron sync
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpdatedProducts(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $updatedAfter = $request->query('updated_after', 0);
        $limit = $request->query('limit', 500);

        $products = $this->syncService->getUpdatedProducts(
            $merchantId,
            $updatedAfter,
            $limit
        );

        return response()->json([
            'success' => true,
            'products' => $products['data'],
            'has_more' => $products['has_more'],
            'last_updated' => now()->timestamp * 1000
        ], 200);
    }

    /**
     * Get customers updated after timestamp for Electron sync
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpdatedCustomers(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;
        $updatedAfter = $request->query('updated_after', 0);
        $limit = $request->query('limit', 500);

        $customers = $this->syncService->getUpdatedCustomers(
            $merchantId,
            $updatedAfter,
            $limit
        );

        return response()->json([
            'success' => true,
            'customers' => $customers['data'],
            'has_more' => $customers['has_more'],
            'last_updated' => now()->timestamp * 1000
        ], 200);
    }

    /**
     * Get categories for Electron sync
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request)
    {
        $merchantId = auth()->user()->merchant_id;

        $categories = $this->syncService->getCategories($merchantId);

        return response()->json([
            'success' => true,
            'categories' => $categories,
            'last_updated' => now()->timestamp * 1000
        ], 200);
    }

    /**
     * Health check endpoint for Electron app
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function healthCheck()
    {
        return response()->json([
            'success' => true,
            'status' => 'online',
            'server_time' => now()->timestamp * 1000,
            'version' => config('app.version', '1.0.0')
        ], 200);
    }
}
