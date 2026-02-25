<?php

use App\Models\ExchangeRate;

if (!function_exists('convertCurrency')) {
    /**
     * Convert an amount from IQD to the given currency.
     *
     * @param  float|int  $amount   The amount in IQD (base currency stored in DB)
     * @param  string     $currency The target currency code (e.g. 'USD', 'IQD')
     * @return float
     */
    function convertCurrency($amount, $currency = null)
    {
        if ($currency === null) {
            $currency = auth()->check() ? (auth()->user()->currency ?? 'IQD') : 'IQD';
        }

        $currency = strtoupper($currency);

        // No conversion needed if target is already IQD
        if ($currency === 'IQD') {
            return $amount;
        }

        $merchantId = auth()->check() ? auth()->user()->merchant_id : null;

        if (!$merchantId) {
            return $amount;
        }

        // IQD -> target: we need the USD->IQD rate, then divide
        $rate = ExchangeRate::where('merchant_id', $merchantId)
            ->where('base_currency', $currency)
            ->where('target_currency', 'IQD')
            ->value('rate');

        if (!$rate || $rate <= 0) {
            return $amount;
        }

        return round($amount / $rate, 2);
    }
}
