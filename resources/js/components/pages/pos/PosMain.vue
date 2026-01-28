<template>
    <div class="pos-container" @keydown="handleKeydown">
        <!-- Offline Indicator -->
        <div v-if="!isOnline" class="offline-banner">
            <i class="fas fa-wifi-slash"></i> وضع عدم الاتصال - سيتم مزامنة المبيعات عند الاتصال
        </div>

        <!-- Top Bar -->
        <div class="pos-topbar">
            <div class="pos-topbar-left">
                <h4><i class="fas fa-cash-register"></i> نقطة البيع</h4>
            </div>
            <div class="pos-topbar-center">
                <!-- Multi-Cart Tabs -->
                <div class="cart-tabs">
                    <div
                        v-for="(cart, index) in carts"
                        :key="cart.id || index"
                        class="cart-tab"
                        :class="{ active: currentCartIndex === index }"
                        @click="switchCart(index)"
                    >
                        <span>سلة {{ index + 1 }}</span>
                        <span v-if="cart.items.length" class="item-count">{{ cart.items.length }}</span>
                        <button v-if="carts.length > 1" class="close-cart" @click.stop="closeCart(index)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button class="new-cart-btn" @click="newCart" title="سلة جديدة (F2)">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="pos-topbar-right">
                <button class="btn btn-outline-secondary btn-sm" @click="showParkedSales" title="المبيعات المؤجلة (F5)">
                    <i class="fas fa-pause-circle"></i>
                    <span v-if="parkedSalesCount > 0" class="badge">{{ parkedSalesCount }}</span>
                </button>
                <router-link to="/dashboard/pos/history" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-history"></i>
                </router-link>
                <router-link to="/dashboard/pos/settings" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-cog"></i>
                </router-link>
            </div>
        </div>

        <div class="pos-main">
            <!-- Left: Product Search & Grid -->
            <div class="pos-products">
                <!-- Search Bar -->
                <div class="search-section">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input
                            ref="searchInput"
                            type="text"
                            v-model="searchQuery"
                            @input="searchProducts"
                            @keydown.enter="handleSearchEnter"
                            placeholder="البحث عن المنتجات أو مسح الباركود (F1)"
                            class="search-input"
                        />
                        <button v-if="searchQuery" class="clear-search" @click="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="category-filters">
                        <select
                            v-model="selectedMainCategory"
                            @change="onMainCategoryChange"
                            class="category-select"
                        >
                            <option value="">جميع الفئات الرئيسية</option>
                            <option v-for="category in mainCategories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <select
                            v-model="selectedSubCategory"
                            @change="searchProducts"
                            class="category-select"
                            :disabled="!selectedMainCategory"
                        >
                            <option value="">جميع الفئات الفرعية</option>
                            <option v-for="subCategory in subCategories" :key="subCategory.id" :value="subCategory.id">
                                {{ subCategory.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="product-grid">
                    <div v-if="loading" class="loading-state">
                        <i class="fas fa-spinner fa-spin"></i> جاري التحميل...
                    </div>
                    <div v-else-if="products.length === 0 && searchQuery" class="empty-state">
                        <i class="fas fa-search"></i>
                        <p>لم يتم العثور على منتجات</p>
                    </div>
                    <div v-else-if="products.length === 0" class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p>ابحث عن المنتجات أو امسح الباركود</p>
                    </div>
                    <div
                        v-else
                        v-for="product in products"
                        :key="product.id"
                        class="product-card"
                        @click="selectProduct(product)"
                    >
                        <div class="product-image">
                            <img v-if="product.image" :src="'/uploads/products/' + product.image" :alt="product.name">
                            <i v-else class="fas fa-box"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-name" :title="product.name">{{ product.name }}</div>
                            <div class="product-price">{{ formatCurrency(product.sell_price) }}</div>
                            <div class="product-stock" :class="{ 'low-stock': product.total_stock < 10 }">
                                <i class="fas fa-box"></i> {{ product.total_stock }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Cart -->
            <div class="pos-cart">
                <!-- Customer Selection -->
                <div class="customer-section">
                    <div v-if="currentCart.customer" class="selected-customer">
                        <i class="fas fa-user"></i>
                        <span>{{ currentCart.customer.customer_name }}</span>
                        <button class="btn-clear" @click="clearCustomer">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button v-else class="select-customer-btn" @click="showCustomerModal = true">
                        <i class="fas fa-user-plus"></i> اختر عميل (F9)
                    </button>
                </div>

                <!-- Cart Items -->
                <div class="cart-items">
                    <div v-if="currentCart.items.length === 0" class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <p>السلة فارغة</p>
                        <small>ابحث عن المنتجات لإضافتها</small>
                    </div>
                    <div
                        v-else
                        v-for="(item, index) in currentCart.items"
                        :key="item.id || index"
                        class="cart-item"
                        :class="{ selected: selectedItemIndex === index }"
                        @click="selectItem(index)"
                    >
                        <div class="item-info">
                            <div class="item-name">
                                {{ item.product_name }}
                                <span v-if="item.variation_name" class="variation">({{ item.variation_name }})</span>
                            </div>
                            <div class="item-price">{{ formatCurrency(item.unit_price) }}</div>
                        </div>
                        <div class="item-controls">
                            <button class="qty-btn" @click.stop="decreaseQty(index)">-</button>
                            <input
                                type="number"
                                :value="item.quantity"
                                @change="updateQty(index, $event.target.value)"
                                @click.stop
                                class="qty-input"
                                min="1"
                            />
                            <button class="qty-btn" @click.stop="increaseQty(index)">+</button>
                        </div>
                        <div class="item-total">{{ formatCurrency(item.line_total) }}</div>
                        <div class="item-actions">
                            <button class="btn-discount" @click.stop="openItemDiscount(index)" title="خصم">
                                <i class="fas fa-percent"></i>
                            </button>
                            <button class="btn-remove" @click.stop="removeItem(index)" title="حذف">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>المجموع الفرعي</span>
                        <span>{{ formatCurrency(currentCart.subtotal) }}</span>
                    </div>
                    <div v-if="currentCart.discount_value > 0" class="summary-row discount">
                        <span>
                            الخصم
                            <button class="btn-edit-discount" @click="openSaleDiscount">
                                <i class="fas fa-edit"></i>
                            </button>
                        </span>
                        <span>-{{ formatCurrency(currentCart.discount_value) }}</span>
                    </div>
                    <div v-else class="summary-row">
                        <button class="add-discount-btn" @click="openSaleDiscount">
                            <i class="fas fa-percent"></i> إضافة خصم (F8)
                        </button>
                    </div>
                    <div v-if="settings.tax_rate > 0" class="summary-row tax">
                        <span>الضريبة ({{ settings.tax_rate }}%)</span>
                        <span>{{ formatCurrency(currentCart.tax_amount) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>الإجمالي</span>
                        <span>{{ formatCurrency(currentCart.total_amount) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="cart-actions">
                    <button
                        class="btn btn-secondary btn-park"
                        @click="parkSale"
                        :disabled="currentCart.items.length === 0"
                    >
                        <i class="fas fa-pause"></i> تأجيل (F4)
                    </button>
                    <button
                        class="btn btn-primary btn-pay"
                        @click="openPayment"
                        :disabled="currentCart.items.length === 0"
                    >
                        <i class="fas fa-money-bill"></i> دفع (F10)
                    </button>
                </div>
                <div class="quick-pay-wrapper">
                    <button
                        class="btn btn-success btn-quick-pay"
                        @click="quickPayCash"
                        :disabled="currentCart.items.length === 0"
                    >
                        <i class="fas fa-money-bill-wave"></i> دفع سريع نقداً
                    </button>
                </div>
            </div>
        </div>

        <!-- Variation Modal -->
        <div v-if="showVariationModal" class="modal-overlay" @click.self="showVariationModal = false">
            <div class="modal-content variation-modal">
                <div class="modal-header">
                    <h5>اختر النوع</h5>
                    <button class="close-btn" @click="showVariationModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="variations-grid">
                        <div
                            v-for="variation in selectedProduct.variations"
                            :key="variation.id"
                            class="variation-card"
                            :class="{ 'out-of-stock': variation.quantity <= 0 }"
                            @click="addVariationToCart(variation)"
                        >
                            <div class="variation-name">{{ variation.var_name }}</div>
                            <div class="variation-price">{{ formatCurrency(variation.price) }}</div>
                            <div class="variation-stock">المخزون: {{ variation.quantity }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Modal -->
        <div v-if="showCustomerModal" class="modal-overlay" @click.self="showCustomerModal = false">
            <div class="modal-content customer-modal">
                <div class="modal-header">
                    <h5>اختر أو أنشئ عميل</h5>
                    <button class="close-btn" @click="showCustomerModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="customer-search">
                        <input
                            type="text"
                            v-model="customerSearch"
                            @input="searchCustomers"
                            placeholder="البحث بالاسم أو الهاتف..."
                            class="form-control"
                        />
                    </div>
                    <div class="customer-list">
                        <div
                            v-for="customer in customers"
                            :key="customer.id"
                            class="customer-item"
                            @click="selectCustomer(customer)"
                        >
                            <div class="customer-name">{{ customer.customer_name }}</div>
                            <div class="customer-phone">{{ customer.phone1 }}</div>
                        </div>
                    </div>
                    <div class="create-customer-form" v-if="!customers.length && customerSearch">
                        <p class="text-muted">لم يتم العثور على عميل. إنشاء جديد؟</p>
                        <div class="form-group">
                            <input type="text" v-model="newCustomer.customer_name" placeholder="اسم العميل" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" v-model="newCustomer.phone1" placeholder="رقم الهاتف" class="form-control" />
                        </div>
                        <button class="btn btn-primary" @click="createCustomer">
                            <i class="fas fa-plus"></i> إنشاء عميل
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discount Modal -->
        <div v-if="showDiscountModal" class="modal-overlay" @click.self="showDiscountModal = false">
            <div class="modal-content discount-modal">
                <div class="modal-header">
                    <h5>{{ discountTarget === 'sale' ? 'خصم البيع' : 'خصم الصنف' }}</h5>
                    <button class="close-btn" @click="showDiscountModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="discount-type-toggle">
                        <button
                            :class="{ active: discountForm.type === 'percentage' }"
                            @click="discountForm.type = 'percentage'"
                        >
                            <i class="fas fa-percent"></i> نسبة مئوية
                        </button>
                        <button
                            :class="{ active: discountForm.type === 'fixed' }"
                            @click="discountForm.type = 'fixed'"
                        >
                            <i class="fas fa-dollar-sign"></i> مبلغ ثابت
                        </button>
                    </div>
                    <div class="discount-input">
                        <input
                            type="number"
                            v-model="discountForm.amount"
                            :placeholder="discountForm.type === 'percentage' ? 'أدخل النسبة %' : 'أدخل المبلغ'"
                            class="form-control"
                            min="0"
                        />
                    </div>
                    <div class="discount-actions">
                        <button class="btn btn-secondary" @click="clearDiscount">مسح</button>
                        <button class="btn btn-primary" @click="applyDiscount">تطبيق</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div v-if="showPaymentModal" class="modal-overlay" @click.self="showPaymentModal = false">
            <div class="modal-content payment-modal">
                <div class="modal-header">
                    <h5>الدفع</h5>
                    <button class="close-btn" @click="showPaymentModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="payment-summary">
                        <div class="total-due">
                            <span>الإجمالي المستحق</span>
                            <span class="amount">{{ formatCurrency(currentCart.total_amount) }}</span>
                        </div>
                        <div v-if="payments.length > 0" class="paid-so-far">
                            <span>المدفوع</span>
                            <span>{{ formatCurrency(totalPaid) }}</span>
                        </div>
                        <div v-if="remainingAmount > 0" class="remaining">
                            <span>المتبقي</span>
                            <span class="amount">{{ formatCurrency(remainingAmount) }}</span>
                        </div>
                        <div v-if="changeAmount > 0" class="change">
                            <span>الباقي</span>
                            <span class="amount text-success">{{ formatCurrency(changeAmount) }}</span>
                        </div>
                    </div>

                    <div class="payment-methods">
                        <button
                            v-for="method in availablePaymentMethods"
                            :key="method.value"
                            class="payment-method-btn"
                            :class="{ active: selectedPaymentMethod === method.value }"
                            @click="selectedPaymentMethod = method.value"
                        >
                            <i :class="method.icon"></i>
                            <span>{{ method.label }}</span>
                        </button>
                    </div>

                    <div class="payment-input">
                        <label>المبلغ</label>
                        <input
                            type="number"
                            v-model.number="paymentAmount"
                            class="form-control amount-input"
                            :placeholder="remainingAmount"
                            ref="paymentInput"
                        />
                    </div>

                    <div v-if="selectedPaymentMethod === 'cash'" class="quick-amounts">
                        <button
                            v-for="amount in quickAmounts"
                            :key="amount"
                            class="quick-amount-btn"
                            @click="paymentAmount = amount"
                        >
                            {{ formatCurrency(amount) }}
                        </button>
                    </div>

                    <div v-if="selectedPaymentMethod !== 'cash'" class="reference-input">
                        <label>رقم المرجع (اختياري)</label>
                        <input type="text" v-model="paymentReference" class="form-control" placeholder="كود التفويض، رقم التحويل..."/>
                    </div>

                    <!-- Added Payments List -->
                    <div v-if="payments.length > 0" class="payments-list">
                        <h6>المدفوعات</h6>
                        <div v-for="(payment, index) in payments" :key="index" class="payment-item">
                            <span>{{ getMethodLabel(payment.payment_method) }}</span>
                            <span>{{ formatCurrency(payment.amount) }}</span>
                            <button class="btn-remove-payment" @click="removePayment(index)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="payment-actions">
                        <button
                            v-if="!isFullyPaid"
                            class="btn btn-secondary"
                            @click="addPayment"
                            :disabled="!paymentAmount || paymentAmount <= 0"
                        >
                            <i class="fas fa-plus"></i> إضافة دفعة
                        </button>
                        <button
                            class="btn btn-primary btn-complete"
                            @click="completeSale"
                            :disabled="!canCompleteSale"
                        >
                            <i class="fas fa-check"></i>
                            {{ isFullyPaid ? 'إتمام البيع (F12)' : 'إتمام بدفعات مقسمة' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parked Sales Modal -->
        <div v-if="showParkedModal" class="modal-overlay" @click.self="showParkedModal = false">
            <div class="modal-content parked-modal">
                <div class="modal-header">
                    <h5>المبيعات المؤجلة</h5>
                    <button class="close-btn" @click="showParkedModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="parkedSales.length === 0" class="empty-state">
                        <i class="fas fa-pause-circle"></i>
                        <p>لا توجد مبيعات مؤجلة</p>
                    </div>
                    <div v-else class="parked-sales-list">
                        <div
                            v-for="sale in parkedSales"
                            :key="sale.id"
                            class="parked-sale-item"
                            @click="resumeSale(sale)"
                        >
                            <div class="sale-info">
                                <div class="sale-number">{{ sale.sale_number }}</div>
                                <div class="sale-name" v-if="sale.park_name">{{ sale.park_name }}</div>
                                <div class="sale-customer" v-if="sale.customer">
                                    <i class="fas fa-user"></i> {{ sale.customer.customer_name }}
                                </div>
                            </div>
                            <div class="sale-details">
                                <div class="items-count">{{ sale.items.length }} صنف</div>
                                <div class="sale-total">{{ formatCurrency(sale.total_amount) }}</div>
                            </div>
                            <button class="btn-delete-parked" @click.stop="deleteParkedSale(sale.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipt Modal -->
        <div v-if="showReceiptModal" class="modal-overlay" @click.self="closeReceipt">
            <div class="modal-content receipt-modal">
                <div class="modal-header">
                    <h5>تم البيع بنجاح</h5>
                    <button class="close-btn" @click="closeReceipt">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="receipt-info">
                        <p>البيع #{{ completedSale?.sale_number }}</p>
                        <p class="total">{{ formatCurrency(completedSale?.total_amount) }}</p>
                        <p v-if="completedSale?.change_amount > 0" class="change">
                            الباقي: {{ formatCurrency(completedSale?.change_amount) }}
                        </p>
                    </div>
                    <div class="receipt-actions">
                        <button class="btn btn-secondary" @click="printReceipt">
                            <i class="fas fa-print"></i> طباعة الإيصال
                        </button>
                        <button class="btn btn-primary" @click="closeReceipt">
                            <i class="fas fa-plus"></i> بيع جديد
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PosMain',
    data() {
        return {
            // Online status
            isOnline: navigator.onLine,

            // Settings
            settings: {
                tax_rate: 0,
                payment_methods: ['cash', 'card', 'wallet', 'bank_transfer'],
            },

            // Products
            products: [],
            searchQuery: '',
            loading: false,
            searchTimeout: null,

            // Categories
            mainCategories: [],
            subCategories: [],
            selectedMainCategory: '',
            selectedSubCategory: '',

            // Selected product for variation
            selectedProduct: null,
            showVariationModal: false,

            // Multi-cart support
            carts: [this.createEmptyCart()],
            currentCartIndex: 0,

            // Cart item selection
            selectedItemIndex: -1,

            // Customer
            showCustomerModal: false,
            customerSearch: '',
            customers: [],
            newCustomer: {
                customer_name: '',
                phone1: '',
            },

            // Discount
            showDiscountModal: false,
            discountTarget: 'sale', // 'sale' or 'item'
            discountItemIndex: -1,
            discountForm: {
                type: 'percentage',
                amount: 0,
            },

            // Payment
            showPaymentModal: false,
            selectedPaymentMethod: 'cash',
            paymentAmount: 0,
            paymentReference: '',
            payments: [],

            // Parked sales
            showParkedModal: false,
            parkedSales: [],

            // Completed sale
            showReceiptModal: false,
            completedSale: null,
        };
    },
    computed: {
        currentCart() {
            return this.carts[this.currentCartIndex];
        },
        parkedSalesCount() {
            return this.parkedSales.length;
        },
        availablePaymentMethods() {
            const methods = [
                { value: 'cash', label: 'نقدي', icon: 'fas fa-money-bill-wave' },
                { value: 'card', label: 'بطاقة', icon: 'fas fa-credit-card' },
                { value: 'wallet', label: 'محفظة', icon: 'fas fa-wallet' },
                { value: 'bank_transfer', label: 'تحويل بنكي', icon: 'fas fa-university' },
            ];
            return methods.filter(m => this.settings.payment_methods?.includes(m.value));
        },
        totalPaid() {
            return this.payments.reduce((sum, p) => sum + p.amount, 0);
        },
        remainingAmount() {
            return Math.max(0, this.currentCart.total_amount - this.totalPaid);
        },
        changeAmount() {
            if (this.totalPaid <= this.currentCart.total_amount) return 0;
            return this.totalPaid - this.currentCart.total_amount;
        },
        isFullyPaid() {
            return this.totalPaid >= this.currentCart.total_amount;
        },
        canCompleteSale() {
            return this.payments.length > 0 && this.totalPaid >= this.currentCart.total_amount;
        },
        quickAmounts() {
            const total = this.remainingAmount > 0 ? this.remainingAmount : this.currentCart.total_amount;
            const amounts = [total];
            const denominations = [5, 10, 20, 50, 100, 200, 500, 1000];

            for (const denom of denominations) {
                if (denom > total && amounts.length < 6) {
                    amounts.push(denom);
                }
            }
            return [...new Set(amounts)].slice(0, 6);
        },
    },
    methods: {
        createEmptyCart() {
            return {
                id: null,
                customer: null,
                items: [],
                subtotal: 0,
                discount_type: null,
                discount_amount: 0,
                discount_value: 0,
                tax_rate: 0,
                tax_amount: 0,
                total_amount: 0,
            };
        },

        formatCurrency(amount) {
            const value = amount || 0;
            // Check if the value has decimal places
            const hasDecimals = value % 1 !== 0;

            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: hasDecimals ? 1 : 0,
                maximumFractionDigits: hasDecimals ? 2 : 0,
            }).format(value);
        },

        // Initialize
        async initialize() {
            try {
                const response = await axios.get('/dashboard/api/pos/initialize');
                this.settings = response.data.data.settings;
                this.parkedSales = response.data.data.parked_sales || [];

                // Load draft sales as carts
                const drafts = response.data.data.draft_sales || [];
                if (drafts.length > 0) {
                    this.carts = drafts.map(draft => this.saleToCart(draft));
                }

                // Fetch categories and products on load
                await this.fetchCategories();
                await this.fetchAllProducts();
            } catch (error) {
                console.error('Failed to initialize POS:', error);
            }
        },

        saleToCart(sale) {
            return {
                id: sale.id,
                customer: sale.customer,
                items: sale.items || [],
                subtotal: parseFloat(sale.subtotal) || 0,
                discount_type: sale.discount_type,
                discount_amount: parseFloat(sale.discount_amount) || 0,
                discount_value: parseFloat(sale.discount_value) || 0,
                tax_rate: parseFloat(sale.tax_rate) || 0,
                tax_amount: parseFloat(sale.tax_amount) || 0,
                total_amount: parseFloat(sale.total_amount) || 0,
            };
        },

        // Fetch categories
        async fetchCategories() {
            try {
                const response = await axios.get('/dashboard/api/categories');
                const categories = response.data || [];
                // Filter main categories (parent_id is null or 0)
                this.mainCategories = categories.filter(cat => !cat.parent_id || cat.parent_id === 0);
            } catch (error) {
                console.error('Failed to fetch categories:', error);
                this.mainCategories = [];
            }
        },

        async onMainCategoryChange() {
            // Reset sub category when main category changes
            this.selectedSubCategory = '';

            // Load sub categories for selected main category
            if (this.selectedMainCategory) {
                try {
                    const response = await axios.get('/dashboard/api/categories');
                    const categories = response.data || [];
                    this.subCategories = categories.filter(
                        cat => cat.parent_id == this.selectedMainCategory
                    );
                } catch (error) {
                    console.error('Failed to fetch sub categories:', error);
                    this.subCategories = [];
                }
            } else {
                this.subCategories = [];
            }

            // Trigger search with new filters
            this.searchProducts();
        },

        // Fetch all products
        async fetchAllProducts() {
            this.loading = true;
            try {
                const params = { page: 1 };

                // Add category filters if selected
                if (this.selectedSubCategory) {
                    params.category_id = this.selectedSubCategory;
                } else if (this.selectedMainCategory) {
                    params.category_id = this.selectedMainCategory;
                }

                const response = await axios.get('/dashboard/api/get-product-list', { params });
                // Extract products from paginated response
                this.products = response.data.data || [];
            } catch (error) {
                console.error('Failed to fetch products:', error);
            } finally {
                this.loading = false;
            }
        },

        // Product search
        async searchProducts() {
            clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                this.loading = true;
                try {
                    const params = { page: 1 };

                    // Add search query if exists
                    if (this.searchQuery && this.searchQuery.length >= 1) {
                        params.search = this.searchQuery;
                    }

                    // Add category filters if selected
                    if (this.selectedSubCategory) {
                        params.category_id = this.selectedSubCategory;
                    } else if (this.selectedMainCategory) {
                        params.category_id = this.selectedMainCategory;
                    }

                    const response = await axios.get('/dashboard/api/get-product-list', { params });
                    this.products = response.data.data || [];
                } catch (error) {
                    console.error('Search error:', error);
                    this.products = [];
                } finally {
                    this.loading = false;
                }
            }, 300);
        },

        handleSearchEnter() {
            if (this.products.length === 1) {
                this.selectProduct(this.products[0]);
            }
        },

        clearSearch() {
            this.searchQuery = '';
            this.products = [];
            this.$refs.searchInput?.focus();
        },

        // Product selection
        selectProduct(product) {
            // Check if product has variations (using variation or variations property)
            const variations = product.variation || product.variations || [];

            if (variations && variations.length > 0) {
                this.selectedProduct = { ...product, variations: variations };
                this.showVariationModal = true;
            } else {
                this.addToCart(product, null);
            }
        },

        addVariationToCart(variation) {
            if (variation.quantity <= 0) {
                this.$toast?.warning('Out of stock');
                return;
            }
            this.addToCart(this.selectedProduct, variation);
            this.showVariationModal = false;
            this.selectedProduct = null;
        },

        async addToCart(product, variation) {
            const item = {
                product_id: product.id,
                product_variation_id: variation?.id || null,
                product_name: product.name,
                variation_name: variation?.var_name || null,
                unit_price: variation?.price || product.sell_price,
                quantity: 1,
            };

            // Check if item already in cart
            const existingIndex = this.currentCart.items.findIndex(
                i => i.product_id === item.product_id && i.product_variation_id === item.product_variation_id
            );

            if (existingIndex >= 0) {
                this.currentCart.items[existingIndex].quantity++;
                this.updateItemTotal(existingIndex);
            } else {
                item.line_total = item.unit_price * item.quantity;
                this.currentCart.items.push(item);
            }

            this.recalculateCart();
            // Don't clear search - keep product list visible

            // Sync with backend if cart has ID
            if (this.currentCart.id) {
                await this.syncCartToBackend();
            }
        },

        // Cart operations
        increaseQty(index) {
            this.currentCart.items[index].quantity++;
            this.updateItemTotal(index);
            this.recalculateCart();
        },

        decreaseQty(index) {
            if (this.currentCart.items[index].quantity > 1) {
                this.currentCart.items[index].quantity--;
                this.updateItemTotal(index);
                this.recalculateCart();
            }
        },

        updateQty(index, value) {
            const qty = parseInt(value) || 1;
            this.currentCart.items[index].quantity = Math.max(1, qty);
            this.updateItemTotal(index);
            this.recalculateCart();
        },

        updateItemTotal(index) {
            const item = this.currentCart.items[index];
            const subtotal = item.unit_price * item.quantity;
            let discount = 0;

            if (item.discount_type === 'percentage') {
                discount = (subtotal * item.discount_amount) / 100;
            } else if (item.discount_type === 'fixed') {
                discount = item.discount_amount || 0;
            }

            item.discount_value = discount;
            item.line_total = subtotal - discount;
        },

        removeItem(index) {
            this.currentCart.items.splice(index, 1);
            this.selectedItemIndex = -1;
            this.recalculateCart();
        },

        selectItem(index) {
            this.selectedItemIndex = this.selectedItemIndex === index ? -1 : index;
        },

        recalculateCart() {
            const cart = this.currentCart;

            // Subtotal
            cart.subtotal = cart.items.reduce((sum, item) => sum + item.line_total, 0);

            // Sale discount
            if (cart.discount_type === 'percentage') {
                cart.discount_value = (cart.subtotal * cart.discount_amount) / 100;
            } else if (cart.discount_type === 'fixed') {
                cart.discount_value = cart.discount_amount || 0;
            } else {
                cart.discount_value = 0;
            }

            // Tax
            const taxableAmount = cart.subtotal - cart.discount_value;
            cart.tax_rate = this.settings.tax_rate || 0;
            cart.tax_amount = (taxableAmount * cart.tax_rate) / 100;

            // Total
            cart.total_amount = taxableAmount + cart.tax_amount;
        },

        // Multi-cart
        newCart() {
            this.carts.push(this.createEmptyCart());
            this.currentCartIndex = this.carts.length - 1;
        },

        switchCart(index) {
            this.currentCartIndex = index;
            this.selectedItemIndex = -1;
        },

        closeCart(index) {
            if (this.carts.length <= 1) return;

            this.carts.splice(index, 1);
            if (this.currentCartIndex >= this.carts.length) {
                this.currentCartIndex = this.carts.length - 1;
            }
        },

        // Customer
        async searchCustomers() {
            if (!this.customerSearch || this.customerSearch.length < 2) {
                this.customers = [];
                return;
            }

            try {
                const response = await axios.get('/dashboard/api/pos/customers', {
                    params: { q: this.customerSearch }
                });
                this.customers = response.data.data || [];
            } catch (error) {
                console.error('Customer search error:', error);
            }
        },

        selectCustomer(customer) {
            this.currentCart.customer = customer;
            this.showCustomerModal = false;
            this.customerSearch = '';
            this.customers = [];
        },

        async createCustomer() {
            if (!this.newCustomer.customer_name || !this.newCustomer.phone1) {
                this.$toast?.error('الاسم والهاتف مطلوبان');
                return;
            }

            try {
                const response = await axios.post('/dashboard/api/pos/customers', this.newCustomer);
                this.selectCustomer(response.data.data);
                this.newCustomer = { customer_name: '', phone1: '' };
            } catch (error) {
                this.$toast?.error('فشل إنشاء العميل');
            }
        },

        clearCustomer() {
            this.currentCart.customer = null;
        },

        // Discount
        openItemDiscount(index) {
            this.discountTarget = 'item';
            this.discountItemIndex = index;
            const item = this.currentCart.items[index];
            this.discountForm.type = item.discount_type || 'percentage';
            this.discountForm.amount = item.discount_amount || 0;
            this.showDiscountModal = true;
        },

        openSaleDiscount() {
            this.discountTarget = 'sale';
            this.discountForm.type = this.currentCart.discount_type || 'percentage';
            this.discountForm.amount = this.currentCart.discount_amount || 0;
            this.showDiscountModal = true;
        },

        applyDiscount() {
            if (this.discountTarget === 'item') {
                const item = this.currentCart.items[this.discountItemIndex];
                item.discount_type = this.discountForm.type;
                item.discount_amount = parseFloat(this.discountForm.amount) || 0;
                this.updateItemTotal(this.discountItemIndex);
            } else {
                this.currentCart.discount_type = this.discountForm.type;
                this.currentCart.discount_amount = parseFloat(this.discountForm.amount) || 0;
            }

            this.recalculateCart();
            this.showDiscountModal = false;
        },

        clearDiscount() {
            if (this.discountTarget === 'item') {
                const item = this.currentCart.items[this.discountItemIndex];
                item.discount_type = null;
                item.discount_amount = 0;
                this.updateItemTotal(this.discountItemIndex);
            } else {
                this.currentCart.discount_type = null;
                this.currentCart.discount_amount = 0;
            }

            this.recalculateCart();
            this.showDiscountModal = false;
        },

        // Payment
        openPayment() {
            this.payments = [];
            this.selectedPaymentMethod = 'cash';
            this.paymentAmount = this.currentCart.total_amount;
            this.paymentReference = '';
            this.showPaymentModal = true;

            this.$nextTick(() => {
                this.$refs.paymentInput?.focus();
            });
        },

        getMethodLabel(method) {
            const labels = {
                cash: 'نقدي',
                card: 'بطاقة',
                wallet: 'محفظة',
                bank_transfer: 'تحويل بنكي',
            };
            return labels[method] || method;
        },

        addPayment() {
            if (!this.paymentAmount || this.paymentAmount <= 0) return;

            this.payments.push({
                payment_method: this.selectedPaymentMethod,
                amount: this.paymentAmount,
                tendered_amount: this.selectedPaymentMethod === 'cash' ? this.paymentAmount : null,
                reference_number: this.paymentReference || null,
            });

            this.paymentAmount = Math.max(0, this.remainingAmount);
            this.paymentReference = '';
        },

        removePayment(index) {
            this.payments.splice(index, 1);
        },

        async completeSale() {
            if (!this.canCompleteSale) return;

            try {
                // Create sale if not exists
                let saleId = this.currentCart.id;

                if (!saleId) {
                    const createRes = await axios.post('/dashboard/api/pos/sales', {
                        customer_id: this.currentCart.customer?.id,
                        items: this.currentCart.items,
                    });
                    saleId = createRes.data.data.id;
                }

                // Apply discount if any
                if (this.currentCart.discount_type) {
                    await axios.put(`/dashboard/api/pos/sales/${saleId}`, {
                        discount_type: this.currentCart.discount_type,
                        discount_amount: this.currentCart.discount_amount,
                    });
                }

                // Complete sale with payment
                const response = await axios.post(`/dashboard/api/pos/sales/${saleId}/complete`, {
                    payments: this.payments,
                });

                this.completedSale = response.data.data;
                this.showPaymentModal = false;
                this.showReceiptModal = true;

                // Print if auto-print enabled
                if (this.settings.print_receipt_auto) {
                    this.printReceipt();
                }

            } catch (error) {
                console.error('Failed to complete sale:', error);
                this.$toast?.error(error.response?.data?.message || 'فشل إتمام البيع');
            }
        },

        async quickPayCash() {
            if (this.currentCart.items.length === 0) return;

            try {
                // Set payment to cash with full amount
                this.payments = [{
                    payment_method: 'cash',
                    amount: this.currentCart.total_amount,
                    tendered_amount: this.currentCart.total_amount,
                }];

                // Complete sale directly
                await this.completeSale();
            } catch (error) {
                console.error('Quick pay failed:', error);
                this.$toast?.error('فشل الدفع السريع');
            }
        },

        // Park sale
        async parkSale() {
            if (this.currentCart.items.length === 0) return;

            try {
                let saleId = this.currentCart.id;

                if (!saleId) {
                    const createRes = await axios.post('/dashboard/api/pos/sales', {
                        customer_id: this.currentCart.customer?.id,
                        items: this.currentCart.items,
                    });
                    saleId = createRes.data.data.id;
                }

                await axios.post(`/dashboard/api/pos/sales/${saleId}/park`, {
                    park_name: `Cart ${this.currentCartIndex + 1}`,
                });

                // Refresh parked sales
                await this.loadParkedSales();

                // Reset current cart
                this.carts[this.currentCartIndex] = this.createEmptyCart();

                this.$toast?.success('تم تأجيل البيع');
            } catch (error) {
                console.error('Failed to park sale:', error);
                this.$toast?.error('فشل تأجيل البيع');
            }
        },

        async loadParkedSales() {
            try {
                const response = await axios.get('/dashboard/api/pos/sales/parked');
                this.parkedSales = response.data.data || [];
            } catch (error) {
                console.error('Failed to load parked sales:', error);
            }
        },

        showParkedSales() {
            this.loadParkedSales();
            this.showParkedModal = true;
        },

        async resumeSale(sale) {
            try {
                await axios.post(`/dashboard/api/pos/sales/${sale.id}/unpark`);

                // Load into cart
                this.carts[this.currentCartIndex] = this.saleToCart(sale);

                // Remove from parked list
                await this.loadParkedSales();

                this.showParkedModal = false;
            } catch (error) {
                console.error('Failed to resume sale:', error);
                this.$toast?.error('فشل استعادة البيع');
            }
        },

        async deleteParkedSale(saleId) {
            if (!confirm('حذف هذا البيع المؤجل؟')) return;

            try {
                await axios.delete(`/dashboard/api/pos/sales/${saleId}`);
                await this.loadParkedSales();
            } catch (error) {
                console.error('Failed to delete parked sale:', error);
            }
        },

        // Receipt
        async printReceipt() {
            if (!this.completedSale) return;

            try {
                const response = await axios.get(`/dashboard/api/pos/print/${this.completedSale.id}/html`, {
                    responseType: 'text',
                });

                const printWindow = window.open('', '_blank');
                printWindow.document.write(response.data);
                printWindow.document.close();
                printWindow.print();
            } catch (error) {
                console.error('Failed to print receipt:', error);
            }
        },

        closeReceipt() {
            this.showReceiptModal = false;
            this.completedSale = null;

            // Reset cart
            this.carts[this.currentCartIndex] = this.createEmptyCart();
            this.payments = [];

            // Focus search
            this.$refs.searchInput?.focus();
        },

        // Sync
        async syncCartToBackend() {
            // Implementation for syncing cart changes
        },

        // Keyboard shortcuts
        handleKeydown(e) {
            // Don't handle if in input
            if (['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                if (e.key === 'Escape') {
                    e.target.blur();
                }
                return;
            }

            switch (e.key) {
                case 'F1':
                    e.preventDefault();
                    this.$refs.searchInput?.focus();
                    break;
                case 'F2':
                    e.preventDefault();
                    this.newCart();
                    break;
                case 'F3':
                    e.preventDefault();
                    this.switchCart((this.currentCartIndex + 1) % this.carts.length);
                    break;
                case 'F4':
                    e.preventDefault();
                    this.parkSale();
                    break;
                case 'F5':
                    e.preventDefault();
                    this.showParkedSales();
                    break;
                case 'F8':
                    e.preventDefault();
                    this.openSaleDiscount();
                    break;
                case 'F9':
                    e.preventDefault();
                    this.showCustomerModal = true;
                    break;
                case 'F10':
                    e.preventDefault();
                    if (this.currentCart.items.length > 0) {
                        this.openPayment();
                    }
                    break;
                case 'F12':
                    e.preventDefault();
                    if (this.showPaymentModal && this.canCompleteSale) {
                        this.completeSale();
                    } else if (this.currentCart.items.length > 0) {
                        // Quick cash payment
                        this.payments = [{
                            payment_method: 'cash',
                            amount: this.currentCart.total_amount,
                            tendered_amount: this.currentCart.total_amount,
                        }];
                        this.completeSale();
                    }
                    break;
                case 'Delete':
                    e.preventDefault();
                    if (this.selectedItemIndex >= 0) {
                        this.removeItem(this.selectedItemIndex);
                    }
                    break;
                case 'Escape':
                    this.showVariationModal = false;
                    this.showCustomerModal = false;
                    this.showDiscountModal = false;
                    this.showPaymentModal = false;
                    this.showParkedModal = false;
                    break;
            }
        },
    },
    mounted() {
        this.initialize();

        // Online/offline detection
        window.addEventListener('online', () => { this.isOnline = true; });
        window.addEventListener('offline', () => { this.isOnline = false; });

        // Focus search on mount
        this.$refs.searchInput?.focus();
    },
    beforeDestroy() {
        window.removeEventListener('online', () => {});
        window.removeEventListener('offline', () => {});
    },
};
</script>

<style scoped>
.pos-container {
    height: 100vh;
    display: flex;
    flex-direction: column;
    background: #f5f7fa;
    overflow: hidden;
}

.offline-banner {
    background: #ff9800;
    color: white;
    padding: 8px;
    text-align: center;
    font-size: 14px;
}

.pos-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background: white;
    border-bottom: 1px solid #e0e0e0;
    gap: 20px;
}

.pos-topbar h4 {
    margin: 0;
    font-size: 18px;
}

.cart-tabs {
    display: flex;
    align-items: center;
    gap: 5px;
}

.cart-tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #f0f0f0;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s;
}

.cart-tab.active {
    background: #2196f3;
    color: white;
}

.cart-tab .item-count {
    background: rgba(0,0,0,0.1);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 12px;
}

.cart-tab .close-cart {
    background: none;
    border: none;
    padding: 2px;
    cursor: pointer;
    opacity: 0.6;
}

.new-cart-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px dashed #ccc;
    background: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pos-topbar-right {
    display: flex;
    gap: 10px;
}

.pos-topbar-right .badge {
    background: #f44336;
    color: white;
    border-radius: 10px;
    padding: 2px 6px;
    font-size: 10px;
    margin-left: 5px;
}

.pos-main {
    flex: 1;
    display: flex;
    overflow: hidden;
}

.pos-products {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 20px;
    overflow: hidden;
}

.search-section {
    margin-bottom: 20px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.category-filters {
    display: flex;
    gap: 10px;
}

.category-select {
    flex: 1;
    padding: 10px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    background: white;
    cursor: pointer;
    transition: border-color 0.2s;
}

.category-select:focus {
    outline: none;
    border-color: #2196f3;
}

.category-select:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
    opacity: 0.6;
}

.search-input-wrapper i {
    position: absolute;
    left: 15px;
    color: #888;
}

.search-input {
    width: 100%;
    padding: 15px 45px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 16px;
    transition: border-color 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #2196f3;
}

.clear-search {
    position: absolute;
    right: 15px;
    background: none;
    border: none;
    cursor: pointer;
    color: #888;
}

.product-grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
    overflow-y: auto;
    padding-right: 10px;
    align-content: start;
}

.loading-state, .empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #888;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.5;
}

.product-card {
    background: white;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(33, 150, 243, 0.2);
}

.product-image {
    width: 100%;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
    overflow: hidden;
    position: relative;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-image i {
    font-size: 48px;
    color: #cbd5e0;
}

.product-info {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.product-name {
    font-weight: 600;
    font-size: 14px;
    line-height: 1.4;
    color: #2d3748;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 40px;
}

.product-price {
    color: #2196f3;
    font-weight: 700;
    font-size: 18px;
    margin-top: auto;
}

.product-stock {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #4caf50;
    font-weight: 600;
}

.product-stock i {
    font-size: 14px;
}

.product-stock.low-stock {
    color: #f44336;
}

/* Cart */
.pos-cart {
    width: 400px;
    background: white;
    display: flex;
    flex-direction: column;
    border-left: 1px solid #e0e0e0;
}

.customer-section {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.selected-customer {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    background: #e3f2fd;
    border-radius: 8px;
}

.selected-customer .btn-clear {
    margin-left: auto;
    background: none;
    border: none;
    cursor: pointer;
    color: #888;
}

.select-customer-btn {
    width: 100%;
    padding: 12px;
    border: 2px dashed #ccc;
    border-radius: 8px;
    background: none;
    cursor: pointer;
    color: #666;
    transition: all 0.2s;
}

.select-customer-btn:hover {
    border-color: #2196f3;
    color: #2196f3;
}

.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
}

.empty-cart {
    text-align: center;
    padding: 40px 20px;
    color: #888;
}

.empty-cart i {
    font-size: 48px;
    opacity: 0.3;
    margin-bottom: 10px;
}

.cart-item {
    display: grid;
    grid-template-columns: 1fr auto auto auto;
    gap: 10px;
    align-items: center;
    padding: 12px;
    background: #f9f9f9;
    border-radius: 8px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.cart-item.selected {
    background: #e3f2fd;
    border: 1px solid #2196f3;
}

.item-name {
    font-weight: 500;
    font-size: 14px;
}

.item-name .variation {
    font-weight: 400;
    color: #888;
    font-size: 12px;
}

.item-price {
    font-size: 12px;
    color: #666;
}

.item-controls {
    display: flex;
    align-items: center;
    gap: 5px;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.qty-input {
    width: 40px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px;
}

.item-total {
    font-weight: 600;
    min-width: 70px;
    text-align: right;
}

.item-actions {
    display: flex;
    gap: 5px;
}

.btn-discount, .btn-remove {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.btn-discount {
    background: #fff3e0;
    color: #ff9800;
}

.btn-remove {
    background: #ffebee;
    color: #f44336;
}

/* Cart Summary */
.cart-summary {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
    background: #fafafa;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
}

.summary-row.discount {
    color: #4caf50;
}

.summary-row.tax {
    color: #888;
    font-size: 14px;
}

.summary-row.total {
    font-size: 20px;
    font-weight: 700;
    border-top: 2px solid #e0e0e0;
    margin-top: 10px;
    padding-top: 15px;
}

.add-discount-btn {
    background: none;
    border: none;
    color: #2196f3;
    cursor: pointer;
    font-size: 14px;
}

.btn-edit-discount {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 0 5px;
}

/* Cart Actions */
.cart-actions {
    display: flex;
    gap: 10px;
    padding: 15px;
    border-top: 1px solid #e0e0e0;
}

.btn-park {
    flex: 1;
}

.btn-pay {
    flex: 2;
    font-size: 18px;
    padding: 15px;
}

.quick-pay-wrapper {
    padding: 0 15px 15px 15px;
}

.btn-quick-pay {
    width: 100%;
    font-size: 18px;
    padding: 15px;
    font-weight: 600;
}

/* Modals */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #e0e0e0;
}

.modal-header h5 {
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #888;
}

.modal-body {
    padding: 20px;
    overflow-y: auto;
}

/* Variation Modal */
.variations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px;
}

.variation-card {
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}

.variation-card:hover {
    border-color: #2196f3;
}

.variation-card.out-of-stock {
    opacity: 0.5;
    cursor: not-allowed;
}

.variation-name {
    font-weight: 600;
    margin-bottom: 5px;
}

.variation-price {
    color: #2196f3;
    font-weight: 700;
}

.variation-stock {
    font-size: 12px;
    color: #888;
}

/* Customer Modal */
.customer-search {
    margin-bottom: 15px;
}

.customer-list {
    max-height: 200px;
    overflow-y: auto;
}

.customer-item {
    padding: 12px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.customer-item:hover {
    background: #f5f5f5;
}

.customer-name {
    font-weight: 600;
}

.customer-phone {
    color: #888;
    font-size: 14px;
}

.create-customer-form {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.form-group {
    margin-bottom: 10px;
}

/* Discount Modal */
.discount-type-toggle {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.discount-type-toggle button {
    flex: 1;
    padding: 12px;
    border: 2px solid #e0e0e0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.discount-type-toggle button.active {
    border-color: #2196f3;
    background: #e3f2fd;
}

.discount-input {
    margin-bottom: 20px;
}

.discount-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

/* Payment Modal */
.payment-modal {
    max-width: 600px;
}

.payment-summary {
    background: #f5f5f5;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.total-due, .remaining {
    display: flex;
    justify-content: space-between;
    font-size: 18px;
    margin-bottom: 10px;
}

.total-due .amount, .remaining .amount {
    font-weight: 700;
}

.paid-so-far, .change {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #666;
}

.change .amount {
    font-weight: 600;
}

.payment-methods {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.payment-method-btn {
    flex: 1;
    min-width: 100px;
    padding: 15px;
    border: 2px solid #e0e0e0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    text-align: center;
    transition: all 0.2s;
}

.payment-method-btn.active {
    border-color: #2196f3;
    background: #e3f2fd;
}

.payment-method-btn i {
    display: block;
    font-size: 24px;
    margin-bottom: 5px;
}

.payment-input {
    margin-bottom: 15px;
}

.payment-input label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.amount-input {
    font-size: 24px;
    text-align: center;
    padding: 15px;
}

.quick-amounts {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.quick-amount-btn {
    padding: 10px 20px;
    border: 1px solid #e0e0e0;
    background: white;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s;
}

.quick-amount-btn:hover {
    background: #f5f5f5;
}

.reference-input {
    margin-bottom: 20px;
}

.payments-list {
    margin-bottom: 20px;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 8px;
}

.payments-list h6 {
    margin-bottom: 10px;
}

.payment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e0e0e0;
}

.payment-item:last-child {
    border-bottom: none;
}

.btn-remove-payment {
    background: none;
    border: none;
    color: #f44336;
    cursor: pointer;
}

.payment-actions {
    display: flex;
    gap: 10px;
}

.btn-complete {
    flex: 1;
    padding: 15px;
    font-size: 16px;
}

/* Parked Sales Modal */
.parked-sales-list {
    max-height: 400px;
    overflow-y: auto;
}

.parked-sale-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.parked-sale-item:hover {
    background: #f5f5f5;
}

.sale-info {
    flex: 1;
}

.sale-number {
    font-weight: 600;
}

.sale-name {
    font-size: 14px;
    color: #666;
}

.sale-customer {
    font-size: 12px;
    color: #888;
}

.sale-details {
    text-align: right;
}

.items-count {
    font-size: 12px;
    color: #888;
}

.sale-total {
    font-weight: 700;
    color: #2196f3;
}

.btn-delete-parked {
    background: none;
    border: none;
    color: #f44336;
    cursor: pointer;
    padding: 10px;
}

/* Receipt Modal */
.receipt-modal {
    max-width: 400px;
    text-align: center;
}

.success-icon {
    font-size: 64px;
    color: #4caf50;
    margin-bottom: 20px;
}

.receipt-info {
    margin-bottom: 20px;
}

.receipt-info .total {
    font-size: 32px;
    font-weight: 700;
}

.receipt-info .change {
    font-size: 18px;
    color: #4caf50;
}

.receipt-actions {
    display: flex;
    gap: 10px;
}

.receipt-actions button {
    flex: 1;
}

/* ============================================
   MOBILE RESPONSIVE STYLES
============================================ */

/* Tablet and below */
@media (max-width: 768px) {
    .pos-topbar {
        padding: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pos-topbar h4 {
        font-size: 16px;
    }

    .pos-topbar-left {
        flex: 1;
        min-width: 150px;
    }

    .pos-topbar-center {
        order: 3;
        width: 100%;
    }

    .cart-tabs {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .cart-tab {
        padding: 6px 12px;
        font-size: 14px;
    }

    .pos-topbar-right {
        gap: 5px;
    }

    .pos-topbar-right .btn {
        padding: 6px 10px;
        font-size: 12px;
    }

    /* Stack products and cart vertically */
    .pos-main {
        flex-direction: column;
    }

    .pos-products {
        height: 50vh;
        padding: 10px;
    }

    .pos-cart {
        width: 100%;
        height: 50vh;
        border-left: none;
        border-top: 2px solid #e0e0e0;
    }

    /* Adjust product grid for mobile */
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
    }

    .product-image {
        height: 120px;
    }

    .product-info {
        padding: 12px;
    }

    .product-name {
        font-size: 13px;
        min-height: 36px;
    }

    .product-price {
        font-size: 16px;
    }

    .product-stock {
        font-size: 12px;
    }

    /* Cart adjustments */
    .cart-items {
        padding: 10px;
    }

    .cart-item {
        grid-template-columns: 1fr auto;
        grid-template-rows: auto auto;
        gap: 8px;
        padding: 10px;
    }

    .item-info {
        grid-column: 1 / 2;
        grid-row: 1 / 2;
    }

    .item-controls {
        grid-column: 1 / 2;
        grid-row: 2 / 3;
    }

    .item-total {
        grid-column: 2 / 3;
        grid-row: 1 / 2;
    }

    .item-actions {
        grid-column: 2 / 3;
        grid-row: 2 / 3;
        justify-content: flex-end;
    }

    .cart-summary {
        padding: 10px;
    }

    .summary-row.total {
        font-size: 18px;
    }

    .cart-actions {
        padding: 10px;
        gap: 8px;
    }

    .btn-pay {
        font-size: 16px;
        padding: 12px;
    }

    /* Modal adjustments */
    .modal-content {
        width: 95%;
        max-height: 95vh;
    }

    .modal-body {
        padding: 15px;
    }

    .payment-modal {
        max-width: 95%;
    }

    .payment-method-btn {
        min-width: 80px;
        padding: 12px 8px;
        font-size: 12px;
    }

    .payment-method-btn i {
        font-size: 20px;
    }

    .amount-input {
        font-size: 20px;
        padding: 12px;
    }

    .quick-amounts {
        gap: 8px;
    }

    .quick-amount-btn {
        padding: 8px 16px;
        font-size: 14px;
    }

    .variations-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }

    .variation-card {
        padding: 12px;
    }
}

/* Mobile phones */
@media (max-width: 480px) {
    .pos-topbar h4 {
        font-size: 14px;
    }

    .pos-topbar h4 i {
        display: none;
    }

    .cart-tab {
        padding: 5px 10px;
        font-size: 12px;
    }

    .new-cart-btn {
        width: 32px;
        height: 32px;
    }

    .pos-topbar-right .btn span {
        display: none;
    }

    /* Adjust product grid for small phones */
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }

    .product-image {
        height: 100px;
    }

    .product-image i {
        font-size: 36px;
    }

    .product-info {
        padding: 10px;
    }

    .product-name {
        font-size: 12px;
        min-height: 34px;
    }

    .product-price {
        font-size: 14px;
    }

    .product-stock {
        font-size: 11px;
    }

    .search-input {
        padding: 12px 40px;
        font-size: 14px;
    }

    .category-filters {
        flex-direction: column;
        gap: 8px;
    }

    .category-select {
        padding: 8px 12px;
        font-size: 13px;
    }

    /* Compact cart */
    .customer-section {
        padding: 10px;
    }

    .cart-item {
        padding: 8px;
        font-size: 13px;
    }

    .item-name {
        font-size: 13px;
    }

    .item-name .variation {
        font-size: 11px;
    }

    .item-price {
        font-size: 11px;
    }

    .qty-btn {
        width: 26px;
        height: 26px;
        font-size: 14px;
    }

    .qty-input {
        width: 36px;
        font-size: 14px;
    }

    .item-total {
        font-size: 14px;
        min-width: 60px;
    }

    .btn-discount, .btn-remove {
        width: 26px;
        height: 26px;
        font-size: 11px;
    }

    .summary-row {
        padding: 6px 0;
        font-size: 14px;
    }

    .summary-row.total {
        font-size: 16px;
    }

    .cart-actions {
        gap: 6px;
        padding: 8px;
    }

    .btn-park {
        font-size: 13px;
        padding: 10px 8px;
    }

    .btn-pay {
        font-size: 14px;
        padding: 10px;
    }

    /* Full screen modals on mobile */
    .modal-content {
        width: 100%;
        max-width: 100%;
        height: 100vh;
        max-height: 100vh;
        border-radius: 0;
    }

    .modal-header {
        padding: 12px 15px;
    }

    .modal-header h5 {
        font-size: 16px;
    }

    .payment-methods {
        gap: 8px;
    }

    .payment-method-btn {
        min-width: 70px;
        padding: 10px 6px;
        font-size: 11px;
    }

    .payment-method-btn i {
        font-size: 18px;
    }

    .payment-method-btn span {
        font-size: 10px;
    }

    .amount-input {
        font-size: 18px;
        padding: 10px;
    }

    .quick-amount-btn {
        padding: 8px 12px;
        font-size: 12px;
    }

    .btn-complete {
        padding: 12px;
        font-size: 14px;
    }

    .variations-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .variation-card {
        padding: 10px;
        font-size: 13px;
    }

    .variation-name {
        font-size: 13px;
    }

    .variation-price {
        font-size: 14px;
    }

    .customer-item {
        padding: 10px;
    }

    .customer-name {
        font-size: 14px;
    }

    .customer-phone {
        font-size: 12px;
    }

    .receipt-info .total {
        font-size: 24px;
    }

    .receipt-info .change {
        font-size: 16px;
    }

    .success-icon {
        font-size: 48px;
    }

    /* Parked sales */
    .parked-sale-item {
        padding: 12px;
        gap: 10px;
    }

    .sale-number {
        font-size: 14px;
    }

    .sale-name {
        font-size: 12px;
    }

    .sale-total {
        font-size: 14px;
    }
}

/* Landscape orientation for phones */
@media (max-width: 768px) and (orientation: landscape) {
    .pos-main {
        flex-direction: row;
    }

    .pos-products {
        height: auto;
        width: 60%;
    }

    .pos-cart {
        height: auto;
        width: 40%;
        border-left: 2px solid #e0e0e0;
        border-top: none;
    }
}

/* Small height screens (landscape phones) */
@media (max-height: 500px) {
    .pos-topbar {
        padding: 5px 10px;
    }

    .cart-tab {
        padding: 4px 8px;
    }

    .search-section {
        margin-bottom: 10px;
    }

    .search-input {
        padding: 10px 40px;
    }

    .product-image {
        height: 40px;
    }

    .cart-actions {
        padding: 6px;
    }

    .btn-pay {
        padding: 8px;
        font-size: 13px;
    }
}
</style>
