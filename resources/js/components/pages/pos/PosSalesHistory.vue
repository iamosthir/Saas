<template>
    <div class="pos-history-page">
        <div class="page-header">
            <h2><i class="fas fa-history"></i> سجل مبيعات نقطة البيع</h2>
            <router-link to="/dashboard/pos" class="btn btn-primary">
                <i class="fas fa-cash-register"></i> فتح نقطة البيع
            </router-link>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-row">
                <div class="filter-group">
                    <label>الحالة</label>
                    <select v-model="filters.status" @change="loadSales" class="form-control">
                        <option value="">جميع الحالات</option>
                        <option value="completed">مكتملة</option>
                        <option value="voided">ملغاة</option>
                        <option value="parked">مؤجلة</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>من تاريخ</label>
                    <input type="date" v-model="filters.from_date" @change="loadSales" class="form-control" />
                </div>
                <div class="filter-group">
                    <label>إلى تاريخ</label>
                    <input type="date" v-model="filters.to_date" @change="loadSales" class="form-control" />
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button class="btn btn-secondary" @click="clearFilters">
                        <i class="fas fa-times"></i> مسح
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards" v-if="!loading">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="summary-info">
                    <div class="summary-value">{{ summary.total_sales }}</div>
                    <div class="summary-label">إجمالي المبيعات</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="summary-info">
                    <div class="summary-label">إجمالي الإيرادات</div>
                    <template v-if="Object.keys(summary.revenue_by_currency).length">
                        <div
                            v-for="(amount, currency) in summary.revenue_by_currency"
                            :key="currency"
                            class="summary-value summary-currency-row"
                        >
                            {{ amount.toLocaleString('en-US', { minimumFractionDigits: amount % 1 ? 2 : 0, maximumFractionDigits: 2 }) }}
                            <span class="currency-tag">{{ currency }}</span>
                        </div>
                    </template>
                    <div v-else class="summary-value">0</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon items">
                    <i class="fas fa-box"></i>
                </div>
                <div class="summary-info">
                    <div class="summary-value">{{ summary.total_items }}</div>
                    <div class="summary-label">الأصناف المباعة</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon avg">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="summary-info">
                    <div class="summary-label">متوسط البيع</div>
                    <template v-if="Object.keys(summary.average_by_currency).length">
                        <div
                            v-for="(amount, currency) in summary.average_by_currency"
                            :key="currency"
                            class="summary-value summary-currency-row"
                        >
                            {{ amount.toLocaleString('en-US', { minimumFractionDigits: amount % 1 ? 2 : 0, maximumFractionDigits: 2 }) }}
                            <span class="currency-tag">{{ currency }}</span>
                        </div>
                    </template>
                    <div v-else class="summary-value">0</div>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="sales-table-card">
            <div v-if="loading" class="loading-state">
                <i class="fas fa-spinner fa-spin"></i> جاري تحميل المبيعات...
            </div>
            <div v-else-if="sales.length === 0" class="empty-state">
                <i class="fas fa-receipt"></i>
                <p>لم يتم العثور على مبيعات</p>
            </div>
            <!-- Desktop Table View -->
            <table v-else-if="!isMobile" class="sales-table">
                <thead>
                    <tr>
                        <th>رقم البيع</th>
                        <th>التاريخ</th>
                        <th>العميل</th>
                        <th>الأصناف</th>
                        <th>الإجمالي</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales" :key="sale.id" @click="viewSale(sale)">
                        <td class="sale-number">{{ sale.sale_number }}</td>
                        <td>{{ formatDate(sale.created_at) }}</td>
                        <td>{{ sale.customer?.customer_name || '-' }}</td>
                        <td>{{ sale.items?.length || 0 }}</td>
                        <td class="sale-total">{{ formatCurrency(sale.total_amount) }}</td>
                        <td>
                            <span class="status-badge" :class="sale.status">
                                {{ sale.status }}
                            </span>
                        </td>
                        <td class="actions">
                            <button class="btn-action" @click.stop="viewSale(sale)" title="عرض">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action" @click.stop="printReceipt(sale)" title="طباعة">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Mobile Card View -->
            <div v-else class="sales-cards-mobile">
                <div
                    v-for="sale in sales"
                    :key="sale.id"
                    class="sale-card-mobile"
                    @click="viewSale(sale)"
                >
                    <div class="sale-card-header">
                        <span class="sale-number-mobile">{{ sale.sale_number }}</span>
                        <span class="status-badge" :class="sale.status">
                            {{ sale.status }}
                        </span>
                    </div>
                    <div class="sale-card-body">
                        <div class="sale-card-row">
                            <span class="label">التاريخ:</span>
                            <span>{{ formatDate(sale.created_at) }}</span>
                        </div>
                        <div class="sale-card-row">
                            <span class="label">العميل:</span>
                            <span>{{ sale.customer?.customer_name || '-' }}</span>
                        </div>
                        <div class="sale-card-row">
                            <span class="label">الأصناف:</span>
                            <span>{{ sale.items?.length || 0 }}</span>
                        </div>
                        <div class="sale-card-row total-row-mobile">
                            <span class="label">الإجمالي:</span>
                            <span class="sale-total-mobile">{{ formatCurrency(sale.total_amount) }}</span>
                        </div>
                    </div>
                    <div class="sale-card-actions">
                        <button class="btn-action-mobile" @click.stop="viewSale(sale)" title="عرض">
                            <i class="fas fa-eye"></i> عرض
                        </button>
                        <button class="btn-action-mobile" @click.stop="printReceipt(sale)" title="طباعة">
                            <i class="fas fa-print"></i> طباعة
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="pagination.last_page > 1" class="pagination">
                <button
                    class="page-btn"
                    :disabled="pagination.current_page <= 1"
                    @click="goToPage(pagination.current_page - 1)"
                >
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="page-info">
                    صفحة {{ pagination.current_page }} من {{ pagination.last_page }}
                </span>
                <button
                    class="page-btn"
                    :disabled="pagination.current_page >= pagination.last_page"
                    @click="goToPage(pagination.current_page + 1)"
                >
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Sale Detail Modal -->
        <div v-if="showDetailModal" class="modal-overlay" @click.self="showDetailModal = false">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>تفاصيل البيع - {{ selectedSale?.sale_number }}</h5>
                    <button class="close-btn" @click="showDetailModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" v-if="selectedSale">
                    <div class="detail-section">
                        <div class="detail-row">
                            <span>التاريخ:</span>
                            <span>{{ formatDateTime(selectedSale.created_at) }}</span>
                        </div>
                        <div class="detail-row">
                            <span>الحالة:</span>
                            <span class="status-badge" :class="selectedSale.status">
                                {{ selectedSale.status }}
                            </span>
                        </div>
                        <div class="detail-row" v-if="selectedSale.customer">
                            <span>العميل:</span>
                            <span>{{ selectedSale.customer.customer_name }}</span>
                        </div>
                        <div class="detail-row" v-if="selectedSale.created_by">
                            <span>الكاشير:</span>
                            <span>{{ selectedSale.created_by.name }}</span>
                        </div>
                    </div>

                    <div class="items-section">
                        <h6>الأصناف</h6>
                        <!-- Desktop Table -->
                        <table v-if="!isMobile" class="items-table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in selectedSale.items" :key="item.id">
                                    <td>
                                        {{ item.product_name }}
                                        <span v-if="item.variation_name" class="variation">
                                            ({{ item.variation_name }})
                                        </span>
                                    </td>
                                    <td>{{ item.quantity }}</td>
                                    <td>{{ formatCurrency(item.unit_price) }}</td>
                                    <td>{{ formatCurrency(item.line_total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Mobile Card -->
                        <div v-else class="items-cards-mobile">
                            <div v-for="item in selectedSale.items" :key="item.id" class="item-card-mobile">
                                <div class="item-name-mobile">
                                    {{ item.product_name }}
                                    <span v-if="item.variation_name" class="variation">
                                        ({{ item.variation_name }})
                                    </span>
                                </div>
                                <div class="item-details-mobile">
                                    <span>الكمية: {{ item.quantity }}</span>
                                    <span>{{ formatCurrency(item.unit_price) }}</span>
                                    <span class="item-total-mobile">{{ formatCurrency(item.line_total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="totals-section">
                        <div class="total-row">
                            <span>المجموع الفرعي:</span>
                            <span>{{ formatCurrency(selectedSale.subtotal) }}</span>
                        </div>
                        <div class="total-row" v-if="selectedSale.discount_value > 0">
                            <span>الخصم:</span>
                            <span class="text-success">-{{ formatCurrency(selectedSale.discount_value) }}</span>
                        </div>
                        <div class="total-row" v-if="selectedSale.tax_amount > 0">
                            <span>الضريبة ({{ selectedSale.tax_rate }}%):</span>
                            <span>{{ formatCurrency(selectedSale.tax_amount) }}</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>الإجمالي:</span>
                            <span>{{ formatCurrency(selectedSale.total_amount) }}</span>
                        </div>
                    </div>

                    <div class="payments-section" v-if="selectedSale.payments?.length">
                        <h6>المدفوعات</h6>
                        <div class="payment-row" v-for="payment in selectedSale.payments" :key="payment.id">
                            <span>{{ getMethodLabel(payment.payment_method) }}</span>
                            <span>{{ formatCurrency(payment.amount) }}</span>
                        </div>
                        <div class="payment-row" v-if="selectedSale.change_amount > 0">
                            <span>الباقي:</span>
                            <span>{{ formatCurrency(selectedSale.change_amount) }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="printReceipt(selectedSale)">
                        <i class="fas fa-print"></i> طباعة الإيصال
                    </button>
                    <button class="btn btn-primary" @click="showDetailModal = false">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PosSalesHistory',
    data() {
        return {
            loading: true,
            sales: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                per_page: 20,
                total: 0,
            },
            filters: {
                status: '',
                from_date: '',
                to_date: '',
            },
            summary: {
                total_sales: 0,
                revenue_by_currency: {},
                average_by_currency: {},
                total_items: 0,
            },
            showDetailModal: false,
            selectedSale: null,
            isMobileView: false,
        };
    },
    computed: {
        isMobile() {
            return this.isMobileView;
        }
    },
    methods: {
        async loadSales(page = 1) {
            this.loading = true;
            try {
                // Build params, excluding empty filter values
                const params = {
                    page,
                    per_page: this.pagination.per_page,
                };

                // Only add filters if they have values
                if (this.filters.status) {
                    params.status = this.filters.status;
                }
                if (this.filters.from_date) {
                    params.from_date = this.filters.from_date;
                }
                if (this.filters.to_date) {
                    params.to_date = this.filters.to_date;
                }

                const response = await axios.get('/dashboard/api/pos/sales', { params });
                const data = response.data.data;

                this.sales = data.data || [];
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    per_page: data.per_page,
                    total: data.total,
                };

                this.calculateSummary();
            } catch (error) {
                console.error('Failed to load sales:', error);
            } finally {
                this.loading = false;
            }
        },

        calculateSummary() {
            const completedSales = this.sales.filter(s => s.status === 'completed');

            const revenueMap = {};
            const countMap = {};

            completedSales.forEach(s => {
                const cur = (s.currency || 'IQD').toUpperCase();
                const amount = parseFloat(s.total_amount || 0);
                revenueMap[cur] = (revenueMap[cur] || 0) + amount;
                countMap[cur]   = (countMap[cur]   || 0) + 1;
            });

            const averageMap = {};
            for (const cur in revenueMap) {
                averageMap[cur] = revenueMap[cur] / countMap[cur];
            }

            this.summary = {
                total_sales: completedSales.length,
                revenue_by_currency: revenueMap,
                average_by_currency: averageMap,
                total_items: completedSales.reduce((sum, s) => sum + (s.items?.length || 0), 0),
            };
        },

        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadSales(page);
            }
        },

        clearFilters() {
            this.filters = {
                status: '',
                from_date: '',
                to_date: '',
            };
            this.loadSales();
        },

        async viewSale(sale) {
            try {
                const response = await axios.get(`/dashboard/api/pos/sales/${sale.id}`);
                this.selectedSale = response.data.data;
                this.showDetailModal = true;
            } catch (error) {
                console.error('Failed to load sale details:', error);
            }
        },

        async printReceipt(sale) {
            try {
                const response = await axios.get(`/dashboard/api/pos/print/${sale.id}/html`, {
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

        formatCurrency(amount) {
            const value = amount || 0;
            const hasDecimals = value % 1 !== 0;

            const formattedNumber = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: hasDecimals ? 1 : 0,
                maximumFractionDigits: hasDecimals ? 2 : 0,
            }).format(value);

            // Get currency from window.currency (set globally in master.blade.php)
            const currency = window.currencyName || 'IQD';

            return `${formattedNumber} ${currency}`;
        },

        formatDate(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleDateString();
        },

        formatDateTime(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleString();
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

        checkMobileView() {
            this.isMobileView = window.innerWidth <= 480;
        },
    },
    mounted() {
        // Load all sales without date filter
        this.loadSales();

        // Check mobile view on mount and window resize
        this.checkMobileView();
        window.addEventListener('resize', this.checkMobileView);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.checkMobileView);
    },
};
</script>

<style scoped>
.summary-currency-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
    line-height: 1.4;
}

.currency-tag {
    font-size: 11px;
    font-weight: 600;
    opacity: 0.7;
    letter-spacing: 0.5px;
}
</style>
