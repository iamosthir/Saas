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

    /**
     * Create sale from offline Electron app data
     *
     * @param int $merchantId
     * @param int $userId
     * @param array $data
     * @return array
     */
    public function createSaleFromOffline(int $merchantId, int $userId, array $data): array
    {
        $saleData = $data['sale'];
        $offlineId = $data['offline_id'];

        // Check if sale already exists
        $existingSale = PosSale::where('offline_id', $offlineId)->first();

        if ($existingSale) {
            return [
                'sale_id' => $existingSale->id,
                'status' => 'already_exists'
            ];
        }

        return DB::transaction(function () use ($merchantId, $userId, $saleData, $data, $offlineId) {
            // Create sale
            $sale = $this->posService->createSale(
                $merchantId,
                $saleData['customer_id'] ?? null
            );

            // Set offline tracking fields
            $sale->offline_id = $offlineId;
            $sale->synced = true;

            // Set timestamps from offline data if available
            if (isset($saleData['created_at'])) {
                $sale->created_at = date('Y-m-d H:i:s', $saleData['created_at'] / 1000);
            }

            if (isset($saleData['completed_at'])) {
                $sale->completed_at = date('Y-m-d H:i:s', $saleData['completed_at'] / 1000);
            }

            $sale->created_by = $userId;
            $sale->completed_by = $userId;

            // Add items
            foreach ($data['items'] as $itemData) {
                $this->posService->addItem($sale, [
                    'product_id' => $itemData['product_id'],
                    'product_variation_id' => $itemData['product_variation_id'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'discount_type' => $itemData['discount_type'] ?? null,
                    'discount_amount' => $itemData['discount_amount'] ?? 0,
                    'notes' => $itemData['notes'] ?? null,
                ]);
            }

            // Apply sale-level discount
            if (!empty($saleData['discount_type'])) {
                $this->posService->applySaleDiscount(
                    $sale,
                    $saleData['discount_type'],
                    $saleData['discount_amount'] ?? 0
                );
            }

            // Complete sale with payments
            if (!empty($data['payments'])) {
                $this->posService->completeSale($sale, $data['payments']);
            }

            $sale->save();

            return [
                'sale_id' => $sale->id,
                'status' => 'created'
            ];
        });
    }

    /**
     * Get products updated after timestamp for Electron sync
     *
     * @param int $merchantId
     * @param int $updatedAfter Timestamp in milliseconds
     * @param int $limit
     * @return array
     */
    public function getUpdatedProducts(int $merchantId, int $updatedAfter, int $limit = 500): array
    {
        $updatedAfterDate = date('Y-m-d H:i:s', $updatedAfter / 1000);

        $products = \App\Models\Product::with(['variations', 'category'])
            ->where('merchant_id', $merchantId)
            ->where('updated_at', '>', $updatedAfterDate)
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category->name ?? null,
                    'price' => (float) $product->price,
                    'cost' => (float) ($product->cost ?? 0),
                    'stock_quantity' => (int) ($product->stock_quantity ?? 0),
                    'low_stock_threshold' => (int) ($product->low_stock_threshold ?? 0),
                    'image_url' => $product->image_url,
                    'has_variations' => $product->variations->count() > 0,
                    'variations' => $product->variations->map(function ($variation) {
                        return [
                            'id' => $variation->id,
                            'name' => $variation->name,
                            'sku' => $variation->sku,
                            'barcode' => $variation->barcode,
                            'price' => (float) $variation->price,
                            'cost' => (float) ($variation->cost ?? 0),
                            'stock_quantity' => (int) ($variation->stock_quantity ?? 0),
                        ];
                    }),
                    'is_active' => (bool) $product->is_active,
                    'updated_at' => $product->updated_at->timestamp * 1000
                ];
            });

        return [
            'data' => $products,
            'has_more' => $products->count() === $limit
        ];
    }

    /**
     * Get customers updated after timestamp for Electron sync
     *
     * @param int $merchantId
     * @param int $updatedAfter Timestamp in milliseconds
     * @param int $limit
     * @return array
     */
    public function getUpdatedCustomers(int $merchantId, int $updatedAfter, int $limit = 500): array
    {
        $updatedAfterDate = date('Y-m-d H:i:s', $updatedAfter / 1000);

        $customers = \App\Models\Customer::where('merchant_id', $merchantId)
            ->where('updated_at', '>', $updatedAfterDate)
            ->limit($limit)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'updated_at' => $customer->updated_at->timestamp * 1000
                ];
            });

        return [
            'data' => $customers,
            'has_more' => $customers->count() === $limit
        ];
    }

    /**
     * Get all categories for Electron sync
     *
     * @param int $merchantId
     * @return array
     */
    public function getCategories(int $merchantId): array
    {
        $categories = \App\Models\Category::where('merchant_id', $merchantId)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'parent_id' => $category->parent_id,
                    'name' => $category->name,
                    'slug' => $category->slug ?? null,
                ];
            });

        return $categories->toArray();
    }
}
