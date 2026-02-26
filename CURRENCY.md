# Currency System

## Overview

All monetary values are stored in the database as **IQD (Iraqi Dinar)**.
The `convertCurrency()` global helper converts any IQD amount to the logged-in user's selected currency at runtime.

Supported currencies: **IQD**, **USD**
Exchange rates are stored per-merchant in the `exchange_rates` table.

---

## Helper Function

**File:** `app/Helpers/CurrencyConverter.php`
**Autoloaded via:** `composer.json` → `autoload.files`

### Signature

```php
convertCurrency(float|int $amount, string $currency = null): float
```

### Parameters

| Parameter  | Type         | Default                        | Description                                  |
|------------|--------------|--------------------------------|----------------------------------------------|
| `$amount`  | float / int  | —                              | The amount in IQD (as stored in the database) |
| `$currency`| string       | logged-in user's currency pref | Target currency code: `'USD'` or `'IQD'`     |

### Return value

Returns the converted amount as a `float`. If no exchange rate is found for the merchant, returns the original amount unchanged.

---

## Usage

### In a Controller (auto-detects user's currency)

```php
$converted = convertCurrency($invoice->total);
```

### In a Controller (force a specific currency)

```php
$usdAmount = convertCurrency($invoice->total, 'USD');
$iqdAmount = convertCurrency($invoice->total, 'IQD'); // returns as-is
```

### In a Blade view

```blade
{{ convertCurrency($product->price) }}
```

### In an API response

```php
return response()->json([
    'total' => convertCurrency($order->total),
    'currency' => auth()->user()->currency,
]);
```

---

## How Exchange Rates Are Stored

Table: `exchange_rates`

| Column            | Example value | Meaning                        |
|-------------------|---------------|--------------------------------|
| `merchant_id`     | 1             | Rate belongs to this merchant  |
| `base_currency`   | `USD`         | The "from" currency            |
| `target_currency` | `IQD`         | The "to" currency (always IQD) |
| `rate`            | 1460.00       | 1 USD = 1460 IQD               |

**Conversion formula:** `result = amount / rate`
Example: `150,000 IQD / 1460 = 102.74 USD`

Rates are set per-merchant by the super user at:
`/dashboard/exchange-rates` (Vue page, super role only)

---

## Global Variable (Blade + Vue)

The logged-in user's currency preference is exposed as a JS global in `master.blade.php`:

```js
window.currencyName  // 'USD' or 'IQD'
```

Use it in any Vue component:

```js
data() {
    return {
        currencyName: window.currencyName || 'IQD',
    }
}
```

Use it in Blade:

```blade
{{ auth()->user()->currency ?? 'IQD' }}
```

---

## User Currency Preference

- Stored on the `users` table as the `currency` column (default: `USD`)
- Changed via the navbar currency switcher dropdown (top-right)
- API endpoint: `POST /dashboard/api/update-user-currency` with body `{ currency: 'USD' }`
- Reloads the page after switching so `window.currencyName` updates

---

## Adding a New Currency in the Future

1. Add the new currency option to `UserCurrencyController@update` validation:
   ```php
   'currency' => 'required|string|in:USD,IQD,EUR', // add here
   ```
2. Add the option to the navbar switcher in `master.blade.php`
3. Insert the exchange rate row for each merchant in `exchange_rates`:
   ```
   base_currency = 'EUR', target_currency = 'IQD', rate = 1600.00
   ```
4. No changes needed to `convertCurrency()` — it handles any currency pair automatically.
