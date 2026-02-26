<template>
  <div class="row">
    <!-- Page Header -->
    <div class="col-md-12 mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <h3 class="page-title"><i class="fas fa-cash-register"></i> إدارة الخزينة</h3>
        <button @click="exportReport" class="btn btn-success">
          <i class="fas fa-file-excel"></i> تصدير تقرير
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
      <div class="stat-card income-card">
        <div class="stat-icon">
          <i class="fas fa-arrow-down"></i>
        </div>
        <div class="stat-content">
          <h6>الإيرادات (الشهر الحالي)</h6>
          <div v-if="hasStat(stats.current_month_income)">
            <div v-for="(amount, cur) in stats.current_month_income" :key="cur" class="currency-line">
              <span class="currency-tag">{{ cur }}</span>
              <strong>{{ formatAmount(amount) }}</strong>
            </div>
          </div>
          <h3 v-else>0</h3>
          <small class="text-muted">{{ currentMonthName }}</small>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="stat-card expense-card">
        <div class="stat-icon">
          <i class="fas fa-arrow-up"></i>
        </div>
        <div class="stat-content">
          <h6>المصروفات (الشهر الحالي)</h6>
          <div v-if="hasStat(stats.current_month_expense)">
            <div v-for="(amount, cur) in stats.current_month_expense" :key="cur" class="currency-line">
              <span class="currency-tag">{{ cur }}</span>
              <strong>{{ formatAmount(amount) }}</strong>
            </div>
          </div>
          <h3 v-else>0</h3>
          <small class="text-muted">{{ currentMonthName }}</small>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="stat-card balance-card">
        <div class="stat-icon">
          <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-content">
          <h6>الرصيد الحالي</h6>
          <div v-if="hasStat(stats.current_balance)">
            <div v-for="(amount, cur) in stats.current_balance" :key="cur" class="currency-line">
              <span class="currency-tag">{{ cur }}</span>
              <strong :class="amount >= 0 ? 'positive' : 'negative'">{{ formatAmount(amount) }}</strong>
            </div>
          </div>
          <h3 v-else>0</h3>
          <small :class="overallBalancePositive ? 'text-muted' : 'negative-text'">
            {{ overallBalancePositive ? 'موجب' : 'سالب' }}
          </small>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="stat-card ytd-card">
        <div class="stat-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-content">
          <h6>صافي الربح (السنة)</h6>
          <div v-if="hasStat(stats.ytd_net)">
            <div v-for="(amount, cur) in stats.ytd_net" :key="cur" class="currency-line">
              <span class="currency-tag">{{ cur }}</span>
              <strong :class="amount >= 0 ? '' : 'negative'">{{ formatAmount(amount) }}</strong>
            </div>
          </div>
          <h3 v-else>0</h3>
          <small class="text-muted">من بداية السنة</small>
        </div>
      </div>
    </div>

    <!-- Filters Section -->
    <div class="col-md-12 mb-4">
      <div class="modern-card card">
        <div class="card-body">
          <h6 class="modern-card-title"><i class="fas fa-filter"></i> تصفية المعاملات</h6>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label">من تاريخ</label>
              <input type="date" v-model="filters.from_date" class="form-control" @change="loadTransactions">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">إلى تاريخ</label>
              <input type="date" v-model="filters.to_date" class="form-control" @change="loadTransactions">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">النوع</label>
              <select v-model="filters.type" class="form-control" @change="loadTransactions">
                <option value="">الكل</option>
                <option value="income">إيرادات</option>
                <option value="expense">مصروفات</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">الفئة</label>
              <select v-model="filters.category" class="form-control" @change="loadTransactions">
                <option value="">الكل</option>
                <option value="invoice_payment">دفعات الفواتير</option>
                <option value="deposit">دفعات مقدمة</option>
                <option value="installment">أقساط</option>
                <option value="expense">مصروفات</option>
                <option value="refund">مرتجعات</option>
                <option value="other">أخرى</option>
              </select>
            </div>
          </div>
          <div class="text-end">
            <button @click="resetFilters" class="btn btn-secondary btn-sm">
              <i class="fas fa-redo"></i> إعادة تعيين
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Transactions Table -->
    <div class="col-md-12">
      <div class="modern-card card">
        <div class="card-body">
          <h6 class="modern-card-title"><i class="fas fa-list"></i> سجل المعاملات</h6>

          <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">جاري التحميل...</span>
            </div>
          </div>

          <div v-else-if="transactions.length === 0" class="alert alert-info">
            <i class="fas fa-info-circle"></i> لا توجد معاملات في هذه الفترة
          </div>

          <div v-else class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>التاريخ</th>
                  <th>النوع</th>
                  <th>الفئة</th>
                  <th>الوصف</th>
                  <th class="text-end">المبلغ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(transaction, index) in transactions" :key="transaction.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ formatDate(transaction.transaction_date) }}</td>
                  <td>
                    <span :class="transaction.type === 'income' ? 'badge bg-success' : 'badge bg-danger'">
                      {{ transaction.type === 'income' ? 'إيراد' : 'مصروف' }}
                    </span>
                  </td>
                  <td>{{ getCategoryLabel(transaction.category) }}</td>
                  <td>{{ transaction.description }}</td>
                  <td class="text-end">
                    <strong :class="transaction.type === 'income' ? 'text-success' : 'text-danger'">
                      {{ transaction.type === 'income' ? '+' : '-' }}{{ formatAmount(transaction.amount) }}
                    </strong>
                    <span class="ms-1 badge bg-light text-secondary" style="font-size:10px;">
                      {{ transaction.currency || 'IQD' }}
                    </span>
                  </td>
                </tr>
              </tbody>
              <tfoot class="table-light">
                <tr>
                  <td colspan="5" class="text-end fw-bold">الإجمالي:</td>
                  <td class="text-end">
                    <div v-if="Object.keys(totalByCurrency).length > 0">
                      <div v-for="(amount, cur) in totalByCurrency" :key="cur">
                        <strong :class="amount >= 0 ? 'text-success' : 'text-danger'">
                          {{ amount >= 0 ? '+' : '' }}{{ formatAmount(amount) }} {{ cur }}
                        </strong>
                      </div>
                    </div>
                    <strong v-else class="text-primary">0 IQD</strong>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stats: {
        current_month_income: {},
        current_month_expense: {},
        ytd_net: {},
        current_balance: {},
      },
      transactions: [],
      loading: false,
      filters: {
        from_date: '',
        to_date: '',
        type: '',
        category: '',
      },
    }
  },
  computed: {
    currentMonthName() {
      const months = [
        'يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو',
        'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
      ];
      return months[new Date().getMonth()];
    },
    overallBalancePositive() {
      const bal = this.stats.current_balance || {};
      return Object.values(bal).every(v => v >= 0);
    },
    totalByCurrency() {
      if (!Array.isArray(this.transactions)) return {};
      return this.transactions.reduce((acc, t) => {
        const cur = (t.currency || 'IQD').toUpperCase();
        const val = t.type === 'income' ? parseFloat(t.amount) : -parseFloat(t.amount);
        acc[cur] = (acc[cur] || 0) + val;
        return acc;
      }, {});
    },
  },
  methods: {
    hasStat(map) {
      return map && typeof map === 'object' && Object.keys(map).length > 0;
    },
    formatAmount(amount) {
      const num = parseFloat(amount) || 0;
      const hasDecimals = Math.round(num * 100) !== Math.round(num) * 100;
      return new Intl.NumberFormat('en', {
        minimumFractionDigits: hasDecimals ? 2 : 0,
        maximumFractionDigits: hasDecimals ? 2 : 0,
      }).format(num);
    },
    async loadStats() {
      try {
        const response = await axios.get('/dashboard/api/treasury');
        this.stats = response.data.stats || {
          current_month_income: {},
          current_month_expense: {},
          ytd_net: {},
          current_balance: {},
        };
      } catch (error) {
        console.error('Error loading treasury stats:', error);
        swal.fire('خطأ', 'فشل تحميل إحصائيات الخزينة', 'error');
      }
    },
    async loadTransactions() {
      this.loading = true;
      try {
        const params = new URLSearchParams();
        if (this.filters.from_date) params.append('date_from', this.filters.from_date);
        if (this.filters.to_date) params.append('date_to', this.filters.to_date);
        if (this.filters.type) params.append('type', this.filters.type);
        if (this.filters.category) params.append('category', this.filters.category);

        const response = await axios.get(`/dashboard/api/treasury/transactions?${params.toString()}`);
        if (response.data.status === 'ok' && response.data.transactions) {
          if (response.data.transactions.data) {
            this.transactions = response.data.transactions.data;
          } else {
            this.transactions = response.data.transactions;
          }
        } else {
          this.transactions = [];
        }
      } catch (error) {
        console.error('Error loading transactions:', error);
        this.transactions = [];
        swal.fire('خطأ', 'فشل تحميل المعاملات', 'error');
      } finally {
        this.loading = false;
      }
    },
    resetFilters() {
      this.filters = {
        from_date: '',
        to_date: '',
        type: '',
        category: '',
      };
      this.loadTransactions();
    },
    async exportReport() {
      try {
        const params = new URLSearchParams();
        if (this.filters.from_date) params.append('from_date', this.filters.from_date);
        if (this.filters.to_date) params.append('to_date', this.filters.to_date);
        if (this.filters.type) params.append('type', this.filters.type);
        if (this.filters.category) params.append('category', this.filters.category);

        window.location.href = `/dashboard/api/treasury/export?${params.toString()}`;
      } catch (error) {
        console.error('Error exporting report:', error);
        swal.fire('خطأ', 'فشل تصدير التقرير', 'error');
      }
    },
    getCategoryLabel(category) {
      const labels = {
        'invoice_payment': 'دفعات الفواتير',
        'deposit': 'دفعة مقدمة',
        'installment': 'قسط',
        'expense': 'مصروف',
        'refund': 'مرتجع',
        'other': 'أخرى',
      };
      return labels[category] || category;
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('ar-IQ', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      });
    }
  },
  mounted() {
    const now = new Date();
    const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
    const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

    this.filters.from_date = firstDay.toISOString().split('T')[0];
    this.filters.to_date = lastDay.toISOString().split('T')[0];

    this.loadStats();
    this.loadTransactions();
  }
}
</script>

<style scoped>
.page-title {
  color: #667eea;
  font-weight: 600;
  margin: 0;
}

.stat-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 15px;
  padding: 1.25rem;
  color: white;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  transition: transform 0.3s ease;
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  min-height: 120px;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card.income-card {
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.stat-card.expense-card {
  background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
}

.stat-card.balance-card {
  background: linear-gradient(135deg, #4776e6 0%, #8e54e9 100%);
}

.stat-card.ytd-card {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon {
  font-size: 2.5rem;
  opacity: 0.8;
  padding-top: 0.25rem;
}

.stat-content {
  flex: 1;
  min-width: 0;
}

.stat-content h6 {
  font-size: 0.85rem;
  margin-bottom: 0.4rem;
  opacity: 0.9;
  font-weight: 500;
}

.stat-content h3 {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0 0 0.25rem;
}

.stat-content small {
  font-size: 0.75rem;
  opacity: 0.8;
}

.currency-line {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  margin-bottom: 0.2rem;
  font-size: 1rem;
  font-weight: 700;
}

.currency-tag {
  font-size: 0.65rem;
  font-weight: 600;
  background: rgba(255,255,255,0.25);
  border-radius: 4px;
  padding: 1px 5px;
  letter-spacing: 0.5px;
  flex-shrink: 0;
}

.positive {
  color: #d4ffd4;
}

.negative {
  color: #ffd4d4;
}

.negative-text {
  color: #ffd4d4 !important;
}

.modern-card {
  border-radius: 15px;
  border: none;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.modern-card-title {
  color: #667eea;
  font-weight: 600;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #f0f0f0;
}

.table {
  margin-bottom: 0;
}

.table thead th {
  border-bottom: 2px solid #dee2e6;
  font-weight: 600;
  color: #495057;
  font-size: 0.9rem;
}

.table tbody tr {
  transition: background-color 0.2s ease;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
}

.badge {
  padding: 0.4rem 0.8rem;
  font-weight: 500;
  font-size: 0.75rem;
}

.form-label {
  font-weight: 500;
  color: #495057;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.btn {
  border-radius: 8px;
  padding: 0.5rem 1.5rem;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.text-success {
  color: #38ef7d !important;
}

.text-danger {
  color: #eb3349 !important;
}

.text-primary {
  color: #667eea !important;
}
</style>
