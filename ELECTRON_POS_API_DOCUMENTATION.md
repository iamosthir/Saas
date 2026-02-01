# Electron POS - API Documentation

## Base URL
```
Production: https://yourdomain.com/api
Development: http://localhost:8000/api
```

---

## Authentication

All API endpoints (except login) require authentication using Bearer token.

### Headers
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your_token_here}
```

---

## API Endpoints

### 1. Authentication

#### 1.1 Login
**POST** `/auth/login`

**Description:** Authenticate user and receive API token

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "token": "1|abc123xyz...",
  "token_type": "Bearer",
  "expires_in": 525600,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "merchant_id": 5,
    "role": "pos_user",
    "permissions": ["pos", "sales.create", "sales.view"]
  }
}
```

**Error Response (401):**
```json
{
  "message": "The provided credentials are incorrect.",
  "errors": {
    "email": ["The provided credentials are incorrect."]
  }
}
```

**Error Response (403):**
```json
{
  "message": "User is not associated with any merchant."
}
```

---

#### 1.2 Logout
**POST** `/auth/logout`

**Headers:** Bearer Token Required

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

#### 1.3 Logout All Devices
**POST** `/auth/logout-all`

**Headers:** Bearer Token Required

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logged out from all devices successfully"
}
```

---

#### 1.4 Get Current User
**GET** `/auth/me`

**Headers:** Bearer Token Required

**Success Response (200):**
```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "merchant_id": 5,
    "role": "pos_user",
    "permissions": ["pos", "sales.create", "sales.view"]
  }
}
```

---

#### 1.5 Refresh Token
**POST** `/auth/refresh`

**Headers:** Bearer Token Required

**Description:** Revoke current token and get a new one

**Success Response (200):**
```json
{
  "success": true,
  "token": "2|xyz789abc...",
  "token_type": "Bearer",
  "expires_in": 525600
}
```

---

### 2. POS Sync API

#### 2.1 Health Check
**GET** `/pos/sync/status`

**Headers:** Bearer Token Required

**Description:** Check if server is online and get server time

**Success Response (200):**
```json
{
  "success": true,
  "status": "online",
  "server_time": 1706789123000,
  "version": "1.0.0"
}
```

**Use Case:** Electron app should ping this endpoint every 30 seconds to check connectivity.

---

#### 2.2 Sync Sales (Batch Upload)
**POST** `/pos/sync/sales`

**Headers:** Bearer Token Required

**Description:** Upload multiple sales from Electron offline queue

**Request Body:**
```json
{
  "sales": [
    {
      "offline_id": "550e8400-e29b-41d4-a716-446655440000",
      "sale": {
        "customer_id": 10,
        "status": "completed",
        "subtotal": 100.00,
        "discount_type": "percentage",
        "discount_amount": 10,
        "discount_value": 10.00,
        "tax_rate": 5,
        "tax_amount": 4.50,
        "total_amount": 94.50,
        "paid_amount": 100.00,
        "change_amount": 5.50,
        "notes": "Rush order",
        "created_at": 1706789123000,
        "completed_at": 1706789200000
      },
      "items": [
        {
          "product_id": 25,
          "product_variation_id": null,
          "product_name": "Coffee",
          "variation_name": null,
          "sku": "COFFEE-001",
          "barcode": "123456789",
          "quantity": 2,
          "unit_price": 50.00,
          "unit_cost": 20.00,
          "discount_type": null,
          "discount_amount": 0,
          "discount_value": 0,
          "line_total": 100.00,
          "notes": null
        }
      ],
      "payments": [
        {
          "payment_method": "cash",
          "amount": 94.50,
          "tendered_amount": 100.00,
          "change_given": 5.50,
          "reference_number": null,
          "metadata": null
        }
      ]
    }
  ]
}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "synced": [
      {
        "offline_id": "550e8400-e29b-41d4-a716-446655440000",
        "server_id": 1234,
        "status": "created"
      }
    ],
    "errors": []
  }
}
```

**Partial Success (200):**
```json
{
  "success": true,
  "data": {
    "synced": [
      {
        "offline_id": "550e8400-e29b-41d4-a716-446655440000",
        "server_id": 1234,
        "status": "already_exists"
      }
    ],
    "errors": [
      {
        "offline_id": "660e8400-e29b-41d4-a716-446655440001",
        "error": "Product not found"
      }
    ]
  }
}
```

---

#### 2.3 Get Updated Products
**GET** `/pos/sync/products`

**Headers:** Bearer Token Required

**Query Parameters:**
- `updated_after` (optional): Timestamp in milliseconds (default: 0)
- `limit` (optional): Number of records (default: 500, max: 1000)

**Example Request:**
```
GET /pos/sync/products?updated_after=1706789123000&limit=100
```

**Success Response (200):**
```json
{
  "success": true,
  "products": [
    {
      "id": 25,
      "name": "Coffee",
      "sku": "COFFEE-001",
      "barcode": "123456789",
      "category_id": 5,
      "category_name": "Beverages",
      "price": 50.00,
      "cost": 20.00,
      "stock_quantity": 100,
      "low_stock_threshold": 10,
      "image_url": "https://example.com/images/coffee.jpg",
      "has_variations": false,
      "variations": [],
      "is_active": true,
      "updated_at": 1706789456000
    },
    {
      "id": 26,
      "name": "T-Shirt",
      "sku": "TSHIRT-001",
      "barcode": "987654321",
      "category_id": 8,
      "category_name": "Apparel",
      "price": 25.00,
      "cost": 10.00,
      "stock_quantity": 50,
      "low_stock_threshold": 5,
      "image_url": "https://example.com/images/tshirt.jpg",
      "has_variations": true,
      "variations": [
        {
          "id": 101,
          "name": "Small - Red",
          "sku": "TSHIRT-001-S-RED",
          "barcode": "987654321001",
          "price": 25.00,
          "cost": 10.00,
          "stock_quantity": 20
        },
        {
          "id": 102,
          "name": "Medium - Blue",
          "sku": "TSHIRT-001-M-BLUE",
          "barcode": "987654321002",
          "price": 25.00,
          "cost": 10.00,
          "stock_quantity": 30
        }
      ],
      "is_active": true,
      "updated_at": 1706789789000
    }
  ],
  "has_more": false,
  "last_updated": 1706790000000
}
```

**Use Case:**
- On first launch: Get all products with `updated_after=0`
- On subsequent syncs: Use `last_updated` from previous response as `updated_after`
- Repeat until `has_more` is false

---

#### 2.4 Get Updated Customers
**GET** `/pos/sync/customers`

**Headers:** Bearer Token Required

**Query Parameters:**
- `updated_after` (optional): Timestamp in milliseconds (default: 0)
- `limit` (optional): Number of records (default: 500, max: 1000)

**Example Request:**
```
GET /pos/sync/customers?updated_after=1706789123000&limit=100
```

**Success Response (200):**
```json
{
  "success": true,
  "customers": [
    {
      "id": 10,
      "name": "Jane Smith",
      "email": "jane@example.com",
      "phone": "+1234567890",
      "address": "123 Main St, City, State 12345",
      "updated_at": 1706789456000
    },
    {
      "id": 11,
      "name": "Bob Johnson",
      "email": "bob@example.com",
      "phone": "+9876543210",
      "address": "456 Oak Ave, Town, State 67890",
      "updated_at": 1706789789000
    }
  ],
  "has_more": false,
  "last_updated": 1706790000000
}
```

---

#### 2.5 Get Categories
**GET** `/pos/sync/categories`

**Headers:** Bearer Token Required

**Success Response (200):**
```json
{
  "success": true,
  "categories": [
    {
      "id": 5,
      "parent_id": null,
      "name": "Beverages",
      "slug": "beverages"
    },
    {
      "id": 6,
      "parent_id": 5,
      "name": "Hot Drinks",
      "slug": "hot-drinks"
    },
    {
      "id": 8,
      "parent_id": null,
      "name": "Apparel",
      "slug": "apparel"
    }
  ],
  "last_updated": 1706790000000
}
```

---

### 3. Legacy Sync Endpoints (Existing)

These endpoints were already implemented and can still be used:

#### 3.1 Upload Offline Actions
**POST** `/pos/sync/upload`

**Request Body:**
```json
{
  "actions": [
    {
      "offline_id": "uuid-here",
      "action_type": "sale",
      "payload": {
        "customer_id": 10,
        "items": [...],
        "payments": [...]
      }
    }
  ]
}
```

#### 3.2 Get Pending Sync Items
**GET** `/pos/sync/pending`

#### 3.3 Process Pending Queue
**POST** `/pos/sync/process`

#### 3.4 Retry Failed Syncs
**POST** `/pos/sync/retry`

---

## Error Handling

### Common Error Responses

#### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```
**Action:** Token is invalid or expired. Redirect to login.

---

#### 403 Forbidden
```json
{
  "message": "This action is unauthorized."
}
```
**Action:** User doesn't have permission. Show error message.

---

#### 422 Validation Error
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```
**Action:** Display validation errors to user.

---

#### 500 Server Error
```json
{
  "message": "Server Error",
  "exception": "..."
}
```
**Action:** Log error, show generic error message, queue for retry.

---

## Sync Strategy for Electron App

### Initial Sync (First Launch)
```javascript
1. User logs in → Store token
2. GET /pos/sync/categories → Cache categories
3. GET /pos/sync/products?updated_after=0 → Cache all products
   - If has_more=true, repeat with last_updated
4. GET /pos/sync/customers?updated_after=0 → Cache all customers
   - If has_more=true, repeat with last_updated
5. Ready to work offline!
```

### Periodic Sync (Every 30 seconds when online)
```javascript
1. Check connectivity: GET /pos/sync/status
2. If online:
   a. Push local changes: POST /pos/sync/sales
   b. Pull updates: GET /pos/sync/products?updated_after={last_sync}
   c. Pull updates: GET /pos/sync/customers?updated_after={last_sync}
   d. Update last_sync timestamp
3. Update UI sync indicator
```

### Sale Creation Flow
```javascript
Offline Mode:
1. User completes sale
2. Save to local SQLite with offline_id (UUID)
3. Mark as synced=false
4. Add to sync queue
5. Show "Saved locally" message

When Online:
1. Sync manager detects pending sales
2. Batch upload: POST /pos/sync/sales
3. Server returns server_id
4. Update local record: server_id=1234, synced=true
5. Remove from sync queue
6. Show "Synced successfully" toast
```

### Conflict Resolution
- **Products/Customers**: Server always wins (pull updates)
- **Sales**: Client wins (use unique offline_id to prevent duplicates)
- **Inventory**: Movement-based tracking (apply deltas)

---

## Testing with Postman/Insomnia

### Step 1: Login
```http
POST http://localhost:8000/api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

Copy the `token` from response.

---

### Step 2: Test Protected Endpoints
```http
GET http://localhost:8000/api/auth/me
Authorization: Bearer {paste_token_here}
```

---

### Step 3: Sync Products
```http
GET http://localhost:8000/api/pos/sync/products?updated_after=0&limit=10
Authorization: Bearer {paste_token_here}
```

---

### Step 4: Create Sale
```http
POST http://localhost:8000/api/pos/sync/sales
Authorization: Bearer {paste_token_here}
Content-Type: application/json

{
  "sales": [
    {
      "offline_id": "550e8400-e29b-41d4-a716-446655440000",
      "sale": {
        "customer_id": null,
        "status": "completed",
        "subtotal": 100.00,
        "discount_type": null,
        "discount_amount": 0,
        "discount_value": 0,
        "tax_rate": 0,
        "tax_amount": 0,
        "total_amount": 100.00,
        "paid_amount": 100.00,
        "change_amount": 0,
        "created_at": 1706789123000,
        "completed_at": 1706789200000
      },
      "items": [
        {
          "product_id": 1,
          "product_variation_id": null,
          "quantity": 2,
          "unit_price": 50.00,
          "unit_cost": 20.00,
          "line_total": 100.00
        }
      ],
      "payments": [
        {
          "payment_method": "cash",
          "amount": 100.00,
          "tendered_amount": 100.00,
          "change_given": 0
        }
      ]
    }
  ]
}
```

---

## Rate Limiting

Currently no rate limiting is applied to API routes. Consider adding in production:

```php
// In routes/api.php
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // 60 requests per minute per user
});
```

---

## Security Best Practices

1. **HTTPS Only in Production**
   - Never send tokens over HTTP
   - Use SSL/TLS certificates

2. **Token Storage (Electron)**
   - Use `electron-store` with encryption
   - Never store in localStorage or plaintext files

3. **Token Refresh**
   - Implement automatic token refresh before expiration
   - Current expiration: 1 year (525600 minutes)

4. **CORS Configuration**
   - Currently allows all origins (*)
   - In production, restrict to specific domains if needed

5. **Input Validation**
   - All endpoints validate input
   - SQL injection protected by Eloquent ORM
   - XSS protection built into Laravel

---

## Database Schema (Server)

### pos_sales Table
```sql
- id (PK)
- merchant_id (FK)
- customer_id (FK, nullable)
- sale_number (unique: POS-000001)
- status (draft/parked/completed/voided)
- subtotal, discount_type, discount_amount, discount_value
- tax_rate, tax_amount, total_amount
- paid_amount, change_amount
- park_name, notes
- offline_id (unique, nullable) ← For Electron sync
- synced (boolean) ← Sync status
- created_by, completed_by, completed_at
- timestamps, soft_deletes
```

### pos_sale_items Table
```sql
- id (PK)
- pos_sale_id (FK)
- product_id (FK)
- product_variation_id (FK, nullable)
- product_name, variation_name, sku, barcode (snapshot)
- quantity, unit_price, unit_cost
- discount_type, discount_amount, discount_value
- line_total, notes
- timestamps
```

### pos_payments Table
```sql
- id (PK)
- merchant_id (FK)
- pos_sale_id (FK)
- payment_method (cash/card/wallet/bank_transfer)
- amount, tendered_amount, change_given
- reference_number, metadata (JSON)
- processed_by
- timestamps
```

---

## API Response Standards

### Success Response Format
```json
{
  "success": true,
  "data": { ... },
  "message": "Optional success message"
}
```

### Error Response Format
```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
```

---

## Changelog

### Version 1.0.0 (2026-01-31)
- Initial API implementation
- Authentication endpoints (login, logout, refresh, me)
- Sync endpoints (sales, products, customers, categories)
- Health check endpoint
- Token expiration set to 1 year
- CORS enabled for all origins

---

## Support

For API issues or questions:
- Check logs: `storage/logs/laravel.log`
- Database errors: Check `pos_offline_queue` table for sync failures
- Contact: development@yourdomain.com

---

**END OF API DOCUMENTATION**
