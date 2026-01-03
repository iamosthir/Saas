<template>
  <div class="row">
    <!-- Page Header -->
    <div class="col-md-12 mb-4">
      <h3 class="page-title"><i class="fas fa-money-bill-wave"></i> تسديد دفعات العملاء (الجملة)</h3>
    </div>

    <!-- Customer Selection -->
    <div class="col-md-12 mb-4">
      <div class="modern-card card">
        <div class="card-body">
          <h6 class="modern-card-title"><i class="fas fa-user"></i> اختر العميل</h6>
          <div class="row">
            <div class="col-md-8 mb-3">
              <label class="form-label">ابحث عن عميل</label>
              <multiselect
                v-model="selectedCustomer"
                :options="customers"
                label="name"
                track-by="id"
                placeholder="ابحث باسم العميل أو رقم الهاتف..."
                :searchable="true"
                :loading="loadingCustomers"
                :internal-search="false"
                @search-change="searchCustomers"
              >
                <template slot="option" slot-scope="props">
                  <div>
                    <strong>{{ props.option.name }}</strong>
                    <br>
                    <small class="text-muted">
                      <i class="fas fa-phone"></i> {{ props.option.phone1 || props.option.phone }}
                    </small>
                  </div>
                </template>
              </multiselect>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end">
              <button
                @click="loadOutstandingInvoices"
                :disabled="!selectedCustomer || loadingInvoices"
                class="btn btn-primary w-100"
              >
                <i class="fas fa-search"></i>
                {{ loadingInvoices ? 'جاري التحميل...' : 'تحميل الفواتير المستحقة' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Outstanding Invoices -->
    <div v-if="invoices.length > 0" class="col-md-12 mb-4">
      <div class="modern-card card">
        <div class="card-body">
          <h6 class="modern-card-title">
            <i class="fas fa-file-invoice-dollar"></i>
            الفواتير المستحقة - {{ selectedCustomer.name }}
          </h6>

          <!-- Summary Stats -->
          <div class="row mb-4">
            <div class="col-md-4">
              <div class="summary-card">
                <i class="fas fa-file-alt"></i>
                <div>
                  <small>عدد الفواتير</small>
                  <h5>{{ invoices.length }}</h5>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="summary-card">
                <i class="fas fa-hourglass-half text-warning"></i>
                <div>
                  <small>إجمالي المبلغ المتبقي</small>
                  <h5 class="text-warning">{{ formatCurrency(totalRemaining) }}</h5>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="summary-card">
                <i class="fas fa-check-circle text-success"></i>
                <div>
                  <small>المبلغ المختار للدفع</small>
                  <h5 class="text-success">{{ formatCurrency(selectedTotal) }}</h5>
                </div>
              </div>
            </div>
          </div>

          <!-- Invoices Table -->
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th style="width: 50px">
                    <input
                      type="checkbox"
                      @change="toggleAll"
                      :checked="allSelected"
                      class="form-check-input"
                    >
                  </th>
                  <th>رقم الفاتورة</th>
                  <th>التاريخ</th>
                  <th>نوع الدفع</th>
                  <th class="text-end">المبلغ الإجمالي</th>
                  <th class="text-end">المدفوع</th>
                  <th class="text-end">المتبقي</th>
                  <th class="text-end">المبلغ للدفع</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="invoice in invoices" :key="invoice.id">
                  <td>
                    <input
                      type="checkbox"
                      v-model="invoice.selected"
                      @change="updateSelectedTotal"
                      class="form-check-input"
                    >
                  </td>
                  <td>
                    <strong>{{ invoice.invoice_number }}</strong>
                  </td>
                  <td>{{ formatDate(invoice.created_at) }}</td>
                  <td>
                    <span :class="invoice.payment_type === 'full_payment' ? 'badge bg-primary' : 'badge bg-info'">
                      {{ invoice.payment_type === 'full_payment' ? 'دفع كامل' : 'تقسيط' }}
                    </span>
                  </td>
                  <td class="text-end">{{ formatCurrency(invoice.total_amount) }}</td>
                  <td class="text-end text-success">{{ formatCurrency(invoice.paid_amount) }}</td>
                  <td class="text-end text-danger">{{ formatCurrency(invoice.remaining_amount) }}</td>
                  <td class="text-end">
                    <input
                      v-if="invoice.selected"
                      type="number"
                      v-model.number="invoice.amount_to_pay"
                      @input="updateSelectedTotal"
                      class="form-control form-control-sm text-end"
                      :max="invoice.remaining_amount"
                      min="0"
                      step="0.01"
                    >
                    <span v-else class="text-muted">-</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Payment Section -->
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="payment-section">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="mb-0">إجمالي المبلغ المختار:</h5>
                    <small class="text-muted">{{ selectedInvoices.length }} فاتورة محددة</small>
                  </div>
                  <div class="text-end">
                    <h3 class="text-primary mb-0">{{ formatCurrency(selectedTotal) }}</h3>
                  </div>
                </div>
                <div class="mt-3">
                  <button
                    @click="processBulkPayment"
                    :disabled="selectedTotal === 0 || processing"
                    class="btn btn-success btn-lg w-100"
                  >
                    <i class="fas fa-check-circle"></i>
                    {{ processing ? 'جاري المعالجة...' : 'تأكيد الدفع' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="selectedCustomer && !loadingInvoices" class="col-md-12">
      <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        لا توجد فواتير مستحقة لهذا العميل. جميع الفواتير مدفوعة بالكامل.
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      customers: [],
      selectedCustomer: null,
      invoices: [],
      loadingCustomers: false,
      loadingInvoices: false,
      processing: false,
      totalRemaining: 0,
    }
  },
  computed: {
    selectedInvoices() {
      return this.invoices.filter(inv => inv.selected);
    },
    selectedTotal() {
      return this.selectedInvoices.reduce((sum, inv) => {
        return sum + (parseFloat(inv.amount_to_pay) || 0);
      }, 0);
    },
    allSelected() {
      return this.invoices.length > 0 && this.invoices.every(inv => inv.selected);
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
    async loadOutstandingInvoices() {
      if (!this.selectedCustomer) return;

      this.loadingInvoices = true;
      this.invoices = [];

      try {
        const response = await axios.get(
          `/dashboard/api/customer-payments/outstanding/${this.selectedCustomer.id}`
        );

        if (response.data.status === 'ok') {
          this.invoices = response.data.invoices.map(inv => ({
            ...inv,
            selected: false,
            amount_to_pay: parseFloat(inv.remaining_amount),
          }));
          this.totalRemaining = response.data.total_remaining;
        }
      } catch (error) {
        console.error('Error loading outstanding invoices:', error);
        swal.fire('خطأ', 'فشل تحميل الفواتير المستحقة', 'error');
      } finally {
        this.loadingInvoices = false;
      }
    },
    toggleAll(event) {
      const checked = event.target.checked;
      this.invoices.forEach(inv => {
        inv.selected = checked;
      });
      this.updateSelectedTotal();
    },
    updateSelectedTotal() {
      // Ensure amount_to_pay doesn't exceed remaining_amount
      this.invoices.forEach(inv => {
        if (inv.selected && inv.amount_to_pay > inv.remaining_amount) {
          inv.amount_to_pay = inv.remaining_amount;
        }
      });
      this.$forceUpdate();
    },
    async processBulkPayment() {
      if (this.selectedTotal === 0) {
        swal.fire('تحذير', 'الرجاء اختيار فاتورة واحدة على الأقل', 'warning');
        return;
      }

      // Confirmation dialog
      const result = await swal.fire({
        title: 'تأكيد الدفع',
        html: `
          <p>هل أنت متأكد من تسديد المبلغ التالي؟</p>
          <h3 class="text-primary">${this.formatCurrency(this.selectedTotal)}</h3>
          <p class="text-muted">${this.selectedInvoices.length} فاتورة محددة</p>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'نعم، تأكيد الدفع',
        cancelButtonText: 'إلغاء',
        confirmButtonColor: '#38ef7d',
        cancelButtonColor: '#eb3349',
      });

      if (!result.isConfirmed) return;

      this.processing = true;

      try {
        const payload = {
          customer_id: this.selectedCustomer.id,
          payment_amount: this.selectedTotal,
          invoices: this.selectedInvoices.map(inv => ({
            id: inv.id,
            amount_to_pay: parseFloat(inv.amount_to_pay),
          })),
        };

        const response = await axios.post('/dashboard/api/customer-payments/bulk', payload);

        if (response.data.status === 'ok') {
          swal.fire({
            title: 'نجح!',
            text: response.data.msg || 'تم تسجيل الدفع بنجاح',
            icon: 'success',
            confirmButtonColor: '#38ef7d',
          });

          // Reload invoices
          await this.loadOutstandingInvoices();
        } else {
          swal.fire('فشل', response.data.msg || 'فشل تسجيل الدفع', 'error');
        }
      } catch (error) {
        console.error('Error processing bulk payment:', error);
        swal.fire('خطأ', error.response?.data?.msg || 'حدث خطأ أثناء معالجة الدفع', 'error');
      } finally {
        this.processing = false;
      }
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
    // Load initial customers list (first 20)
    try {
      const response = await axios.get('/dashboard/api/customers');
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
}

.modern-card-title {
  color: #667eea;
  font-weight: 600;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #f0f0f0;
}

.summary-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  padding: 1.25rem;
  color: white;
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.summary-card i {
  font-size: 2rem;
  opacity: 0.8;
}

.summary-card small {
  display: block;
  opacity: 0.9;
  font-size: 0.8rem;
  margin-bottom: 0.25rem;
}

.summary-card h5 {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 700;
}

.payment-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  padding: 1.5rem;
  color: white;
}

.payment-section h5,
.payment-section h3 {
  color: white;
}

.payment-section .btn {
  background: white;
  color: #667eea;
  border: none;
  font-weight: 600;
}

.payment-section .btn:hover:not(:disabled) {
  background: #f8f9fa;
  transform: translateY(-2px);
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

.btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.form-control-sm {
  font-size: 0.875rem;
  padding: 0.25rem 0.5rem;
}

.text-success {
  color: #38ef7d !important;
}

.text-danger {
  color: #eb3349 !important;
}

.text-warning {
  color: #f5af19 !important;
}

.text-primary {
  color: #667eea !important;
}
</style>
