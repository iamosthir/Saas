<template>
  <div class="row">
    <!-- Page Header -->
    <div class="col-md-12 mb-4">
      <h3 class="page-title"><i class="fas fa-bolt"></i> إنشاء فاتورة سريعة</h3>
    </div>

    <!-- Step 1: Customer Selection -->
    <div v-if="step === 1" class="col-md-12">
      <div class="modern-card card">
        <div class="card-body text-center py-5">
          <div class="customer-select-container">
            <i class="fas fa-user-circle select-icon mb-4"></i>
            <h5 class="mb-4">اختر العميل لعرض ملخصه</h5>
            <div class="row justify-content-center">
              <div class="col-md-6">
                <multiselect
                  v-model="selectedCustomer"
                  :options="customers"
                  label="customer_name"
                  track-by="id"
                  placeholder="ابحث عن عميل..."
                  :searchable="true"
                  :loading="loadingCustomers"
                  @search-change="searchCustomers"
                  @select="loadCustomerSummary"
                >
                  <template slot="option" slot-scope="props">
                    <div>
                      <strong>{{ props.option.customer_name }}</strong>
                      <br>
                      <small class="text-muted">
                        <i class="fas fa-phone"></i> {{ props.option.phone1 }}
                        <span v-if="props.option.phone2"> | {{ props.option.phone2 }}</span>
                      </small>
                    </div>
                  </template>
                </multiselect>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 2: Customer Summary -->
    <div v-if="step === 2" class="col-md-12">
      <!-- Customer Info Card -->
      <div class="modern-card card mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="mb-1">
                <i class="fas fa-user"></i> {{ summary.customer.name }}
              </h5>
              <small class="text-muted">
                <i class="fas fa-phone"></i> {{ summary.customer.phone1 }}
                <span v-if="summary.customer.phone2"> | {{ summary.customer.phone2 }}</span>
              </small>
              <div v-if="summary.customer.address" class="mt-1">
                <small class="text-muted">
                  <i class="fas fa-map-marker-alt"></i> {{ summary.customer.address }}
                </small>
              </div>
              <div v-if="summary.customer.sponsor_name" class="mt-1">
                <small class="text-info">
                  <i class="fas fa-handshake"></i> الراعي: {{ summary.customer.sponsor_name }}
                  <span v-if="summary.customer.sponsor_phone">({{ summary.customer.sponsor_phone }})</span>
                </small>
              </div>
            </div>
            <button @click="backToCustomerSelect" class="btn btn-sm btn-secondary">
              <i class="fas fa-arrow-right"></i> تغيير العميل
            </button>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row mb-4">
        <div class="col-md-3 mb-3">
          <div class="stat-card invoices-card">
            <div class="stat-icon">
              <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-content">
              <small>إجمالي الفواتير</small>
              <h3>{{ summary.stats.total_invoices }}</h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="stat-card remaining-card">
            <div class="stat-icon">
              <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-content">
              <small>المبلغ المتبقي</small>
              <h3>{{ formatCurrency(summary.stats.total_remaining) }}</h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="stat-card paid-card">
            <div class="stat-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
              <small>المبلغ المدفوع</small>
              <h3>{{ formatCurrency(summary.stats.total_paid) }}</h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="stat-card installments-card">
            <div class="stat-icon">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
              <small>الأقساط النشطة</small>
              <h3>{{ summary.stats.active_installments }}</h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Previous Purchases -->
      <div class="modern-card card mb-4">
        <div class="card-body">
          <h6 class="modern-card-title"><i class="fas fa-history"></i> المشتريات السابقة</h6>

          <div v-if="summary.previous_purchases && summary.previous_purchases.length > 0" class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>رقم الفاتورة</th>
                  <th>المنتج</th>
                  <th>المتغير</th>
                  <th class="text-center">الكمية</th>
                  <th class="text-end">السعر</th>
                  <th class="text-end">الإجمالي</th>
                  <th>التاريخ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(purchase, index) in summary.previous_purchases" :key="index">
                  <td>
                    <strong class="text-primary">{{ purchase.invoice_number }}</strong>
                  </td>
                  <td>{{ purchase.product_name }}</td>
                  <td>
                    <span v-if="purchase.variation_name" class="badge bg-secondary">
                      {{ purchase.variation_name }}
                    </span>
                    <span v-else class="text-muted">-</span>
                  </td>
                  <td class="text-center">{{ purchase.quantity }}</td>
                  <td class="text-end">{{ formatCurrency(purchase.price) }}</td>
                  <td class="text-end">
                    <strong>{{ formatCurrency(purchase.total) }}</strong>
                  </td>
                  <td>{{ formatDate(purchase.date) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="alert alert-info mb-0">
            <i class="fas fa-info-circle"></i> لا توجد مشتريات سابقة لهذا العميل
          </div>
        </div>
      </div>

      <!-- Action Button -->
      <div class="text-center">
        <button @click="proceedToInvoice" class="btn btn-success btn-lg px-5 shadow-lg">
          <i class="fas fa-plus-circle"></i> إنشاء فاتورة جديدة لهذا العميل
        </button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="col-md-12">
      <div class="text-center py-5">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
          <span class="visually-hidden">جاري التحميل...</span>
        </div>
        <p class="mt-3 text-muted">جاري تحميل ملخص العميل...</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      step: 1,
      customers: [],
      selectedCustomer: null,
      summary: {
        customer: {
          id: null,
          name: '',
          phone1: '',
          phone2: '',
          address: '',
          sponsor_name: '',
          sponsor_phone: '',
        },
        stats: {
          total_invoices: 0,
          total_amount: 0,
          total_remaining: 0,
          total_paid: 0,
          active_installments: 0,
        },
        previous_purchases: [],
      },
      loadingCustomers: false,
      loading: false,
    }
  },
  methods: {
    async searchCustomers(query) {
      if (!query || query.length < 2) return;

      this.loadingCustomers = true;
      try {
        const response = await axios.get(`/dashboard/api/customers?search=${query}`);
        this.customers = response.data.data || response.data;
      } catch (error) {
        console.error('Error searching customers:', error);
      } finally {
        this.loadingCustomers = false;
      }
    },
    async loadCustomerSummary(customer) {
      if (!customer) return;

      this.loading = true;
      this.step = 2;

      try {
        const response = await axios.get(
          `/dashboard/api/quick-invoice/customer/${customer.id}/summary`
        );

        if (response.data.status === 'ok') {
          this.summary = {
            customer: response.data.customer,
            stats: response.data.stats,
            previous_purchases: response.data.previous_purchases,
          };
        }
      } catch (error) {
        console.error('Error loading customer summary:', error);
        swal.fire('خطأ', 'فشل تحميل ملخص العميل', 'error');
        this.step = 1;
      } finally {
        this.loading = false;
      }
    },
    backToCustomerSelect() {
      this.step = 1;
      this.selectedCustomer = null;
    },
    proceedToInvoice() {
      // Navigate to create invoice page with pre-selected customer
      this.$router.push({
        name: 'invoice.create',
        params: {
          customerId: this.summary.customer.id,
        },
      });
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
        month: 'short',
        day: 'numeric',
      });
    }
  },
  async mounted() {
    // Load initial customers list
    try {
      const response = await axios.get('/dashboard/api/customer-list');
      this.customers = response.data;
    } catch (error) {
      console.error('Error loading customers:', error);
    }
  }
}
</script>

<style scoped>
.page-title {
  color: #667eea;
  font-weight: 600;
  margin: 0;
}

.modern-card {
  border-radius: 15px;
  border: none;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.modern-card:hover {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

.modern-card-title {
  color: #667eea;
  font-weight: 600;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #f0f0f0;
}

.customer-select-container {
  padding: 2rem;
}

.select-icon {
  font-size: 5rem;
  color: #667eea;
  opacity: 0.3;
}

.stat-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  padding: 1.25rem;
  color: white;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  transition: transform 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
  height: 100px;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card.invoices-card {
  background: linear-gradient(135deg, #4776e6 0%, #8e54e9 100%);
}

.stat-card.remaining-card {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card.paid-card {
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.stat-card.installments-card {
  background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
}

.stat-icon {
  font-size: 2.5rem;
  opacity: 0.8;
}

.stat-content small {
  display: block;
  opacity: 0.9;
  font-size: 0.75rem;
  margin-bottom: 0.25rem;
}

.stat-content h3 {
  margin: 0;
  font-size: 1.75rem;
  font-weight: 700;
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

.btn {
  border-radius: 8px;
  padding: 0.5rem 1.5rem;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.btn-lg {
  padding: 0.75rem 2rem;
  font-size: 1.1rem;
}

.shadow-lg {
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
}

.text-success {
  color: #38ef7d !important;
}

.text-danger {
  color: #eb3349 !important;
}

.text-info {
  color: #4776e6 !important;
}

.text-primary {
  color: #667eea !important;
}
</style>
