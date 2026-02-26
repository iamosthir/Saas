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
    // public function generateHtmlReceipt(PosSale $sale): string
    // {
    //     $data = $this->generateReceiptData($sale);
    //     $width = $data['receipt_size'] === '58mm' ? '58mm' : '80mm';

    //     $html = <<<HTML
    //     <!DOCTYPE html>
    //     <html>
    //     <head>
    //         <style>
    //             @page { size: {$width} auto; margin: 0; }
    //             body {
    //                 font-family: 'Courier New', monospace;
    //                 font-size: 12px;
    //                 width: {$width};
    //                 margin: 0 auto;
    //                 padding: 5mm;
    //             }
    //             .center { text-align: center; }
    //             .right { text-align: right; }
    //             .bold { font-weight: bold; }
    //             .line { border-top: 1px dashed #000; margin: 5px 0; }
    //             .item { margin: 3px 0; }
    //             .total-line { display: flex; justify-content: space-between; }
    //             .big { font-size: 14px; font-weight: bold; }
    //         </style>
    //     </head>
    //     <body>
    //     HTML;

    //     // Header
    //     $html .= '<div class="center">';
    //     if ($data['header']) {
    //         $html .= '<div class="big">' . htmlspecialchars($data['header']) . '</div>';
    //     }
    //     $html .= '<div>' . htmlspecialchars($data['merchant']['name']) . '</div>';
    //     if ($data['merchant']['address']) {
    //         $html .= '<div>' . htmlspecialchars($data['merchant']['address']) . '</div>';
    //     }
    //     if ($data['merchant']['phone']) {
    //         $html .= '<div>Tel: ' . htmlspecialchars($data['merchant']['phone']) . '</div>';
    //     }
    //     $html .= '</div>';

    //     $html .= '<div class="line"></div>';

    //     // Sale info
    //     $html .= '<div>Receipt: ' . htmlspecialchars($data['sale']['number']) . '</div>';
    //     $html .= '<div>Date: ' . htmlspecialchars($data['sale']['date']) . '</div>';
    //     $html .= '<div>Cashier: ' . htmlspecialchars($data['sale']['cashier']) . '</div>';
    //     if ($data['customer']) {
    //         $html .= '<div>Customer: ' . htmlspecialchars($data['customer']['name']) . '</div>';
    //     }

    //     $html .= '<div class="line"></div>';

    //     // Items
    //     foreach ($data['items'] as $item) {
    //         $name = htmlspecialchars($item['name']);
    //         if ($item['variation']) {
    //             $name .= ' (' . htmlspecialchars($item['variation']) . ')';
    //         }
    //         $html .= '<div class="item">';
    //         $html .= '<div>' . $name . '</div>';
    //         $html .= '<div class="total-line"><span>' . $item['quantity'] . ' x ' . number_format($item['unit_price'], 2) . '</span><span>' . number_format($item['total'], 2) . '</span></div>';
    //         if ($item['discount'] > 0) {
    //             $html .= '<div class="right">Discount: -' . number_format($item['discount'], 2) . '</div>';
    //         }
    //         $html .= '</div>';
    //     }

    //     $html .= '<div class="line"></div>';

    //     // Totals
    //     $html .= '<div class="total-line"><span>Subtotal:</span><span>' . number_format($data['totals']['subtotal'], 2) . '</span></div>';
    //     if ($data['totals']['discount'] > 0) {
    //         $html .= '<div class="total-line"><span>Discount:</span><span>-' . number_format($data['totals']['discount'], 2) . '</span></div>';
    //     }
    //     if ($data['totals']['tax_amount'] > 0) {
    //         $html .= '<div class="total-line"><span>Tax (' . $data['totals']['tax_rate'] . '%):</span><span>' . number_format($data['totals']['tax_amount'], 2) . '</span></div>';
    //     }
    //     $html .= '<div class="total-line big"><span>TOTAL:</span><span>' . number_format($data['totals']['total'], 2) . '</span></div>';

    //     $html .= '<div class="line"></div>';

    //     // Payments
    //     foreach ($data['payments'] as $payment) {
    //         $html .= '<div class="total-line"><span>' . htmlspecialchars($payment['method']) . ':</span><span>' . number_format($payment['amount'], 2) . '</span></div>';
    //         if ($payment['tendered'] && $payment['change'] > 0) {
    //             $html .= '<div class="total-line"><span>Tendered:</span><span>' . number_format($payment['tendered'], 2) . '</span></div>';
    //             $html .= '<div class="total-line"><span>Change:</span><span>' . number_format($payment['change'], 2) . '</span></div>';
    //         }
    //     }

    //     $html .= '<div class="line"></div>';

    //     // Footer
    //     $html .= '<div class="center">';
    //     if ($data['footer']) {
    //         $html .= '<div>' . htmlspecialchars($data['footer']) . '</div>';
    //     }
    //     $html .= '</div>';

    //     $html .= '</body></html>';

    //     return $html;
    // }
    public function generateHtmlReceipt(PosSale $sale): string
    {
        $data  = $this->generateReceiptData($sale);
        $width = ($data['receipt_size'] ?? '80mm') === '58mm' ? '58mm' : '80mm';
    
        $currency = strtoupper($sale->currency ?? 'IQD');
        $nf0 = function ($n) use ($currency) {
            $n = (float) $n;
            $decimals = (round($n, 2) != round($n, 0)) ? 2 : 0;
            return number_format($n, $decimals, '.', ',') . ' ' . $currency;
        };
    
        // ✅ استدعاء الشعار من $merchant->logo فقط
        $merchant = $sale->merchant; // أو $sale->posMerchant حسب موديلك
        $logoPathOrUrl = (string) ($merchant->logo ?? '');
    
        $logoUrl = '';
        if ($logoPathOrUrl !== '') {
            // إذا هو URL كامل
            if (preg_match('~^https?://~i', $logoPathOrUrl)) {
                $logoUrl = $logoPathOrUrl;
            } else {
                // إذا هو path داخل storage مثل: merchants/logo.png
                $logoUrl = \Illuminate\Support\Facades\Storage::url($logoPathOrUrl);
            }
        }
    
        $logoHtml = $logoUrl !== ''
            ? '<img class="logo" src="' . htmlspecialchars($logoUrl) . '" alt="logo" />'
            : '';
    
        $merchantName    = (string) ($data['merchant']['name'] ?? '');
        $merchantSub     = (string) ($data['header'] ?? '');
        $merchantAddress = (string) ($data['merchant']['address'] ?? '');
    
        $saleNumber  = (string) ($data['sale']['number'] ?? '');
        $saleDate    = (string) ($data['sale']['date'] ?? '');
    
        $customerName = '';
        if (!empty($data['customer']) && !empty($data['customer']['name'])) {
            $customerName = (string) $data['customer']['name'];
        }
    
        $payments = $data['payments'] ?? [];
        $payMethodText = !empty($payments[0]['method']) ? (string) $payments[0]['method'] : 'نقدي';
    
        $discount = (float) ($data['totals']['discount'] ?? 0);
        $taxAmt   = (float) ($data['totals']['tax_amount'] ?? 0);
        $taxRate  = (float) ($data['totals']['tax_rate'] ?? 0);
        $total    = (float) ($data['totals']['total'] ?? 0);
    
        $rowsHtml = '';
        $items = $data['items'] ?? [];
        $i = 1;
    
        foreach ($items as $item) {
            $name = (string) ($item['name'] ?? '');
            $variation = (string) ($item['variation'] ?? '');
            if ($variation !== '') $name .= ' - ' . $variation;
    
            $qty  = (float) ($item['quantity'] ?? 0);
            $unit = (float) ($item['unit_price'] ?? 0);
            $line = (float) ($item['total'] ?? ($qty * $unit));
    
            $rowsHtml .= '
                <tr>
                    <td class="col-no">' . $i . '</td>
                    <td class="col-name">' . htmlspecialchars($name) . '</td>
                    <td class="col-qty">' . $nf0($qty) . '</td>
                    <td class="col-price">' . $nf0($unit) . '</td>
                    <td class="col-total">' . $nf0($line) . '</td>
                </tr>
            ';
            $i++;
        }
    
        $taxLineHtml = '';
        if ($taxAmt > 0) {
            $taxLineHtml = '
                <div class="kv">
                    <div class="k">الضريبة (' . $nf0($taxRate) . '%)</div>
                    <div class="v">' . $nf0($taxAmt) . '</div>
                </div>
            ';
        }
    
        $footer = (string) ($data['footer'] ?? '');
    
        $html = <<<HTML
    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width={$width}, initial-scale=1">
        <style>
            @page { size: {$width} auto; margin: 0; }
            * { box-sizing: border-box; }
            body {
                width: {$width};
                margin: 0 auto;
                padding: 6mm 4mm;
                font-family: "Cairo", "Tahoma", "Arial", sans-serif;
                font-size: 12px;
                color: #111;
                direction: rtl;
            }
            .receipt { border: 1px solid #e5e5e5; padding: 3.5mm; }
            .header { display:flex; align-items:center; justify-content:space-between; gap:8px; }
            .header .text { flex:1; text-align:right; }
            .header .text .title { font-size:16px; font-weight:800; margin:0; line-height:1.2; }
            .header .text .subtitle { font-size:13px; font-weight:700; margin:2px 0 0 0; opacity:.95; }
            .header .text .address { margin-top:4px; font-size:12px; font-weight:700; }
            .logo-wrap { width:26mm; min-width:26mm; display:flex; align-items:center; justify-content:center; }
            .logo { width:26mm; height:auto; max-height:22mm; object-fit:contain; display:block; }
            .thin-line { height:1px; background:#bdbdbd; margin:6px 0; }
            .meta { display:flex; align-items:center; justify-content:space-between; gap:6px; font-size:11.5px; font-weight:700; }
            .meta .left { text-align:left; direction:ltr; }
            .meta .right { text-align:right;     width: 29%;}
            .meta .serial { color:#d11; font-weight:900; }
            .table { width:100%; border-collapse:collapse; margin-top:6px; font-size:12px; }
            .table thead th { background:#111; color:#fff; padding:6px 4px; border:1px solid #111; font-weight:900; white-space:nowrap; }
            .table tbody td { padding:6px 4px; border:1px solid #cfcfcf; vertical-align:top; font-weight:700; }
            .col-no{ width:7mm; text-align:center; }
            .col-name{ width:auto; text-align:right; }
            .col-qty{ width:10mm; text-align:center; }
            .col-price{ width:16mm; text-align:center; direction:ltr; }
            .col-total{ width:18mm; text-align:center; direction:ltr; }
            .payments-row { margin-top:8px; display:flex; justify-content:space-between; font-weight:900; }
            .summary { margin-top:6px; }
            .kv { display:flex; justify-content:space-between; align-items:baseline; gap:6px; padding:3px 0; font-weight:900; font-size:13px; }
            .kv .v { direction:ltr; text-align:left; min-width:24mm; }
            .total-big { margin-top:4px; display:flex; justify-content:space-between; align-items:baseline; gap:8px; font-weight:900; }
            .total-big .k { font-size:20px; font-weight:900; }
            .total-big .v { font-size:22px; font-weight:900; direction:ltr; text-align:left; }
            .discount-row .k, .discount-row .v { color:#d11; }
            .note { margin-top:10px; color:#d11; font-weight:900; text-align:right; font-size:12px; }
            .footer { margin-top:8px; text-align:center; font-weight:700; font-size:11.5px; opacity:.95; }
        </style>
    </head>
    <body>
        <div class="receipt">
            <div class="header">
                <div class="logo-wrap">
                    {$logoHtml}
                </div>
                <div class="text">
                    <div class="title">{$merchantName}</div>
                    <div class="subtitle">{$merchantSub}</div>
                    <div class="address">{$merchantAddress}</div>
                </div>
            </div>
    
            <div class="meta" style="margin-top:6px;">
                <div class="left">
                    <span class="serial">{$saleNumber}</span>
                    <span style="margin:0 6px;color:#999;">|</span>
                    <span>{$saleDate}</span>
                </div>
                <div class="right">
                    <span>السيد :</span>
                    <span>{$customerName}</span>
                </div>
            </div>
    
            <div class="thin-line"></div>
    
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-no">#</th>
                        <th class="col-name">اسم المنتج</th>
                        <th class="col-qty">العدد</th>
                        <th class="col-price">السعر</th>
                        <th class="col-total">الاجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    {$rowsHtml}
                </tbody>
            </table>
    
            <div class="thin-line"></div>
    
            <div class="payments-row">
                <div class="label">الدفع :</div>
                <div class="value">{$payMethodText}</div>
            </div>
    
            <div class="summary">
                <div class="total-big">
                    <div class="k">المبلغ الاجمالي :</div>
                    <div class="v">{$nf0($total)}</div>
                </div>
    
                <div class="kv discount-row" style="margin-top:4px;">
                    <div class="k">الخصم :</div>
                    <div class="v">{$nf0($discount)}</div>
                </div>
    
                {$taxLineHtml}
            </div>
    
            <div class="note">ملاحظة :</div>
    
            <div class="footer">
                {$footer}
            </div>
        </div>
    </body>
    </html>
    HTML;
    
        return $html;
    }
}
