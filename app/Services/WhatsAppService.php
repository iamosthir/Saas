<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $apiKey;
    protected string $phoneNumberId;

    public function __construct()
    {
        // These should be in .env file
        $this->apiUrl = env('WHATSAPP_API_URL', 'https://graph.facebook.com/v17.0');
        $this->apiKey = env('WHATSAPP_API_KEY', '');
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID', '');
    }

    /**
     * Send a text message via WhatsApp
     */
    public function sendMessage(string $to, string $message): array
    {
        if (empty($this->apiKey) || empty($this->phoneNumberId)) {
            throw new \Exception('WhatsApp API not configured. Please set WHATSAPP_API_KEY and WHATSAPP_PHONE_NUMBER_ID in .env');
        }

        // Format phone number (remove + and spaces)
        $to = $this->formatPhoneNumber($to);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/{$this->phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'body' => $message,
                ],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('messages.0.id'),
                    'data' => $response->json(),
                ];
            }

            Log::error('WhatsApp API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => $response->json('error.message') ?? 'Failed to send message',
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send receipt via WhatsApp
     */
    public function sendReceipt(string $to, array $receiptData): array
    {
        $message = $this->formatReceiptMessage($receiptData);
        return $this->sendMessage($to, $message);
    }

    /**
     * Format receipt data as WhatsApp message
     */
    protected function formatReceiptMessage(array $data): string
    {
        $message = "🧾 *RECEIPT*\n\n";

        if (isset($data['header']) && $data['header']) {
            $message .= "*{$data['header']}*\n";
        }

        if (isset($data['merchant']['name'])) {
            $message .= "{$data['merchant']['name']}\n";
        }

        if (isset($data['merchant']['address']) && $data['merchant']['address']) {
            $message .= "{$data['merchant']['address']}\n";
        }

        if (isset($data['merchant']['phone']) && $data['merchant']['phone']) {
            $message .= "Tel: {$data['merchant']['phone']}\n";
        }

        $message .= str_repeat('-', 30) . "\n\n";

        // Sale info
        if (isset($data['sale']['number'])) {
            $message .= "Receipt: *{$data['sale']['number']}*\n";
        }
        if (isset($data['sale']['date'])) {
            $message .= "Date: {$data['sale']['date']}\n";
        }
        if (isset($data['sale']['cashier'])) {
            $message .= "Cashier: {$data['sale']['cashier']}\n";
        }

        // Customer
        if (isset($data['customer']['name'])) {
            $message .= "Customer: {$data['customer']['name']}\n";
        }

        $message .= str_repeat('-', 30) . "\n\n";

        // Items
        $message .= "*ITEMS*\n\n";
        foreach ($data['items'] as $item) {
            $name = $item['name'];
            if (isset($item['variation']) && $item['variation']) {
                $name .= " ({$item['variation']})";
            }
            $message .= "{$name}\n";
            $message .= "  {$item['quantity']} x {$this->formatMoney($item['unit_price'])} = {$this->formatMoney($item['total'])}\n";

            if (isset($item['discount']) && $item['discount'] > 0) {
                $message .= "  Discount: -{$this->formatMoney($item['discount'])}\n";
            }
            $message .= "\n";
        }

        $message .= str_repeat('-', 30) . "\n\n";

        // Totals
        $message .= "Subtotal: {$this->formatMoney($data['totals']['subtotal'])}\n";

        if (isset($data['totals']['discount']) && $data['totals']['discount'] > 0) {
            $message .= "Discount: -{$this->formatMoney($data['totals']['discount'])}\n";
        }

        if (isset($data['totals']['tax_amount']) && $data['totals']['tax_amount'] > 0) {
            $message .= "Tax ({$data['totals']['tax_rate']}%): {$this->formatMoney($data['totals']['tax_amount'])}\n";
        }

        $message .= "\n*TOTAL: {$this->formatMoney($data['totals']['total'])}*\n\n";

        // Payments
        if (isset($data['payments']) && count($data['payments']) > 0) {
            $message .= str_repeat('-', 30) . "\n\n";
            $message .= "*PAYMENTS*\n\n";

            foreach ($data['payments'] as $payment) {
                $message .= "{$payment['method']}: {$this->formatMoney($payment['amount'])}\n";

                if (isset($payment['tendered']) && isset($payment['change']) && $payment['change'] > 0) {
                    $message .= "  Tendered: {$this->formatMoney($payment['tendered'])}\n";
                    $message .= "  Change: {$this->formatMoney($payment['change'])}\n";
                }
            }
        }

        if (isset($data['change']) && $data['change'] > 0) {
            $message .= "\n*Change: {$this->formatMoney($data['change'])}*\n";
        }

        $message .= "\n" . str_repeat('-', 30) . "\n\n";

        // Footer
        if (isset($data['footer']) && $data['footer']) {
            $message .= "{$data['footer']}\n";
        }

        return $message;
    }

    /**
     * Format phone number for WhatsApp
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, assume it's a local number and needs country code
        // You may want to make this configurable
        if (substr($phone, 0, 1) === '0') {
            $countryCode = env('WHATSAPP_DEFAULT_COUNTRY_CODE', '92'); // Default to Pakistan
            $phone = $countryCode . substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Format money value
     */
    protected function formatMoney(float $amount): string
    {
        return number_format($amount, 2);
    }

    /**
     * Check if WhatsApp is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->phoneNumberId);
    }

    /**
     * Send template message (for promotional/marketing messages)
     */
    public function sendTemplate(string $to, string $templateName, array $parameters = []): array
    {
        if (empty($this->apiKey) || empty($this->phoneNumberId)) {
            throw new \Exception('WhatsApp API not configured');
        }

        $to = $this->formatPhoneNumber($to);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/{$this->phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => env('WHATSAPP_LANGUAGE_CODE', 'en'),
                    ],
                    'components' => $parameters,
                ],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('messages.0.id'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('error.message') ?? 'Failed to send template',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
