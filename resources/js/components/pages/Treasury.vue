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
          <h3>{{ formatCurrency(stats.current_month_income) }}</h3>
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
          <h3>{{ formatCurrency(stats.current_month_expense) }}</h3>
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
          <h3>{{ formatCurrency(stats.current_balance) }}</h3>
          <small :class="stats.current_balance >= 0 ? 'text-success' : 'text-danger'">
            {{ stats.current_balance >= 0 ? 'موجب' : 'سالب' }}
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
          <h3>{{ formatCurrency(stats.ytd_net) }}</h3>
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
                      {{ transaction.type === 'income' ? '+' : '-' }}{{ formatCurrency(transaction.amount) }}
                    </strong>
                  </td>
                </tr>
              </tbody>
              <tfoot class="table-light">
                <tr>
                  <td colspan="5" class="text-end fw-bold">الإجمالي:</td>
                  <td class="text-end">
                    <strong class="text-primary">{{ formatCurrency(totalAmount) }}</strong>
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
        current_month_income: 0,
        current_month_expense: 0,
        ytd_income: 0,
        ytd_expense: 0,
        current_balance: 0,
        ytd_net: 0,
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
    totalAmount() {
      if (!Array.isArray(this.transactions)) {
        return 0;
      }
      return this.transactions.reduce((sum, t) => {
        return sum + (t.type === 'income' ? parseFloat(t.amount) : -parseFloat(t.amount));
      }, 0);
    }
  },
  methods: {
    async loadStats() {
      try {
        const response = await axios.get('/dashboard/api/treasury');
        // The backend returns { status: 'ok', stats: {...} }
        this.stats = response.data.stats || {
          current_month_income: 0,
          current_month_expense: 0,
          ytd_income: 0,
          ytd_expense: 0,
          current_balance: 0,
          ytd_net: 0,
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
        // The backend returns { status: 'ok', transactions: { data: [...], current_page: ..., ... } }
        if (response.data.status === 'ok' && response.data.transactions) {
          // Check if it's paginated data
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
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-IQ', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(amount) + ' IQD';
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
    // Set default date range (current month)
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
  padding: 1.5rem;
  color: white;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  transition: transform 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
  height: 120px;
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
}

.stat-content h6 {
  font-size: 0.85rem;
  margin-bottom: 0.5rem;
  opacity: 0.9;
  font-weight: 500;
}

.stat-content h3 {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0;
}

.stat-content small {
  font-size: 0.75rem;
  opacity: 0.8;
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
