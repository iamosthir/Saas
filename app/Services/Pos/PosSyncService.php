<?php

namespace App\Services\Pos;

use App\Models\Pos\PosOfflineQueue;
use App\Models\Pos\PosSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosSyncService
{
    protected PosService $posService;

    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    /**
     * Queue an offline action for sync
     */
    public function queueAction(int $merchantId, string $offlineId, string $actionType, array $payload): PosOfflineQueue
    {
        return PosOfflineQueue::create([
            'merchant_id' => $merchantId,
            'offline_id' => $offlineId,
            'action_type' => $actionType,
            'payload' => $payload,
            'status' => 'pending',
            'created_offline_at' => $payload['created_at'] ?? now(),
        ]);
    }

    /**
     * Process pending queue items
     */
    public function processPendingQueue(int $merchantId, int $limit = 50): array
    {
        $results = [
            'processed' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        $pendingItems = PosOfflineQueue::where('merchant_id', $merchantId)
            ->pending()
            ->orderBy('created_offline_at', 'asc')
            ->limit($limit)
            ->get();

        foreach ($pendingItems as $item) {
            try {
                $this->processQueueItem($item);
                $results['processed']++;
            } catch (\Exception $e) {
                $item->markAsFailed($e->getMessage());
                $results['failed']++;
                $results['errors'][] = [
                    'offline_id' => $item->offline_id,
                    'error' => $e->getMessage(),
                ];
                Log::error('POS Sync Error', [
                    'offline_id' => $item->offline_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Process a single queue item
     */
    protected function processQueueItem(PosOfflineQueue $item): void
    {
        $item->markAsProcessing();

        DB::transaction(function () use ($item) {
            switch ($item->action_type) {
                case 'sale':
                    $this->processSaleAction($item);
                    break;
                case 'payment':
                    $this->processPaymentAction($item);
                    break;
                case 'void':
                    $this->processVoidAction($item);
                    break;
                default:
                    throw new \Exception("Unknown action type: {$item->action_type}");
            }

            $item->markAsCompleted();
        });
    }

    /**
     * Process offline sale
     */
    protected function processSaleAction(PosOfflineQueue $item): PosSale
    {
        $payload = $item->payload;

        // Check if sale already exists (by offline_id)
        $existingSale = PosSale::where('offline_id', $item->offline_id)->first();
        if ($existingSale) {
            return $existingSale;
        }

        // Create the sale
        $sale = $this->posService->createSale(
            $item->merchant_id,
            $payload['customer_id'] ?? null
        );

        $sale->offline_id = $item->offline_id;
        $sale->synced = true;

        // Add items
        foreach ($payload['items'] ?? [] as $itemData) {
            $this->posService->addItem($sale, $itemData);
        }

        // Apply sale discount if any
        if (!empty($payload['discount_type'])) {
            $this->posService->applySaleDiscount(
                $sale,
                $payload['discount_type'],
                $payload['discount_amount'] ?? 0
            );
        }

        // Complete with payments
        if (!empty($payload['payments'])) {
            $this->posService->completeSale($sale, $payload['payments']);
        }

        return $sale;
    }

    /**
     * Process offline payment
     */
    protected function processPaymentAction(PosOfflineQueue $item): void
    {
        $payload = $item->payload;

        // Find the sale by offline_id or ID
        $sale = null;
        if (!empty($payload['sale_offline_id'])) {
            $sale = PosSale::where('offline_id', $payload['sale_offline_id'])->first();
        } elseif (!empty($payload['sale_id'])) {
            $sale = PosSale::find($payload['sale_id']);
        }

        if (!$sale) {
            throw new \Exception('Sale not found for payment');
        }

        // Process the payment
        $this->posService->completeSale($sale, $payload['payments']);
    }

    /**
     * Process offline void
     */
    protected function processVoidAction(PosOfflineQueue $item): void
    {
        $payload = $item->payload;

        // Find the sale
        $sale = null;
        if (!empty($payload['sale_offline_id'])) {
            $sale = PosSale::where('offline_id', $payload['sale_offline_id'])->first();
        } elseif (!empty($payload['sale_id'])) {
            $sale = PosSale::find($payload['sale_id']);
        }

        if (!$sale) {
            throw new \Exception('Sale not found for void');
        }

        $this->posService->voidSale($sale);
    }

    /**
     * Get pending sync count for merchant
     */
    public function getPendingCount(int $merchantId): int
    {
        return PosOfflineQueue::where('merchant_id', $merchantId)
            ->pending()
            ->count();
    }

    /**
     * Get failed items for retry
     */
    public function getFailedItems(int $merchantId)
    {
        return PosOfflineQueue::where('merchant_id', $merchantId)
            ->retryable()
            ->orderBy('created_offline_at', 'asc')
            ->get();
    }

    /**
     * Retry failed items
     */
    public function retryFailed(int $merchantId): array
    {
        $failedItems = $this->getFailedItems($merchantId);

        foreach ($failedItems as $item) {
            $item->resetForRetry();
        }

        return $this->processPendingQueue($merchantId);
    }

    /**
     * Upload offline data batch
     */
    public function uploadBatch(int $merchantId, array $batch): array
    {
        $results = [
            'queued' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        foreach ($batch as $action) {
            try {
                // Check if already processed
                $existing = PosOfflineQueue::where('offline_id', $action['offline_id'])->first();
                if ($existing && $existing->isCompleted()) {
                    $results['skipped']++;
                    continue;
                }

                if (!$existing) {
                    $this->queueAction(
                        $merchantId,
                        $action['offline_id'],
                        $action['action_type'],
                        $action['payload']
                    );
                }

                $results['queued']++;
            } catch (\Exception $e) {
                $results['errors'][] = [
                    'offline_id' => $action['offline_id'] ?? 'unknown',
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * Get sync status for UI
     */
    public function getSyncStatus(int $merchantId): array
    {
        return [
            'pending' => PosOfflineQueue::where('merchant_id', $merchantId)->pending()->count(),
            'processing' => PosOfflineQueue::where('merchant_id', $merchantId)->processing()->count(),
            'failed' => PosOfflineQueue::where('merchant_id', $merchantId)->failed()->count(),
            'completed_today' => PosOfflineQueue::where('merchant_id', $merchantId)
                ->completed()
                ->whereDate('updated_at', today())
                ->count(),
        ];
    }
}
