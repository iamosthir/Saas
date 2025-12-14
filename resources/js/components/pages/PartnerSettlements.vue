<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <strong>تسويات الشركاء</strong> <i class="fas fa-money-bill-wave"></i>
            </h5>
            <div class="d-flex gap-2">
              <button class="btn btn-success btn-sm" @click="showGenerateModal">
                <i class="fas fa-calculator"></i> إنشاء تسويات
              </button>
              <button class="btn btn-info btn-sm" @click="viewAllSettlements">
                <i class="fas fa-list"></i> عرض الكل
              </button>
            </div>
          </div>
          <div class="card-body">
            <!-- Filters -->
            <div class="row mb-3">
              <div class="col-md-3">
                <label class="form-label">السنة</label>
                <select class="form-select" v-model="filters.year" @change="fetchSettlements">
                  <option value="">كل السنوات</option>
                  <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">الشهر</label>
                <select class="form-select" v-model="filters.month" @change="fetchSettlements">
                  <option value="">كل الأشهر</option>
                  <option v-for="month in months" :key="month.value" :value="month.value">{{ month.label }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">الحالة</label>
                <select class="form-select" v-model="filters.status" @change="fetchSettlements">
                  <option value="">كل الحالات</option>
                  <option value="pending">معلق</option>
                  <option value="paid">مدفوع</option>
                </select>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>الشريك</th>
                    <th>الفترة</th>
                    <th>صافي الربح</th>
                    <th>نسبة الشريك %</th>
                    <th>مبلغ الشريك</th>
                    <th>الحالة</th>
                    <th>تاريخ الإنشاء</th>
                    <th>تاريخ الدفع</th>
                    <th>الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="settlement in settlements" :key="settlement.id">
                    <td>{{ settlement.partner.name }}</td>
                    <td>{{ settlement.formatted_period }}</td>
                    <td>{{ formatCurrency(settlement.net_profit) }}</td>
                    <td>{{ settlement.partner_percent }}%</td>
                    <td>{{ formatCurrency(settlement.partner_amount) }}</td>
                    <td>
                      <span class="badge" :class="settlement.status === 'paid' ? 'bg-success' : 'bg-warning'">
                        {{ settlement.status === 'paid' ? 'مدفوع' : 'معلق' }}
                      </span>
                    </td>
                    <td>{{ formatDate(settlement.generated_at) }}</td>
                    <td>{{ settlement.paid_at ? formatDate(settlement.paid_at) : '-' }}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-info" @click="viewProfitBreakdown(settlement.period_year, settlement.period_month)">
                          <i class="fas fa-chart-pie"></i>
                        </button>
                        <button class="btn btn-outline-success" @click="markAsPaid(settlement)" v-if="settlement.status === 'pending'">
                          <i class="fas fa-check"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
              <div class="col-md-4">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <h5 class="card-title">إجمالي مبلغ الشركاء</h5>
                    <h3>{{ formatCurrency(summary.total_amount) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card bg-warning text-white">
                  <div class="card-body">
                    <h5 class="card-title">المبلغ المعلق</h5>
                    <h3>{{ formatCurrency(summary.total_pending) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <h5 class="card-title">المبلغ المدفوع</h5>
                    <h3>{{ formatCurrency(summary.total_paid) }}</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Generate Settlements Modal -->
    <div class="modal fade" id="generateModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">إنشاء تسويات الشركاء</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="generateSettlements">
              <div class="mb-3">
                <label class="form-label">السنة</label>
                <input type="number" class="form-control" v-model="generateForm.year" :class="{'is-invalid' : generateForm.errors.has('year')}" required min="2020" max="2100">
                <HasError :form="generateForm" field="year" />
              </div>
              <div class="mb-3">
                <label class="form-label">الشهر</label>
                <select class="form-select" v-model="generateForm.month" :class="{'is-invalid' : generateForm.errors.has('month')}" required>
                  <option value="">اختر الشهر</option>
                  <option v-for="month in months" :key="month.value" :value="month.value">{{ month.label }}</option>
                </select>
                <HasError :form="generateForm" field="month" />
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" v-model="generateForm.force" id="forceRegenerate">
                  <label class="form-check-label" for="forceRegenerate">
                    إعادة الإنشاء (استبدال التسويات الموجودة)
                  </label>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="button" class="btn btn-primary" @click="generateSettlements" :disabled="generateForm.busy">
              إنشاء
            </button>
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
      settlements: [],
      summary: {
        total_amount: 0,
        total_pending: 0,
        total_paid: 0
      },
      years: [],
      months: [
        { value: 1, label: 'يناير' },
        { value: 2, label: 'فبراير' },
        { value: 3, label: 'مارس' },
        { value: 4, label: 'أبريل' },
        { value: 5, label: 'مايو' },
        { value: 6, label: 'يونيو' },
        { value: 7, label: 'يوليو' },
        { value: 8, label: 'أغسطس' },
        { value: 9, label: 'سبتمبر' },
        { value: 10, label: 'أكتوبر' },
        { value: 11, label: 'نوفمبر' },
        { value: 12, label: 'ديسمبر' }
      ],
      filters: {
        year: '',
        month: '',
        status: ''
      },
      generateForm: new Form({
        year: new Date().getFullYear(),
        month: new Date().getMonth() + 1,
        force: false
      })
    }
  },
  methods: {
    async fetchSettlements() {
      try {
        const params = new URLSearchParams();
        if (this.filters.year) params.append('year', this.filters.year);
        if (this.filters.month) params.append('month', this.filters.month);
        if (this.filters.status) params.append('status', this.filters.status);

        const response = await axios.get(`/dashboard/api/partner-all-settlements?${params}`);
        this.settlements = response.data.data.data;
        this.summary = {
          total_amount: response.data.total_amount || 0,
          total_pending: response.data.total_pending || 0,
          total_paid: response.data.total_paid || 0
        };
      } catch (error) {
        swal.fire("خطأ", "فشل تحميل التسويات.", "error");
      }
    },
    async fetchYears() {
      try {
        const response = await axios.get('/dashboard/api/partner-all-settlements');
        this.years = response.data.years || [];
      } catch (error) {
        console.error("فشل تحميل السنوات:", error);
      }
    },
    showGenerateModal() {
      new mdb.Modal(document.getElementById('generateModal')).show();
    },
    async generateSettlements() {
      this.generateForm.post('/dashboard/api/partner-settlements-generate')
        .then(response => {
          swal.fire("نجاح", "تم إنشاء التسويات بنجاح!", "success");
          mdb.Modal.getInstance(document.getElementById('generateModal')).hide();
          this.fetchSettlements();
        })
        .catch(err => {
          swal.fire("خطأ", "فشل إنشاء التسويات.", "error");
        });
    },
    async markAsPaid(settlement) {
      const result = await swal.fire({
        title: 'تعيين كمدفوع؟',
        text: `تعيين تسوية ${settlement.partner.name} للفترة ${settlement.formatted_period} كمدفوعة؟`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، تعيين كمدفوع!'
      });

      if (result.isConfirmed) {
        try {
          await axios.post(`/dashboard/api/partner-settlement-mark-paid/${settlement.id}`);
          swal.fire("نجاح", "تم تعيين التسوية كمدفوعة!", "success");
          this.fetchSettlements();
        } catch (error) {
          swal.fire("خطأ", "فشل تعيين التسوية كمدفوعة.", "error");
        }
      }
    },
    viewProfitBreakdown(year, month) {
      this.$router.push({ name: 'partner.profit-breakdown', params: { year, month } });
    },
    viewAllSettlements() {
      this.$router.push({ name: 'partner.all-settlements' });
    },
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(amount);
    },
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString();
    }
  },
  mounted() {
    this.fetchSettlements();
    this.fetchYears();
  }
}
</script>
