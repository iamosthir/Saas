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
                    <div class="summary-value">{{ formatCurrency(summary.total_revenue) }}</div>
                    <div class="summary-label">إجمالي الإيرادات</div>
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
                    <div class="summary-value">{{ formatCurrency(summary.average_sale) }}</div>
                    <div class="summary-label">متوسط البيع</div>
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
                total_revenue: 0,
                total_items: 0,
                average_sale: 0,
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
                const params = {
                    page,
                    per_page: this.pagination.per_page,
                    ...this.filters,
                };

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

            this.summary = {
                total_sales: completedSales.length,
                total_revenue: completedSales.reduce((sum, s) => sum + parseFloat(s.total_amount || 0), 0),
                total_items: completedSales.reduce((sum, s) => sum + (s.items?.length || 0), 0),
                average_sale: completedSales.length > 0
                    ? completedSales.reduce((sum, s) => sum + parseFloat(s.total_amount || 0), 0) / completedSales.length
                    : 0,
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
            const currency = window.currency || 'IQD';

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
        // Set default date range to today
        const today = new Date().toISOString().split('T')[0];
        this.filters.from_date = today;
        this.filters.to_date = today;
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
.pos-history-page {
    padding: 20px;
    max-width: 100%;
    overflow-x: hidden;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    max-width: 100%;
    overflow: hidden;
}

.page-header h2 {
    margin: 0;
    word-break: break-word;
}

/* Filters */
.filters-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    max-width: 100%;
    overflow: hidden;
}

.filters-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 150px;
}

.filter-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
}

/* Summary Cards */
.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
    max-width: 100%;
}

.summary-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.summary-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e3f2fd;
    color: #2196f3;
    font-size: 20px;
}

.summary-icon.revenue {
    background: #e8f5e9;
    color: #4caf50;
}

.summary-icon.items {
    background: #fff3e0;
    color: #ff9800;
}

.summary-icon.avg {
    background: #f3e5f5;
    color: #9c27b0;
}

.summary-value {
    font-size: 24px;
    font-weight: 700;
}

.summary-label {
    font-size: 14px;
    color: #666;
}

/* Sales Table */
.sales-table-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    max-width: 100%;
}

.loading-state, .empty-state {
    text-align: center;
    padding: 60px;
    color: #888;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.5;
}

.sales-table {
    width: 100%;
    border-collapse: collapse;
}

.sales-table th,
.sales-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.sales-table th {
    background: #f5f5f5;
    font-weight: 600;
    font-size: 14px;
}

.sales-table tbody tr {
    cursor: pointer;
    transition: background 0.2s;
}

.sales-table tbody tr:hover {
    background: #f9f9f9;
}

.sale-number {
    font-weight: 600;
    color: #2196f3;
}

.sale-total {
    font-weight: 600;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    text-transform: capitalize;
}

.status-badge.completed {
    background: #e8f5e9;
    color: #4caf50;
}

.status-badge.voided {
    background: #ffebee;
    color: #f44336;
}

.status-badge.parked {
    background: #fff3e0;
    color: #ff9800;
}

.status-badge.draft {
    background: #e0e0e0;
    color: #666;
}

.actions {
    display: flex;
    gap: 5px;
}

.btn-action {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    background: #f0f0f0;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-action:hover {
    background: #e0e0e0;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    padding: 20px;
    border-top: 1px solid #e0e0e0;
}

.page-btn {
    width: 36px;
    height: 36px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    transition: all 0.2s;
}

.page-btn:hover:not(:disabled) {
    background: #f5f5f5;
}

.page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-info {
    color: #666;
}

/* Modal */
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
    max-width: 600px;
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

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 15px 20px;
    border-top: 1px solid #e0e0e0;
}

/* Detail Sections */
.detail-section {
    margin-bottom: 20px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.items-section, .payments-section {
    margin-bottom: 20px;
}

.items-section h6, .payments-section h6 {
    margin-bottom: 10px;
    color: #666;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.items-table th, .items-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.items-table th {
    background: #f5f5f5;
}

.variation {
    font-size: 12px;
    color: #888;
}

.totals-section {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
}

.total-row.grand-total {
    font-size: 18px;
    font-weight: 700;
    border-top: 1px solid #e0e0e0;
    margin-top: 10px;
    padding-top: 10px;
}

.payment-row {
    display: flex;
    justify-content: space-between;
    padding: 8px;
    background: #f5f5f5;
    border-radius: 6px;
    margin-bottom: 5px;
}

.text-success {
    color: #4caf50;
}

/* ============================================
   MOBILE RESPONSIVE STYLES
============================================ */

/* Tablet and below */
@media (max-width: 768px) {
    .pos-history-page {
        padding: 15px;
    }

    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .page-header h2 {
        font-size: 20px;
    }

    .page-header .btn {
        width: 100%;
        justify-content: center;
    }

    /* Filters */
    .filters-card {
        padding: 15px;
    }

    .filters-row {
        flex-direction: column;
        gap: 15px;
    }

    .filter-group {
        min-width: 100%;
    }

    .filter-group button {
        width: 100%;
        padding: 12px;
        font-size: 14px;
    }

    /* Better touch targets */
    .btn {
        min-height: 44px;
        padding: 12px 20px;
    }

    /* Summary cards */
    .summary-cards {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .summary-card {
        padding: 15px;
    }

    .summary-icon {
        width: 45px;
        height: 45px;
        font-size: 18px;
    }

    .summary-value {
        font-size: 20px;
    }

    .summary-label {
        font-size: 12px;
    }

    /* Table - Make it scrollable on tablet */
    .sales-table-card {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .sales-table {
        min-width: 700px;
    }

    .sales-table th,
    .sales-table td {
        padding: 12px 10px;
        font-size: 13px;
        white-space: nowrap;
    }

    /* Modal adjustments */
    .modal-content {
        width: 95%;
        max-height: 95vh;
    }

    .modal-body {
        padding: 15px;
    }

    .modal-footer {
        flex-direction: column-reverse;
        gap: 8px;
    }

    .modal-footer .btn {
        width: 100%;
    }

    .items-table {
        font-size: 12px;
    }

    .items-table th,
    .items-table td {
        padding: 8px 5px;
    }

    .detail-row {
        font-size: 14px;
    }

    .total-row.grand-total {
        font-size: 16px;
    }
}

/* Mobile phones */
@media (max-width: 480px) {
    .pos-history-page {
        padding: 10px;
    }

    .pos-history-page * {
        max-width: 100%;
    }

    .page-header h2 {
        font-size: 18px;
    }

    .page-header h2 i {
        font-size: 16px;
    }

    .filters-card {
        padding: 12px;
    }

    .form-control {
        padding: 8px 10px;
        font-size: 13px;
    }

    /* Summary cards - stack in single column */
    .summary-cards {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .summary-card {
        padding: 12px;
        gap: 12px;
    }

    .summary-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .summary-value {
        font-size: 18px;
    }

    .summary-label {
        font-size: 11px;
    }

    /* Sales table card - remove card styling on mobile */
    .sales-table-card {
        background: transparent;
        box-shadow: none;
        padding: 0;
        border-radius: 0;
    }

    /* Loading and empty states */
    .loading-state,
    .empty-state {
        background: white;
        border-radius: 8px;
        padding: 40px 20px;
    }

    /* Mobile Card View Styles */
    .sales-cards-mobile {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .sale-card-mobile {
        background: white;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        cursor: pointer;
        transition: all 0.2s;
    }

    .sale-card-mobile:hover {
        background: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .sale-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .sale-number-mobile {
        font-size: 16px;
        font-weight: 700;
        color: #2196f3;
    }

    .sale-card-body {
        margin-bottom: 10px;
    }

    .sale-card-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        font-size: 13px;
    }

    .sale-card-row .label {
        color: #666;
        font-weight: 500;
    }

    .sale-card-row.total-row-mobile {
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
    }

    .sale-total-mobile {
        font-size: 16px;
        font-weight: 700;
        color: #2196f3;
    }

    .sale-card-actions {
        display: flex;
        gap: 8px;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
    }

    .btn-action-mobile {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-action-mobile:hover {
        background: #f5f5f5;
        border-color: #2196f3;
        color: #2196f3;
    }

    /* Pagination */
    .pagination {
        padding: 15px 0;
        background: transparent;
    }

    .page-btn {
        width: 44px;
        height: 44px;
        font-size: 16px;
    }

    .page-info {
        font-size: 13px;
        font-weight: 500;
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

    .modal-body {
        padding: 12px;
    }

    .modal-footer {
        padding: 12px 15px;
    }

    /* Detail sections */
    .detail-row {
        font-size: 13px;
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
    }

    .items-section h6,
    .payments-section h6 {
        font-size: 14px;
    }

    /* Mobile Items Card View */
    .items-cards-mobile {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .item-card-mobile {
        background: #f9f9f9;
        border-radius: 6px;
        padding: 10px;
    }

    .item-name-mobile {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 6px;
        color: #333;
    }

    .item-details-mobile {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: #666;
        gap: 10px;
    }

    .item-total-mobile {
        font-weight: 600;
        color: #2196f3;
        font-size: 13px;
    }

    .variation {
        font-size: 11px;
        color: #888;
    }

    .totals-section {
        padding: 12px;
    }

    .total-row {
        font-size: 13px;
    }

    .total-row.grand-total {
        font-size: 15px;
    }

    .payment-row {
        padding: 6px 10px;
        font-size: 13px;
    }

    .status-badge {
        font-size: 11px;
        padding: 3px 10px;
    }
}

/* Very small phones */
@media (max-width: 360px) {
    .page-header h2 {
        font-size: 16px;
    }

    .summary-value {
        font-size: 16px;
    }

    .summary-label {
        font-size: 10px;
    }

    .summary-icon {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }

    .sale-number {
        font-size: 14px;
    }

    .sale-total {
        font-size: 14px;
    }
}

/* Landscape mode for tablets */
@media (max-width: 1024px) and (orientation: landscape) {
    .summary-cards {
        grid-template-columns: repeat(4, 1fr);
    }
}
</style>
