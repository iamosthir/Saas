# Electron POS - Offline-First Point of Sale System
## Project Planning & Implementation Guide

---

## 🎯 Project Overview

Convert the existing web-based POS system into a standalone **Electron desktop application** with **offline-first architecture**. The app will operate fully offline, store transactions locally, and automatically synchronize with the Laravel backend API when internet connectivity is restored.

---

## 📋 Table of Contents

1. [Project Objectives](#project-objectives)
2. [Technical Architecture](#technical-architecture)
3. [Phase 1: Electron App Core Features](#phase-1-electron-app-core-features)
4. [Phase 2: Backend API Development](#phase-2-backend-api-development)
5. [Technology Stack](#technology-stack)
6. [Database Design (Local)](#database-design-local)
7. [Offline Sync Strategy](#offline-sync-strategy)
8. [Feature Parity Checklist](#feature-parity-checklist)
9. [Implementation Timeline](#implementation-timeline)
10. [Security Considerations](#security-considerations)

---

## 🎯 Project Objectives

### Primary Goals
- ✅ **Offline-First**: Full POS functionality without internet dependency
- ✅ **Auto-Sync**: Seamless background synchronization when online
- ✅ **Desktop Native**: Electron app for Windows/Mac/Linux
- ✅ **Feature Parity**: All existing POS features replicated
- ✅ **Token-Based Auth**: Secure API authentication with persistent tokens
- ✅ **Data Integrity**: Conflict resolution and transaction reliability

### Target Users
- Retail store owners with intermittent internet
- Mobile vendors (markets, food trucks)
- Remote locations with poor connectivity
- Businesses requiring 24/7 uptime

---

## 🏗️ Technical Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    ELECTRON APP (Frontend)                   │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Vue 3 UI   │  │  Login Page  │  │ POS Interface│      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│         │                  │                   │             │
│  ┌──────────────────────────────────────────────────────┐   │
│  │            Electron Main Process (Node.js)           │   │
│  │   ┌──────────────┐  ┌──────────────┐  ┌──────────┐ │   │
│  │   │ Local SQLite │  │  Sync Engine │  │ API Client│ │   │
│  │   │   Database   │  │   Manager    │  │  (Axios)  │ │   │
│  │   └──────────────┘  └──────────────┘  └──────────┘ │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
                          │
                          │ HTTP/HTTPS
                          ▼
┌─────────────────────────────────────────────────────────────┐
│              LARAVEL BACKEND (Existing + New APIs)          │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │  Auth API    │  │   POS API    │  │   Sync API   │      │
│  │  (Login)     │  │  (CRUD Ops)  │  │  (Batch Ops) │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│         │                  │                   │             │
│  ┌──────────────────────────────────────────────────────┐   │
│  │                   MySQL Database                     │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

## 📦 Phase 1: Electron App Core Features

### 1.1 Project Setup

**Technology Stack:**
- **Electron**: v28+ (Latest stable)
- **Frontend Framework**: Vue 3 + Vite
- **Local Database**: Better-SQLite3 (synchronous, fast)
- **State Management**: Pinia
- **HTTP Client**: Axios with interceptors
- **UI Framework**: Tailwind CSS + Heroicons (match existing design)
- **Build Tool**: Electron Builder
- **Dev Tools**: Electron Vite

**Project Structure:**
```
electron-pos/
├── src/
│   ├── main/                    # Electron main process
│   │   ├── index.js            # Main entry point
│   │   ├── database/           # SQLite manager
│   │   │   ├── schema.js       # Database schema
│   │   │   ├── migrations.js   # Version migrations
│   │   │   └── queries.js      # SQL queries
│   │   ├── sync/               # Sync engine
│   │   │   ├── syncManager.js  # Sync orchestrator
│   │   │   ├── queueManager.js # Offline queue
│   │   │   └── conflictResolver.js
│   │   ├── api/                # API client
│   │   │   ├── authClient.js   # Login/logout
│   │   │   ├── posClient.js    # POS operations
│   │   │   └── syncClient.js   # Batch sync
│   │   └── services/           # Business logic
│   │       ├── authService.js
│   │       ├── productService.js
│   │       ├── saleService.js
│   │       └── inventoryService.js
│   │
│   ├── renderer/               # Vue frontend
│   │   ├── src/
│   │   │   ├── components/     # Vue components
│   │   │   │   ├── auth/
│   │   │   │   │   ├── LoginPage.vue
│   │   │   │   │   └── TokenManager.vue
│   │   │   │   ├── pos/        # Copy from existing
│   │   │   │   │   ├── PosMain.vue
│   │   │   │   │   ├── PosSalesHistory.vue
│   │   │   │   │   └── PosSettings.vue
│   │   │   │   └── sync/
│   │   │   │       ├── SyncStatus.vue
│   │   │   │       └── OfflineIndicator.vue
│   │   │   ├── stores/         # Pinia stores
│   │   │   │   ├── authStore.js
│   │   │   │   ├── posStore.js
│   │   │   │   ├── productStore.js
│   │   │   │   └── syncStore.js
│   │   │   ├── router/
│   │   │   └── App.vue
│   │   └── index.html
│   │
│   └── preload/                # Preload scripts
│       └── index.js            # IPC bridge
│
├── electron-builder.yml        # Build configuration
├── package.json
└── README.md
```

---

### 1.2 Authentication System

#### Login Page Features:
- **Email/Username + Password** authentication
- **Remember Me** checkbox (persist credentials securely)
- **API Endpoint Configuration** (allow user to set backend URL)
- **Offline Mode Indicator** (show connection status)
- **Auto-login** if valid token exists

#### Token Management:
```javascript
// Token Storage (Electron Store or encrypted SQLite)
{
  access_token: "Bearer ...",
  refresh_token: "...",
  token_type: "Bearer",
  expires_at: 1706789123,
  user: {
    id: 123,
    name: "Store Manager",
    email: "manager@store.com",
    merchant_id: 456,
    role: "pos_user"
  },
  api_url: "https://yourdomain.com/dashboard/api"
}
```

#### IPC Communication (Main ↔ Renderer):
```javascript
// Preload script exposes secure API
window.electronAPI = {
  auth: {
    login: (credentials) => ipcRenderer.invoke('auth:login', credentials),
    logout: () => ipcRenderer.invoke('auth:logout'),
    getToken: () => ipcRenderer.invoke('auth:getToken'),
    isAuthenticated: () => ipcRenderer.invoke('auth:isAuthenticated')
  }
}
```

---

### 1.3 Local Database (SQLite)

#### Schema Design:

**Tables (Mirror Backend Structure):**

```sql
-- Settings
CREATE TABLE app_settings (
  key TEXT PRIMARY KEY,
  value TEXT,
  updated_at INTEGER
);

-- Products (Cached from API)
CREATE TABLE products (
  id INTEGER PRIMARY KEY,
  server_id INTEGER UNIQUE,  -- Backend product ID
  merchant_id INTEGER,
  name TEXT NOT NULL,
  sku TEXT,
  barcode TEXT,
  category_id INTEGER,
  category_name TEXT,
  price REAL,
  cost REAL,
  stock_quantity INTEGER DEFAULT 0,
  low_stock_threshold INTEGER,
  image_url TEXT,
  has_variations INTEGER DEFAULT 0,
  is_active INTEGER DEFAULT 1,
  synced INTEGER DEFAULT 1,
  last_synced_at INTEGER,
  created_at INTEGER,
  updated_at INTEGER
);

-- Product Variations
CREATE TABLE product_variations (
  id INTEGER PRIMARY KEY,
  server_id INTEGER UNIQUE,
  product_id INTEGER,
  name TEXT,
  sku TEXT,
  barcode TEXT,
  price REAL,
  cost REAL,
  stock_quantity INTEGER,
  synced INTEGER DEFAULT 1,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Categories
CREATE TABLE categories (
  id INTEGER PRIMARY KEY,
  server_id INTEGER UNIQUE,
  parent_id INTEGER,
  name TEXT NOT NULL,
  synced INTEGER DEFAULT 1
);

-- Customers (Cached)
CREATE TABLE customers (
  id INTEGER PRIMARY KEY,
  server_id INTEGER UNIQUE,
  merchant_id INTEGER,
  name TEXT NOT NULL,
  email TEXT,
  phone TEXT,
  address TEXT,
  synced INTEGER DEFAULT 1,
  last_synced_at INTEGER,
  created_at INTEGER,
  updated_at INTEGER
);

-- Sales (Offline Queue)
CREATE TABLE sales (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  server_id INTEGER UNIQUE,  -- NULL until synced
  merchant_id INTEGER,
  customer_id INTEGER,
  sale_number TEXT UNIQUE,   -- Local: OFFLINE-{uuid}
  status TEXT DEFAULT 'draft',  -- draft, parked, completed, voided
  subtotal REAL DEFAULT 0,
  discount_type TEXT,
  discount_amount REAL DEFAULT 0,
  discount_value REAL DEFAULT 0,
  tax_rate REAL DEFAULT 0,
  tax_amount REAL DEFAULT 0,
  total_amount REAL DEFAULT 0,
  paid_amount REAL DEFAULT 0,
  change_amount REAL DEFAULT 0,
  park_name TEXT,
  notes TEXT,
  offline_id TEXT UNIQUE,    -- UUID for tracking
  synced INTEGER DEFAULT 0,  -- 0 = pending, 1 = synced
  sync_attempts INTEGER DEFAULT 0,
  last_sync_attempt INTEGER,
  created_by INTEGER,
  completed_by INTEGER,
  completed_at INTEGER,
  created_at INTEGER,
  updated_at INTEGER,
  FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Sale Items
CREATE TABLE sale_items (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  server_id INTEGER UNIQUE,
  sale_id INTEGER NOT NULL,
  product_id INTEGER,
  product_variation_id INTEGER,
  product_name TEXT NOT NULL,
  variation_name TEXT,
  sku TEXT,
  barcode TEXT,
  quantity REAL NOT NULL,
  unit_price REAL NOT NULL,
  unit_cost REAL,
  discount_type TEXT,
  discount_amount REAL DEFAULT 0,
  discount_value REAL DEFAULT 0,
  line_total REAL NOT NULL,
  notes TEXT,
  synced INTEGER DEFAULT 0,
  created_at INTEGER,
  updated_at INTEGER,
  FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (product_variation_id) REFERENCES product_variations(id)
);

-- Payments
CREATE TABLE payments (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  server_id INTEGER UNIQUE,
  merchant_id INTEGER,
  sale_id INTEGER NOT NULL,
  payment_method TEXT NOT NULL,  -- cash, card, wallet, bank_transfer
  amount REAL NOT NULL,
  tendered_amount REAL,
  change_given REAL DEFAULT 0,
  reference_number TEXT,
  metadata TEXT,  -- JSON string
  processed_by INTEGER,
  synced INTEGER DEFAULT 0,
  created_at INTEGER,
  FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE
);

-- Inventory Movements
CREATE TABLE inventory_movements (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  server_id INTEGER UNIQUE,
  product_id INTEGER NOT NULL,
  product_variation_id INTEGER,
  movement_type TEXT NOT NULL,  -- sale, adjustment, void
  quantity REAL NOT NULL,
  quantity_before REAL,
  quantity_after REAL,
  unit_cost REAL,
  reference_type TEXT,  -- 'sale', 'adjustment'
  reference_id INTEGER,
  notes TEXT,
  synced INTEGER DEFAULT 0,
  created_by INTEGER,
  created_at INTEGER,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Sync Queue (Track sync status)
CREATE TABLE sync_queue (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  entity_type TEXT NOT NULL,  -- 'sale', 'customer', 'product'
  entity_id INTEGER NOT NULL,
  action TEXT NOT NULL,  -- 'create', 'update', 'delete'
  payload TEXT,  -- JSON string
  priority INTEGER DEFAULT 0,  -- Higher = more urgent
  status TEXT DEFAULT 'pending',  -- pending, processing, completed, failed
  attempts INTEGER DEFAULT 0,
  last_attempt INTEGER,
  error_message TEXT,
  created_at INTEGER,
  updated_at INTEGER
);

-- Sync Log (Audit trail)
CREATE TABLE sync_log (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  sync_session_id TEXT,
  entity_type TEXT,
  entity_id INTEGER,
  action TEXT,
  status TEXT,  -- success, failed
  request_payload TEXT,
  response_data TEXT,
  error_message TEXT,
  duration_ms INTEGER,
  created_at INTEGER
);

-- Indexes for performance
CREATE INDEX idx_products_barcode ON products(barcode);
CREATE INDEX idx_products_sku ON products(sku);
CREATE INDEX idx_sales_synced ON sales(synced);
CREATE INDEX idx_sales_status ON sales(status);
CREATE INDEX idx_sync_queue_status ON sync_queue(status, priority);
CREATE INDEX idx_customers_phone ON customers(phone);
```

#### Database Initialization:
```javascript
// main/database/schema.js
const Database = require('better-sqlite3');
const path = require('path');
const { app } = require('electron');

class DatabaseManager {
  constructor() {
    const dbPath = path.join(app.getPath('userData'), 'pos_data.db');
    this.db = new Database(dbPath);
    this.db.pragma('journal_mode = WAL');  // Better concurrency
    this.initialize();
  }

  initialize() {
    // Create tables
    this.db.exec(/* SQL schema above */);

    // Set version
    this.db.prepare(
      'INSERT OR REPLACE INTO app_settings (key, value) VALUES (?, ?)'
    ).run('db_version', '1.0.0');
  }

  // Transaction wrapper
  transaction(fn) {
    return this.db.transaction(fn);
  }
}

module.exports = new DatabaseManager();
```

---

### 1.4 Sync Engine Architecture

#### Sync Strategy:

**1. Initial Sync (First Launch)**
- Download all products, categories, customers
- Cache locally with `synced = 1`
- Store `last_synced_at` timestamp

**2. Real-Time Sync (When Online)**
- Monitor network status (`navigator.onLine` + periodic API ping)
- Process sync queue every 30 seconds
- Batch operations for efficiency

**3. Conflict Resolution**
- **Server Wins**: For product/customer data
- **Client Wins**: For completed sales (immutable once saved)
- **Merge Strategy**: For inventory (use movements, not absolute values)

#### Sync Manager Implementation:

```javascript
// main/sync/syncManager.js
class SyncManager {
  constructor(apiClient, dbManager) {
    this.api = apiClient;
    this.db = dbManager;
    this.isSyncing = false;
    this.syncInterval = null;
  }

  async startAutoSync() {
    // Check connectivity
    this.syncInterval = setInterval(async () => {
      if (await this.isOnline() && !this.isSyncing) {
        await this.performSync();
      }
    }, 30000);  // Every 30 seconds
  }

  async performSync() {
    this.isSyncing = true;
    const sessionId = Date.now().toString();

    try {
      // 1. Pull changes from server (products, customers)
      await this.pullServerData();

      // 2. Push local changes (sales, payments, inventory)
      await this.pushLocalChanges(sessionId);

      // 3. Update sync status
      this.updateLastSyncTime();

    } catch (error) {
      console.error('Sync failed:', error);
      this.logSyncError(sessionId, error);
    } finally {
      this.isSyncing = false;
    }
  }

  async pushLocalChanges(sessionId) {
    // Get all unsynced records
    const pendingQueue = this.db.prepare(
      'SELECT * FROM sync_queue WHERE status = ? ORDER BY priority DESC, created_at ASC'
    ).all('pending');

    for (const item of pendingQueue) {
      try {
        await this.syncQueueItem(item, sessionId);
      } catch (error) {
        this.handleSyncError(item, error);
      }
    }
  }

  async syncQueueItem(item, sessionId) {
    const { entity_type, entity_id, action, payload } = item;

    switch (entity_type) {
      case 'sale':
        return await this.syncSale(entity_id, action, payload, sessionId);
      case 'customer':
        return await this.syncCustomer(entity_id, action, sessionId);
      case 'inventory_movement':
        return await this.syncInventoryMovement(entity_id, sessionId);
    }
  }

  async syncSale(saleId, action, payload, sessionId) {
    const sale = this.getSaleWithItems(saleId);

    if (action === 'create') {
      // POST to /api/pos/sales/sync
      const response = await this.api.post('/pos/sales/sync', {
        offline_id: sale.offline_id,
        sale: sale,
        items: sale.items,
        payments: sale.payments,
        inventory_movements: sale.inventory_movements
      });

      // Update local record with server ID
      this.db.prepare('UPDATE sales SET server_id = ?, synced = 1 WHERE id = ?')
        .run(response.data.id, saleId);

      // Mark items as synced
      this.db.prepare('UPDATE sale_items SET synced = 1 WHERE sale_id = ?')
        .run(saleId);

      // Mark payments as synced
      this.db.prepare('UPDATE payments SET synced = 1 WHERE sale_id = ?')
        .run(saleId);

      // Remove from queue
      this.db.prepare('DELETE FROM sync_queue WHERE entity_type = ? AND entity_id = ?')
        .run('sale', saleId);

      this.logSyncSuccess(sessionId, 'sale', saleId);
    }
  }

  async pullServerData() {
    const lastSync = this.getLastSyncTime();

    // Get updated products
    const products = await this.api.get('/pos/sync/products', {
      params: { updated_after: lastSync }
    });
    this.updateProducts(products.data);

    // Get updated customers
    const customers = await this.api.get('/pos/sync/customers', {
      params: { updated_after: lastSync }
    });
    this.updateCustomers(customers.data);
  }
}
```

---

### 1.5 POS Interface (Vue Components)

**Copy existing components with modifications:**

#### PosMain.vue Adaptations:
```javascript
// Key changes for offline operation:

// 1. Use local database instead of API calls
import { ipcRenderer } from 'electron';

export default {
  setup() {
    const posStore = usePosStore();

    // Load products from local DB
    const loadProducts = async () => {
      const products = await window.electronAPI.pos.getProducts({
        search: searchQuery.value,
        category_id: selectedCategory.value
      });
      return products;
    };

    // Save sale to local DB (offline queue)
    const completeSale = async () => {
      const saleData = {
        ...currentCart.value,
        offline_id: generateUUID(),
        synced: 0,
        created_at: Date.now()
      };

      const saleId = await window.electronAPI.pos.createSale(saleData);

      // Add to sync queue
      await window.electronAPI.sync.queueSync('sale', saleId, 'create');

      // Show success
      showNotification('Sale saved! Will sync when online.');
    };

    return {
      loadProducts,
      completeSale
    };
  }
};
```

#### SyncStatus.vue (New Component):
```vue
<template>
  <div class="sync-status" :class="statusClass">
    <div class="flex items-center gap-2">
      <!-- Online indicator -->
      <div class="status-dot" :class="{ 'online': isOnline, 'offline': !isOnline }"></div>

      <!-- Status text -->
      <span v-if="isOnline && !isSyncing">Online</span>
      <span v-else-if="isOnline && isSyncing">Syncing...</span>
      <span v-else>Offline</span>

      <!-- Pending count -->
      <span v-if="pendingCount > 0" class="badge">
        {{ pendingCount }} pending
      </span>

      <!-- Last sync time -->
      <span v-if="lastSyncTime" class="text-xs text-gray-500">
        Last synced: {{ formatTime(lastSyncTime) }}
      </span>

      <!-- Manual sync button -->
      <button @click="manualSync" :disabled="!isOnline || isSyncing">
        <RefreshIcon class="w-4 h-4" />
      </button>
    </div>

    <!-- Sync progress -->
    <div v-if="isSyncing" class="sync-progress">
      <div class="progress-bar" :style="{ width: syncProgress + '%' }"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const isOnline = ref(navigator.onLine);
const isSyncing = ref(false);
const pendingCount = ref(0);
const lastSyncTime = ref(null);
const syncProgress = ref(0);

// Listen for sync events from main process
onMounted(() => {
  window.electronAPI.sync.onStatusChange((status) => {
    isOnline.value = status.online;
    isSyncing.value = status.syncing;
    pendingCount.value = status.pending;
    lastSyncTime.value = status.lastSync;
    syncProgress.value = status.progress;
  });

  // Update pending count
  updatePendingCount();
  setInterval(updatePendingCount, 10000);
});

const updatePendingCount = async () => {
  const count = await window.electronAPI.sync.getPendingCount();
  pendingCount.value = count;
};

const manualSync = async () => {
  await window.electronAPI.sync.triggerSync();
};
</script>
```

---

### 1.6 Key Electron Main Process Services

#### Auth Service:
```javascript
// main/services/authService.js
const Store = require('electron-store');
const store = new Store({ encryptionKey: 'your-secret-key' });

class AuthService {
  async login(apiUrl, credentials) {
    try {
      const response = await axios.post(`${apiUrl}/auth/login`, credentials);

      const tokenData = {
        access_token: response.data.token,
        expires_at: Date.now() + (response.data.expires_in * 1000),
        user: response.data.user,
        api_url: apiUrl
      };

      store.set('auth', tokenData);
      return { success: true, user: response.data.user };
    } catch (error) {
      return { success: false, error: error.message };
    }
  }

  async logout() {
    store.delete('auth');
  }

  getToken() {
    const auth = store.get('auth');
    if (!auth) return null;

    // Check expiry
    if (Date.now() > auth.expires_at) {
      this.logout();
      return null;
    }

    return auth.access_token;
  }

  isAuthenticated() {
    return this.getToken() !== null;
  }

  getUser() {
    const auth = store.get('auth');
    return auth?.user || null;
  }
}

module.exports = new AuthService();
```

#### Sale Service:
```javascript
// main/services/saleService.js
const db = require('../database/schema');
const { v4: uuidv4 } = require('uuid');

class SaleService {
  createSale(saleData) {
    return db.transaction(() => {
      // Insert sale
      const saleId = db.prepare(`
        INSERT INTO sales (
          merchant_id, customer_id, sale_number, status,
          subtotal, discount_type, discount_amount, discount_value,
          tax_rate, tax_amount, total_amount,
          paid_amount, change_amount, notes,
          offline_id, synced, created_by, completed_by, completed_at,
          created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
      `).run(
        saleData.merchant_id,
        saleData.customer_id,
        `OFFLINE-${uuidv4().substr(0, 8)}`,
        saleData.status || 'completed',
        saleData.subtotal,
        saleData.discount_type,
        saleData.discount_amount,
        saleData.discount_value,
        saleData.tax_rate,
        saleData.tax_amount,
        saleData.total_amount,
        saleData.paid_amount,
        saleData.change_amount,
        saleData.notes,
        saleData.offline_id || uuidv4(),
        0,  // Not synced
        saleData.created_by,
        saleData.completed_by,
        saleData.completed_at || Date.now(),
        Date.now(),
        Date.now()
      ).lastInsertRowid;

      // Insert items
      for (const item of saleData.items) {
        this.addSaleItem(saleId, item);
      }

      // Insert payments
      for (const payment of saleData.payments) {
        this.addPayment(saleId, payment);
      }

      // Update inventory
      this.updateInventory(saleId, saleData.items);

      return saleId;
    })();
  }

  addSaleItem(saleId, item) {
    db.prepare(`
      INSERT INTO sale_items (
        sale_id, product_id, product_variation_id,
        product_name, variation_name, sku, barcode,
        quantity, unit_price, unit_cost,
        discount_type, discount_amount, discount_value,
        line_total, notes, synced, created_at, updated_at
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `).run(
      saleId,
      item.product_id,
      item.product_variation_id,
      item.product_name,
      item.variation_name,
      item.sku,
      item.barcode,
      item.quantity,
      item.unit_price,
      item.unit_cost,
      item.discount_type,
      item.discount_amount,
      item.discount_value,
      item.line_total,
      item.notes,
      0,  // Not synced
      Date.now(),
      Date.now()
    );
  }

  updateInventory(saleId, items) {
    for (const item of items) {
      const table = item.product_variation_id ? 'product_variations' : 'products';
      const idField = item.product_variation_id ? 'id' : 'id';
      const idValue = item.product_variation_id || item.product_id;

      // Get current stock
      const current = db.prepare(
        `SELECT stock_quantity FROM ${table} WHERE ${idField} = ?`
      ).get(idValue);

      const newStock = current.stock_quantity - item.quantity;

      // Update stock
      db.prepare(
        `UPDATE ${table} SET stock_quantity = ?, updated_at = ? WHERE ${idField} = ?`
      ).run(newStock, Date.now(), idValue);

      // Log movement
      db.prepare(`
        INSERT INTO inventory_movements (
          product_id, product_variation_id, movement_type,
          quantity, quantity_before, quantity_after,
          unit_cost, reference_type, reference_id,
          synced, created_by, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
      `).run(
        item.product_id,
        item.product_variation_id,
        'sale',
        -item.quantity,
        current.stock_quantity,
        newStock,
        item.unit_cost,
        'sale',
        saleId,
        0,  // Not synced
        item.created_by,
        Date.now()
      );
    }
  }

  getSales(filters = {}) {
    let query = 'SELECT * FROM sales WHERE 1=1';
    const params = [];

    if (filters.status) {
      query += ' AND status = ?';
      params.push(filters.status);
    }

    if (filters.start_date) {
      query += ' AND created_at >= ?';
      params.push(filters.start_date);
    }

    if (filters.end_date) {
      query += ' AND created_at <= ?';
      params.push(filters.end_date);
    }

    query += ' ORDER BY created_at DESC LIMIT ? OFFSET ?';
    params.push(filters.limit || 50, filters.offset || 0);

    return db.prepare(query).all(...params);
  }

  getSaleById(saleId) {
    const sale = db.prepare('SELECT * FROM sales WHERE id = ?').get(saleId);

    if (sale) {
      sale.items = db.prepare('SELECT * FROM sale_items WHERE sale_id = ?').all(saleId);
      sale.payments = db.prepare('SELECT * FROM payments WHERE sale_id = ?').all(saleId);
    }

    return sale;
  }
}

module.exports = new SaleService();
```

---

### 1.7 IPC Handlers (Main Process)

```javascript
// main/index.js
const { app, BrowserWindow, ipcMain } = require('electron');
const authService = require('./services/authService');
const saleService = require('./services/saleService');
const productService = require('./services/productService');
const syncManager = require('./sync/syncManager');

// Auth handlers
ipcMain.handle('auth:login', async (event, { apiUrl, credentials }) => {
  return await authService.login(apiUrl, credentials);
});

ipcMain.handle('auth:logout', async () => {
  return await authService.logout();
});

ipcMain.handle('auth:getToken', () => {
  return authService.getToken();
});

ipcMain.handle('auth:isAuthenticated', () => {
  return authService.isAuthenticated();
});

// POS handlers
ipcMain.handle('pos:getProducts', async (event, filters) => {
  return productService.getProducts(filters);
});

ipcMain.handle('pos:getProductByBarcode', async (event, barcode) => {
  return productService.getByBarcode(barcode);
});

ipcMain.handle('pos:createSale', async (event, saleData) => {
  const saleId = saleService.createSale(saleData);

  // Add to sync queue
  await syncManager.queueForSync('sale', saleId, 'create');

  return saleId;
});

ipcMain.handle('pos:getSales', async (event, filters) => {
  return saleService.getSales(filters);
});

ipcMain.handle('pos:getSaleById', async (event, saleId) => {
  return saleService.getSaleById(saleId);
});

// Sync handlers
ipcMain.handle('sync:getPendingCount', async () => {
  return syncManager.getPendingCount();
});

ipcMain.handle('sync:triggerSync', async () => {
  return await syncManager.performSync();
});

ipcMain.handle('sync:getStatus', () => {
  return syncManager.getStatus();
});

// Network status monitoring
const { net } = require('electron');
setInterval(() => {
  const online = net.isOnline();
  BrowserWindow.getAllWindows().forEach(win => {
    win.webContents.send('network:status', online);
  });
}, 5000);

// Start sync manager
app.whenReady().then(() => {
  syncManager.startAutoSync();
});
```

---

### 1.8 Preload Script (Security Bridge)

```javascript
// preload/index.js
const { contextBridge, ipcRenderer } = require('electron');

contextBridge.exposeInMainWorld('electronAPI', {
  // Auth APIs
  auth: {
    login: (apiUrl, credentials) => ipcRenderer.invoke('auth:login', { apiUrl, credentials }),
    logout: () => ipcRenderer.invoke('auth:logout'),
    getToken: () => ipcRenderer.invoke('auth:getToken'),
    isAuthenticated: () => ipcRenderer.invoke('auth:isAuthenticated')
  },

  // POS APIs
  pos: {
    getProducts: (filters) => ipcRenderer.invoke('pos:getProducts', filters),
    getProductByBarcode: (barcode) => ipcRenderer.invoke('pos:getProductByBarcode', barcode),
    createSale: (saleData) => ipcRenderer.invoke('pos:createSale', saleData),
    getSales: (filters) => ipcRenderer.invoke('pos:getSales', filters),
    getSaleById: (saleId) => ipcRenderer.invoke('pos:getSaleById', saleId),
    parkSale: (saleId) => ipcRenderer.invoke('pos:parkSale', saleId),
    unparkSale: (saleId) => ipcRenderer.invoke('pos:unparkSale', saleId)
  },

  // Customer APIs
  customer: {
    search: (query) => ipcRenderer.invoke('customer:search', query),
    create: (customerData) => ipcRenderer.invoke('customer:create', customerData),
    getById: (id) => ipcRenderer.invoke('customer:getById', id)
  },

  // Sync APIs
  sync: {
    getPendingCount: () => ipcRenderer.invoke('sync:getPendingCount'),
    triggerSync: () => ipcRenderer.invoke('sync:triggerSync'),
    getStatus: () => ipcRenderer.invoke('sync:getStatus'),
    onStatusChange: (callback) => {
      ipcRenderer.on('sync:statusChanged', (event, status) => callback(status));
    }
  },

  // Network monitoring
  network: {
    onStatusChange: (callback) => {
      ipcRenderer.on('network:status', (event, online) => callback(online));
    }
  },

  // Printer APIs
  printer: {
    print: (receiptHtml) => ipcRenderer.invoke('printer:print', receiptHtml),
    getPrinters: () => ipcRenderer.invoke('printer:getPrinters')
  }
});
```

---

## 🔧 Phase 2: Backend API Development

### 2.1 New API Endpoints Required

#### Authentication API
```php
POST /api/auth/login
- Body: { email, password }
- Response: { token, expires_in, user: { id, name, email, merchant_id, role } }

POST /api/auth/refresh
- Body: { refresh_token }
- Response: { token, expires_in }

POST /api/auth/logout
- Headers: Authorization: Bearer {token}
- Response: { success: true }

GET /api/auth/me
- Headers: Authorization: Bearer {token}
- Response: { user: {...} }
```

#### Sync API (Batch Operations)
```php
POST /dashboard/api/pos/sync/sales
- Batch upload multiple sales
- Body: { sales: [{ offline_id, sale_data, items, payments }] }
- Response: { synced: [{ offline_id, server_id }], errors: [] }

GET /dashboard/api/pos/sync/products
- Get products updated after timestamp
- Query: ?updated_after=1706789123
- Response: { products: [...], has_more: false }

GET /dashboard/api/pos/sync/customers
- Get customers updated after timestamp
- Query: ?updated_after=1706789123
- Response: { customers: [...], has_more: false }

GET /dashboard/api/pos/sync/status
- Check server status and connectivity
- Response: { status: 'online', server_time: 1706789123 }
```

#### Conflict Resolution API
```php
POST /dashboard/api/pos/sync/resolve-conflict
- Body: { entity_type, entity_id, client_version, server_version, resolution }
- Response: { resolved: true, merged_data: {...} }
```

---

### 2.2 Backend Controllers (New)

#### AuthController.php
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        // Check if user has POS permission
        if (!$user->hasPermissionTo('pos')) {
            return response()->json([
                'message' => 'Unauthorized. POS access required.'
            ], 403);
        }

        // Create token
        $token = $user->createToken('pos-app', ['pos:access'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'expires_in' => config('sanctum.expiration', 525600),  // 1 year default
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'merchant_id' => $user->merchant_id,
                'role' => $user->roles->first()->name ?? 'user'
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    public function refresh(Request $request)
    {
        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $token = $request->user()->createToken('pos-app', ['pos:access'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'expires_in' => config('sanctum.expiration', 525600)
        ]);
    }
}
```

#### PosSyncController.php
```php
<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Pos\PosSyncService;
use App\Models\Pos\PosSale;
use App\Models\Product;
use App\Models\Customer;

class PosSyncController extends Controller
{
    protected $syncService;

    public function __construct(PosSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Batch sync sales from offline app
     */
    public function syncSales(Request $request)
    {
        $request->validate([
            'sales' => 'required|array',
            'sales.*.offline_id' => 'required|string',
            'sales.*.sale' => 'required|array',
            'sales.*.items' => 'required|array',
            'sales.*.payments' => 'required|array'
        ]);

        $results = [
            'synced' => [],
            'errors' => []
        ];

        foreach ($request->sales as $saleData) {
            try {
                // Check if already synced
                $existing = PosSale::where('offline_id', $saleData['offline_id'])->first();

                if ($existing) {
                    $results['synced'][] = [
                        'offline_id' => $saleData['offline_id'],
                        'server_id' => $existing->id,
                        'status' => 'already_exists'
                    ];
                    continue;
                }

                // Create sale with items and payments
                $sale = $this->syncService->createSaleFromOffline($saleData);

                $results['synced'][] = [
                    'offline_id' => $saleData['offline_id'],
                    'server_id' => $sale->id,
                    'status' => 'created'
                ];

            } catch (\Exception $e) {
                $results['errors'][] = [
                    'offline_id' => $saleData['offline_id'],
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json($results);
    }

    /**
     * Get products updated after timestamp
     */
    public function getUpdatedProducts(Request $request)
    {
        $updatedAfter = $request->query('updated_after', 0);
        $limit = $request->query('limit', 500);

        $products = Product::with(['variations', 'category'])
            ->where('merchant_id', auth()->user()->merchant_id)
            ->where('updated_at', '>', date('Y-m-d H:i:s', $updatedAfter / 1000))
            ->where('is_active', true)
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
                    'price' => $product->price,
                    'cost' => $product->cost,
                    'stock_quantity' => $product->stock_quantity,
                    'low_stock_threshold' => $product->low_stock_threshold,
                    'image_url' => $product->image_url,
                    'has_variations' => $product->variations->count() > 0,
                    'variations' => $product->variations->map(function ($variation) {
                        return [
                            'id' => $variation->id,
                            'name' => $variation->name,
                            'sku' => $variation->sku,
                            'barcode' => $variation->barcode,
                            'price' => $variation->price,
                            'cost' => $variation->cost,
                            'stock_quantity' => $variation->stock_quantity
                        ];
                    }),
                    'updated_at' => $product->updated_at->timestamp * 1000
                ];
            });

        return response()->json([
            'products' => $products,
            'has_more' => $products->count() === $limit,
            'last_updated' => now()->timestamp * 1000
        ]);
    }

    /**
     * Get customers updated after timestamp
     */
    public function getUpdatedCustomers(Request $request)
    {
        $updatedAfter = $request->query('updated_after', 0);
        $limit = $request->query('limit', 500);

        $customers = Customer::where('merchant_id', auth()->user()->merchant_id)
            ->where('updated_at', '>', date('Y-m-d H:i:s', $updatedAfter / 1000))
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

        return response()->json([
            'customers' => $customers,
            'has_more' => $customers->count() === $limit,
            'last_updated' => now()->timestamp * 1000
        ]);
    }

    /**
     * Health check endpoint
     */
    public function status()
    {
        return response()->json([
            'status' => 'online',
            'server_time' => now()->timestamp * 1000,
            'version' => config('app.version', '1.0.0')
        ]);
    }
}
```

#### PosSyncService.php
```php
<?php

namespace App\Services\Pos;

use App\Models\Pos\PosSale;
use App\Models\Pos\PosSaleItem;
use App\Models\Pos\PosPayment;
use App\Models\Pos\PosInventoryMovement;
use Illuminate\Support\Facades\DB;

class PosSyncService
{
    /**
     * Create sale from offline data
     */
    public function createSaleFromOffline(array $data)
    {
        return DB::transaction(function () use ($data) {
            $saleData = $data['sale'];

            // Create sale
            $sale = PosSale::create([
                'merchant_id' => auth()->user()->merchant_id,
                'customer_id' => $saleData['customer_id'] ?? null,
                'sale_number' => $this->generateSaleNumber(),
                'status' => $saleData['status'],
                'subtotal' => $saleData['subtotal'],
                'discount_type' => $saleData['discount_type'],
                'discount_amount' => $saleData['discount_amount'],
                'discount_value' => $saleData['discount_value'],
                'tax_rate' => $saleData['tax_rate'],
                'tax_amount' => $saleData['tax_amount'],
                'total_amount' => $saleData['total_amount'],
                'paid_amount' => $saleData['paid_amount'],
                'change_amount' => $saleData['change_amount'],
                'notes' => $saleData['notes'] ?? null,
                'offline_id' => $saleData['offline_id'],
                'synced' => true,
                'created_by' => auth()->id(),
                'completed_by' => auth()->id(),
                'completed_at' => isset($saleData['completed_at'])
                    ? date('Y-m-d H:i:s', $saleData['completed_at'] / 1000)
                    : now(),
                'created_at' => isset($saleData['created_at'])
                    ? date('Y-m-d H:i:s', $saleData['created_at'] / 1000)
                    : now()
            ]);

            // Create items
            foreach ($data['items'] as $itemData) {
                PosSaleItem::create([
                    'pos_sale_id' => $sale->id,
                    'product_id' => $itemData['product_id'],
                    'product_variation_id' => $itemData['product_variation_id'] ?? null,
                    'product_name' => $itemData['product_name'],
                    'variation_name' => $itemData['variation_name'] ?? null,
                    'sku' => $itemData['sku'],
                    'barcode' => $itemData['barcode'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'unit_cost' => $itemData['unit_cost'],
                    'discount_type' => $itemData['discount_type'] ?? null,
                    'discount_amount' => $itemData['discount_amount'] ?? 0,
                    'discount_value' => $itemData['discount_value'] ?? 0,
                    'line_total' => $itemData['line_total'],
                    'notes' => $itemData['notes'] ?? null
                ]);
            }

            // Create payments
            foreach ($data['payments'] as $paymentData) {
                PosPayment::create([
                    'merchant_id' => auth()->user()->merchant_id,
                    'pos_sale_id' => $sale->id,
                    'payment_method' => $paymentData['payment_method'],
                    'amount' => $paymentData['amount'],
                    'tendered_amount' => $paymentData['tendered_amount'] ?? null,
                    'change_given' => $paymentData['change_given'] ?? 0,
                    'reference_number' => $paymentData['reference_number'] ?? null,
                    'metadata' => isset($paymentData['metadata']) ? json_encode($paymentData['metadata']) : null,
                    'processed_by' => auth()->id()
                ]);
            }

            // Sync inventory movements (if provided)
            if (isset($data['inventory_movements'])) {
                foreach ($data['inventory_movements'] as $movementData) {
                    PosInventoryMovement::create([
                        'merchant_id' => auth()->user()->merchant_id,
                        'product_id' => $movementData['product_id'],
                        'product_variation_id' => $movementData['product_variation_id'] ?? null,
                        'movement_type' => $movementData['movement_type'],
                        'quantity' => $movementData['quantity'],
                        'quantity_before' => $movementData['quantity_before'],
                        'quantity_after' => $movementData['quantity_after'],
                        'unit_cost' => $movementData['unit_cost'],
                        'reference_type' => 'App\\Models\\Pos\\PosSale',
                        'reference_id' => $sale->id,
                        'notes' => $movementData['notes'] ?? null,
                        'created_by' => auth()->id()
                    ]);
                }
            }

            return $sale;
        });
    }

    /**
     * Generate unique sale number
     */
    protected function generateSaleNumber()
    {
        $lastSale = PosSale::where('merchant_id', auth()->user()->merchant_id)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastSale ? intval(substr($lastSale->sale_number, 4)) + 1 : 1;

        return 'POS-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
```

---

### 2.3 API Routes (routes/api.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Pos\PosSyncController;

// Public auth routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
});

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // POS Sync (keep existing POS routes in web.php)
    Route::prefix('pos/sync')->group(function () {
        Route::get('/status', [PosSyncController::class, 'status']);
        Route::post('/sales', [PosSyncController::class, 'syncSales']);
        Route::get('/products', [PosSyncController::class, 'getUpdatedProducts']);
        Route::get('/customers', [PosSyncController::class, 'getUpdatedCustomers']);
    });
});
```

---

### 2.4 Database Migrations (New)

#### Add offline_id to pos_sales table:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pos_sales', function (Blueprint $table) {
            $table->string('offline_id')->unique()->nullable()->after('notes');
            $table->boolean('synced')->default(true)->after('offline_id');
            $table->integer('sync_attempts')->default(0)->after('synced');
        });
    }

    public function down()
    {
        Schema::table('pos_sales', function (Blueprint $table) {
            $table->dropColumn(['offline_id', 'synced', 'sync_attempts']);
        });
    }
};
```

---

## 🔒 Security Considerations

### 1. Token Storage
- Use `electron-store` with encryption
- Never store tokens in plain text
- Implement token refresh mechanism
- Clear tokens on logout

### 2. API Security
- Laravel Sanctum for API authentication
- Rate limiting on login endpoint
- HTTPS only in production
- CORS configuration for Electron origin

### 3. Database Security
- Encrypt SQLite database (better-sqlite3-cipher)
- Secure file permissions on userData directory
- Backup mechanism for local data

### 4. Code Signing
- Sign Electron app for Windows/Mac
- Implement auto-update with signature verification

---

## 🚀 Implementation Timeline

### Phase 1: Electron App Core (2-3 weeks)

**Week 1: Foundation**
- ✅ Project setup (Electron + Vue + Vite)
- ✅ SQLite database schema
- ✅ Login page with API configuration
- ✅ Token storage and auth service

**Week 2: POS Interface**
- ✅ Port existing Vue components
- ✅ Implement local database operations
- ✅ Product search and cart functionality
- ✅ Payment processing (offline)

**Week 3: Sync Engine**
- ✅ Network monitoring
- ✅ Sync queue implementation
- ✅ Background sync service
- ✅ Conflict resolution logic
- ✅ Testing offline/online transitions

---

### Phase 2: Backend API (1-2 weeks)

**Week 1: Auth & Sync APIs**
- ✅ Auth controller (login/logout/refresh)
- ✅ Sync controller (batch operations)
- ✅ PosSyncService implementation
- ✅ API routes and middleware

**Week 2: Testing & Integration**
- ✅ API testing (Postman/PHPUnit)
- ✅ End-to-end sync testing
- ✅ Error handling and logging
- ✅ Performance optimization

---

## ✅ Feature Parity Checklist

### Core POS Features
- [ ] Product search and barcode scanning
- [ ] Category filtering
- [ ] Shopping cart with multi-tab support
- [ ] Product variations
- [ ] Item and sale-level discounts
- [ ] Customer selection and creation
- [ ] Multiple payment methods
- [ ] Split payments
- [ ] Park/resume sales
- [ ] Receipt printing (HTML + thermal)
- [ ] Sales history
- [ ] Refunds (full and partial)
- [ ] Void sales
- [ ] Keyboard shortcuts (F1-F9)
- [ ] Low stock warnings
- [ ] Stock quantity display

### Offline Features
- [ ] Work fully without internet
- [ ] Local SQLite database
- [ ] Offline queue for sales
- [ ] Automatic sync when online
- [ ] Network status indicator
- [ ] Manual sync button
- [ ] Pending transaction counter
- [ ] Last sync timestamp
- [ ] Sync progress indicator
- [ ] Error handling and retry logic

### Settings
- [ ] Tax rate configuration
- [ ] Receipt customization
- [ ] Payment method enablement
- [ ] Inventory settings (FIFO/Average)
- [ ] Auto-print receipts
- [ ] Keyboard shortcuts reference

### Reports (Optional for Phase 1)
- [ ] Daily sales summary
- [ ] Product sales report
- [ ] Payment method breakdown
- [ ] Inventory movements

---

## 📦 Build & Distribution

### Development:
```bash
npm run dev          # Start dev server
npm run build        # Build for production
```

### Production Build:
```bash
npm run build:win    # Windows installer
npm run build:mac    # macOS DMG
npm run build:linux  # Linux AppImage
```

### Auto-Update (Optional):
- Implement electron-updater
- Host updates on S3 or GitHub Releases
- In-app update notifications

---

## 📚 Documentation

### User Documentation:
1. Installation guide
2. First-time setup (API configuration)
3. Login instructions
4. Offline mode explanation
5. Troubleshooting guide
6. Keyboard shortcuts reference

### Developer Documentation:
1. Architecture overview
2. Database schema
3. Sync algorithm explanation
4. API reference
5. Build instructions
6. Deployment guide

---

## 🎨 UI/UX Considerations

### Offline Indicators:
- Persistent status bar showing online/offline state
- Toast notifications for sync events
- Color-coded badges (green = online, red = offline, yellow = syncing)

### Performance:
- Virtual scrolling for large product lists (vue-virtual-scroller)
- Debounced search input
- Lazy loading of product images
- Pagination for sales history

### Accessibility:
- Keyboard navigation
- Screen reader support
- High contrast mode
- Adjustable font sizes

---

## 🧪 Testing Strategy

### Unit Tests:
- Database operations
- Sync logic
- Auth service
- Sale calculations

### Integration Tests:
- End-to-end sale flow
- Offline → Online sync
- Conflict resolution
- API integration

### Manual Testing:
- Network interruption scenarios
- Large sale volumes
- Edge cases (negative stock, refunds, voids)
- Cross-platform compatibility

---

## 📋 Pre-Launch Checklist

- [ ] All features tested and working
- [ ] Database migrations tested
- [ ] API endpoints secured and tested
- [ ] Error logging implemented
- [ ] User documentation completed
- [ ] Installer packages created
- [ ] Code signed for Windows/Mac
- [ ] Backup/restore functionality
- [ ] Support for multiple users (if required)
- [ ] License validation (if commercial)

---

## 🔧 Tech Stack Summary

| Component | Technology |
|-----------|------------|
| **Desktop Framework** | Electron 28+ |
| **Frontend** | Vue 3 + Vite |
| **State Management** | Pinia |
| **UI Framework** | Tailwind CSS + Heroicons |
| **Local Database** | Better-SQLite3 |
| **HTTP Client** | Axios |
| **Backend Framework** | Laravel 10/11 |
| **Backend Database** | MySQL/PostgreSQL |
| **API Auth** | Laravel Sanctum |
| **Build Tool** | Electron Builder |
| **Testing** | Vitest (frontend), PHPUnit (backend) |

---

## 📞 Support & Maintenance

### Post-Launch:
- Monitor sync errors via logging service
- Collect user feedback
- Regular updates for bug fixes
- Feature enhancements based on usage

### Monitoring:
- API request logging
- Sync failure alerts
- Performance metrics
- Crash reporting (Sentry or similar)

---

## 🎯 Success Metrics

- **Uptime**: 99.9% offline availability
- **Sync Time**: < 5 seconds for 10 sales
- **Sync Success Rate**: > 99%
- **App Startup Time**: < 3 seconds
- **Sale Completion Time**: < 30 seconds average
- **User Satisfaction**: > 4.5/5 stars

---

## 📝 Notes

1. **Backup Strategy**: Implement daily automatic backups of local SQLite database to user-specified location or cloud storage.

2. **Multi-Device**: If same merchant needs multiple POS devices, ensure sync doesn't cause conflicts (use unique device_id).

3. **Offline Limit**: Consider limiting offline duration (e.g., warn after 7 days) to prevent excessive queue buildup.

4. **Data Retention**: Local database cleanup after successful sync (configurable retention period).

5. **Audit Trail**: Maintain sync logs for troubleshooting (keep last 30 days).

6. **Thermal Printer**: Research USB thermal printer libraries for Node.js (node-thermal-printer).

7. **Barcode Scanner**: Test with USB barcode scanners (usually work as keyboard input).

8. **Cash Drawer**: Optional integration via printer kick-out drawer command.

---

## 🚀 Getting Started (Development)

### Prerequisites:
```bash
- Node.js 18+
- npm or yarn
- Git
- Code editor (VS Code recommended)
```

### Setup:
```bash
# Clone repository
git clone <repo-url>
cd electron-pos

# Install dependencies
npm install

# Start development
npm run dev

# Build for production
npm run build
```

### Environment Variables:
```env
# .env.local
VITE_DEFAULT_API_URL=https://yourdomain.com/dashboard/api
VITE_APP_NAME=POS System
VITE_APP_VERSION=1.0.0
```

---

## 📖 Appendix

### A. SQLite Performance Tips
- Use WAL mode for better concurrency
- Add indexes on frequently queried columns
- Use prepared statements
- Batch inserts in transactions

### B. Electron Security Best Practices
- Enable context isolation
- Disable node integration in renderer
- Use preload scripts for IPC
- Validate all IPC messages
- Keep Electron updated

### C. Conflict Resolution Strategies

**Strategy 1: Server Wins (Products, Customers)**
- Always accept server data for master records
- Overwrite local cache

**Strategy 2: Client Wins (Sales)**
- Sales are immutable once completed
- Server cannot reject valid sales
- Use unique offline_id to prevent duplicates

**Strategy 3: Merge (Inventory)**
- Use movement-based tracking
- Apply deltas, not absolute values
- Detect and flag anomalies

---

**END OF DOCUMENT**

---

## Quick Reference Card

### Key Files to Create:
1. `electron-pos/src/main/index.js` - Main process entry
2. `electron-pos/src/main/database/schema.js` - Database schema
3. `electron-pos/src/main/sync/syncManager.js` - Sync engine
4. `electron-pos/src/renderer/src/components/auth/LoginPage.vue` - Login UI
5. `electron-pos/src/renderer/src/stores/authStore.js` - Auth state
6. `electron-pos/src/preload/index.js` - IPC bridge
7. `app/Http/Controllers/Api/AuthController.php` - Backend auth
8. `app/Http/Controllers/Pos/PosSyncController.php` - Backend sync
9. `app/Services/Pos/PosSyncService.php` - Sync business logic
10. `routes/api.php` - API routes

### Key Commands:
```bash
# Electron App
npm run dev              # Development
npm run build:win        # Build Windows
npm run build:mac        # Build macOS

# Laravel Backend
php artisan migrate      # Run migrations
php artisan test         # Run tests
php artisan serve        # Start server
```

### Next Steps:
1. ✅ Review this plan
2. ✅ Set up Electron project structure
3. ✅ Implement authentication
4. ✅ Build local database layer
5. ✅ Port POS UI components
6. ✅ Implement sync engine
7. ✅ Develop backend APIs
8. ✅ Test offline/online scenarios
9. ✅ Build and distribute

---

**Project Plan Version**: 1.0
**Last Updated**: January 31, 2026
**Author**: Development Team
**Status**: Ready for Implementation
