<?php

namespace App\Services\Pos;

use App\Models\Pos\PosSale;
use App\Models\Pos\PosSetting;

class PosReceiptService
{
    /**
     * Generate receipt data for a sale
     */
    public function generateReceiptData(PosSale $sale): array
    {
        $settings = PosSetting::getForMerchant($sale->merchant_id);
        $sale->load(['items', 'payments', 'customer', 'createdBy', 'merchant']);

        return [
            'receipt_size' => $settings->receipt_size,
            'header' => $settings->receipt_header,
            'footer' => $settings->receipt_footer,
            'merchant' => [
                'name' => $sale->merchant->name ?? '',
                'address' => $sale->merchant->address ?? '',
                'phone' => $sale->merchant->phone ?? '',
            ],
            'sale' => [
                'number' => $sale->sale_number,
                'date' => $sale->completed_at?->format('Y-m-d H:i:s') ?? $sale->created_at->format('Y-m-d H:i:s'),
                'cashier' => $sale->createdBy?->name ?? 'Unknown',
            ],
            'customer' => $sale->customer ? [
                'name' => $sale->customer->customer_name,
                'phone' => $sale->customer->phone1,
            ] : null,
            'items' => $sale->items->map(function ($item) {
                return [
                    'name' => $item->product_name,
                    'variation' => $item->variation_name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount' => $item->discount_value,
                    'total' => $item->line_total,
                ];
            })->toArray(),
            'totals' => [
                'subtotal' => $sale->subtotal,
                'discount' => $sale->discount_value,
                'tax_rate' => $sale->tax_rate,
                'tax_amount' => $sale->tax_amount,
                'total' => $sale->total_amount,
            ],
            'payments' => $sale->payments->map(function ($payment) {
                return [
                    'method' => $payment->getMethodName(),
                    'amount' => $payment->amount,
                    'tendered' => $payment->tendered_amount,
                    'change' => $payment->change_given,
                    'reference' => $payment->reference_number,
                ];
            })->toArray(),
            'change' => $sale->change_amount,
        ];
    }

    /**
     * Generate ESC/POS commands for thermal printer
     */
    public function generateEscPosCommands(PosSale $sale): string
    {
        $data = $this->generateReceiptData($sale);
        $commands = '';

        // Initialize printer
        $commands .= "\x1B\x40"; // ESC @ - Initialize
        $commands .= "\x1B\x61\x01"; // ESC a 1 - Center alignment

        // Header
        if ($data['header']) {
            $commands .= "\x1B\x21\x30"; // Double height and width
            $commands .= $data['header'] . "\n";
            $commands .= "\x1B\x21\x00"; // Normal text
        }

        // Merchant info
        $commands .= $data['merchant']['name'] . "\n";
        if ($data['merchant']['address']) {
            $commands .= $data['merchant']['address'] . "\n";
        }
        if ($data['merchant']['phone']) {
            $commands .= "Tel: " . $data['merchant']['phone'] . "\n";
        }

        $commands .= str_repeat('-', $this->getLineWidth($data['receipt_size'])) . "\n";

        // Sale info
        $commands .= "\x1B\x61\x00"; // Left alignment
        $commands .= "Receipt: " . $data['sale']['number'] . "\n";
        $commands .= "Date: " . $data['sale']['date'] . "\n";
        $commands .= "Cashier: " . $data['sale']['cashier'] . "\n";

        // Customer info
        if ($data['customer']) {
            $commands .= "Customer: " . $data['customer']['name'] . "\n";
        }

        $commands .= str_repeat('-', $this->getLineWidth($data['receipt_size'])) . "\n";

        // Items
        foreach ($data['items'] as $item) {
            $name = $item['name'];
            if ($item['variation']) {
                $name .= ' (' . $item['variation'] . ')';
            }
            $commands .= $this->truncate($name, $this->getLineWidth($data['receipt_size'])) . "\n";
            $commands .= sprintf(
                "  %d x %.2f = %.2f\n",
                $item['quantity'],
                $item['unit_price'],
                $item['total']
            );
            if ($item['discount'] > 0) {
                $commands .= sprintf("  Discount: -%.2f\n", $item['discount']);
            }
        }

        $commands .= str_repeat('-', $this->getLineWidth($data['receipt_size'])) . "\n";

        // Totals
        $commands .= $this->formatLine('Subtotal:', sprintf('%.2f', $data['totals']['subtotal']), $data['receipt_size']);

        if ($data['totals']['discount'] > 0) {
            $commands .= $this->formatLine('Discount:', sprintf('-%.2f', $data['totals']['discount']), $data['receipt_size']);
        }

        if ($data['totals']['tax_amount'] > 0) {
            $commands .= $this->formatLine(
                sprintf('Tax (%.1f%%):', $data['totals']['tax_rate']),
                sprintf('%.2f', $data['totals']['tax_amount']),
                $data['receipt_size']
            );
        }

        $commands .= "\x1B\x21\x10"; // Double width
        $commands .= $this->formatLine('TOTAL:', sprintf('%.2f', $data['totals']['total']), $data['receipt_size']);
        $commands .= "\x1B\x21\x00"; // Normal text

        $commands .= str_repeat('-', $this->getLineWidth($data['receipt_size'])) . "\n";

        // Payments
        foreach ($data['payments'] as $payment) {
            $commands .= $this->formatLine($payment['method'] . ':', sprintf('%.2f', $payment['amount']), $data['receipt_size']);
            if ($payment['tendered'] && $payment['change'] > 0) {
                $commands .= $this->formatLine('  Tendered:', sprintf('%.2f', $payment['tendered']), $data['receipt_size']);
                $commands .= $this->formatLine('  Change:', sprintf('%.2f', $payment['change']), $data['receipt_size']);
            }
        }

        $commands .= str_repeat('-', $this->getLineWidth($data['receipt_size'])) . "\n";

        // Footer
        $commands .= "\x1B\x61\x01"; // Center alignment
        if ($data['footer']) {
            $commands .= "\n" . $data['footer'] . "\n";
        }

        // Barcode (sale number)
        $commands .= "\n";
        $commands .= "\x1D\x68\x50"; // Set barcode height
        $commands .= "\x1D\x77\x02"; // Set barcode width
        $commands .= "\x1D\x48\x02"; // Print HRI below barcode
        $commands .= "\x1D\x6B\x49"; // CODE128
        $commands .= chr(strlen($data['sale']['number'])) . $data['sale']['number'];

        // Cut paper
        $commands .= "\n\n\n";
        $commands .= "\x1D\x56\x41\x03"; // Partial cut

        return $commands;
    }

    /**
     * Get line width based on receipt size
     */
    protected function getLineWidth(string $size): int
    {
        return $size === '58mm' ? 32 : 48;
    }

    /**
     * Truncate text to max length
     */
    protected function truncate(string $text, int $maxLength): string
    {
        if (strlen($text) <= $maxLength) {
            return $text;
        }
        return substr($text, 0, $maxLength - 3) . '...';
    }

    /**
     * Format a line with label on left and value on right
     */
    protected function formatLine(string $label, string $value, string $size): string
    {
        $width = $this->getLineWidth($size);
        $spaces = $width - strlen($label) - strlen($value);
        return $label . str_repeat(' ', max(1, $spaces)) . $value . "\n";
    }

    /**
     * Generate HTML receipt for preview/printing
     */
    public function generateHtmlReceipt(PosSale $sale): string
    {
        $data = $this->generateReceiptData($sale);
        $width = $data['receipt_size'] === '58mm' ? '58mm' : '80mm';

        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <style>
        @page { size: {$width} auto; margin: 0; }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: {$width};
            margin: 0 auto;
            padding: 5mm;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .item { margin: 3px 0; }
        .total-line { display: flex; justify-content: space-between; }
        .big { font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
HTML;

        // Header
        $html .= '<div class="center">';
        if ($data['header']) {
            $html .= '<div class="big">' . htmlspecialchars($data['header']) . '</div>';
        }
        $html .= '<div>' . htmlspecialchars($data['merchant']['name']) . '</div>';
        if ($data['merchant']['address']) {
            $html .= '<div>' . htmlspecialchars($data['merchant']['address']) . '</div>';
        }
        if ($data['merchant']['phone']) {
            $html .= '<div>Tel: ' . htmlspecialchars($data['merchant']['phone']) . '</div>';
        }
        $html .= '</div>';

        $html .= '<div class="line"></div>';

        // Sale info
        $html .= '<div>Receipt: ' . htmlspecialchars($data['sale']['number']) . '</div>';
        $html .= '<div>Date: ' . htmlspecialchars($data['sale']['date']) . '</div>';
        $html .= '<div>Cashier: ' . htmlspecialchars($data['sale']['cashier']) . '</div>';
        if ($data['customer']) {
            $html .= '<div>Customer: ' . htmlspecialchars($data['customer']['name']) . '</div>';
        }

        $html .= '<div class="line"></div>';

        // Items
        foreach ($data['items'] as $item) {
            $name = htmlspecialchars($item['name']);
            if ($item['variation']) {
                $name .= ' (' . htmlspecialchars($item['variation']) . ')';
            }
            $html .= '<div class="item">';
            $html .= '<div>' . $name . '</div>';
            $html .= '<div class="total-line"><span>' . $item['quantity'] . ' x ' . number_format($item['unit_price'], 2) . '</span><span>' . number_format($item['total'], 2) . '</span></div>';
            if ($item['discount'] > 0) {
                $html .= '<div class="right">Discount: -' . number_format($item['discount'], 2) . '</div>';
            }
            $html .= '</div>';
        }

        $html .= '<div class="line"></div>';

        // Totals
        $html .= '<div class="total-line"><span>Subtotal:</span><span>' . number_format($data['totals']['subtotal'], 2) . '</span></div>';
        if ($data['totals']['discount'] > 0) {
            $html .= '<div class="total-line"><span>Discount:</span><span>-' . number_format($data['totals']['discount'], 2) . '</span></div>';
        }
        if ($data['totals']['tax_amount'] > 0) {
            $html .= '<div class="total-line"><span>Tax (' . $data['totals']['tax_rate'] . '%):</span><span>' . number_format($data['totals']['tax_amount'], 2) . '</span></div>';
        }
        $html .= '<div class="total-line big"><span>TOTAL:</span><span>' . number_format($data['totals']['total'], 2) . '</span></div>';

        $html .= '<div class="line"></div>';

        // Payments
        foreach ($data['payments'] as $payment) {
            $html .= '<div class="total-line"><span>' . htmlspecialchars($payment['method']) . ':</span><span>' . number_format($payment['amount'], 2) . '</span></div>';
            if ($payment['tendered'] && $payment['change'] > 0) {
                $html .= '<div class="total-line"><span>Tendered:</span><span>' . number_format($payment['tendered'], 2) . '</span></div>';
                $html .= '<div class="total-line"><span>Change:</span><span>' . number_format($payment['change'], 2) . '</span></div>';
            }
        }

        $html .= '<div class="line"></div>';

        // Footer
        $html .= '<div class="center">';
        if ($data['footer']) {
            $html .= '<div>' . htmlspecialchars($data['footer']) . '</div>';
        }
        $html .= '</div>';

        $html .= '</body></html>';

        return $html;
    }
}
