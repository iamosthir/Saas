<template>
  <div class="row justify-content-center">
    <div class="col-md-12 mb-3">
      <div class="card">
        <div class="card-body">
          <form class="row" @submit.prevent="getReport(1)">
            <div class="col-md-4 mb-2 mb-md-0">
              <label class="form-label">من تاريخ</label>
              <input type="date" class="form-control" v-model="filter.from_date">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
              <label class="form-label">إلى تاريخ</label>
              <input type="date" class="form-control" v-model="filter.to_date">
            </div>
            <div class="col-md-4">
              <button class="btn btn-primary mt-4" type="submit">
                بحث
              </button>
            </div>
          </form>
          <div class="text-md-end text-center flex-shrink-0 ms-md-4 mt-3 mt-md-0">
            <span class="fw-bold fs-5">
              مجموع المبيعات لهذا الشهر:
              <span class="text-success">{{ totalThisMonth.toLocaleString() }}</span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">تقرير المبيعات</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>رقم الفاتورة</th>
                  <th>الزبون</th>
                  <th>المنتجات</th>
                  <th>المبلغ الكلي</th>
                  <th>المبلغ المدفوع</th>
                  <th>المبلغ المتبقي</th>
                  <th>حالة الدفع</th>
                  <th>حالة الطلب</th>
                  <th>التاريخ</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(sale, i) in rows" :key="sale.id">
                  <td>{{ ((paginateData.current_page-1)*paginateData.per_page) + i + 1 }}</td>
                  <td>{{ sale.id }}</td>
                  <td>{{ sale.customer_name }}</td>
                  <td>
                    <ul class="mb-0" style="list-style:none;padding-left:0;">
                      <li v-for="(item, idx) in parseProducts(sale.products)" :key="idx">
                        {{ item.product_name }} - {{ item.variant_name }} (x{{ item.qnt }}) - {{ item.unit_price }} IQD
                      </li>
                    </ul>
                  </td>
                  <td>{{ Number(sale.total_price).toLocaleString() }} IQD</td>
                  <td>
                    <span class="text-success fw-bold">{{ Number(sale.total_paid || 0).toLocaleString() }} IQD</span>
                  </td>
                  <td>
                    <span :class="{'text-danger': dueAmount(sale) > 0, 'text-success': dueAmount(sale) <= 0}">
                      {{ dueAmount(sale).toLocaleString() }} IQD
                    </span>
                  </td>
                  <td>
                    <span
                      :class="{'text-success': sale.payment_status === 'paid', 'text-danger': sale.payment_status !== 'paid'}">
                      {{ sale.payment_status === 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-info text-dark">{{ sale.order_status }}</span>
                  </td>
                  <td>{{ sale.created_at | formatDate }}</td>
                  <td>
                    <a target="_blank"
                      class="btn btn-outline-secondary btn-sm mb-1" :href="`/dashboard/print-salesinvoice/${sale.id}`">
                      <i class="fas fa-print"></i> طباعة الفاتورة
                    </a>
                    <button v-if="dueAmount(sale) > 0"
                      class="btn btn-sm btn-primary mb-1"
                      @click="openPaymentModal(sale)">
                      <i class="fas fa-plus"></i> إضافة دفعة
                    </button>
                    <button
                      class="btn btn-sm btn-warning mb-1"
                      @click="openViewPayments(sale)">
                      <i class="fas fa-list"></i> عرض الدفعات
                    </button>
                  </td>
                </tr>
                <tr v-if="rows.length === 0">
                  <td colspan="11" class="text-center text-muted">ماكو سجلات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            <pagination :limit="8" :data="paginateData" @pagination-change-page="getReport"></pagination>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true" ref="addPaymentModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form @submit.prevent="submitPayment">
            <div class="modal-header">
              <h5 class="modal-title" id="addPaymentModalLabel">إضافة دفعة جديدة</h5>
              <button type="button" class="btn-close" @click="closeAddPaymentModal"></button>
            </div>
            <div class="modal-body">
              <div v-if="paymentTargetInvoice">
                <div><b>رقم الفاتورة:</b> {{ paymentTargetInvoice.id }}</div>
                <div><b>الزبون:</b> {{ paymentTargetInvoice.customer_name }}</div>
                <div><b>المبلغ الكلي:</b> {{ paymentTargetInvoice.total_price }} IQD</div>
                <div><b>المبلغ المدفوع:</b> {{ paymentTargetInvoice.total_paid || 0 }} IQD</div>
                <div><b>المبلغ المتبقي:</b> {{ dueAmount(paymentTargetInvoice) }} IQD</div>
              </div>
              <div class="form-group mt-3">
                <label>مبلغ الدفعة</label>
                <input
                  type="number"
                  class="form-control"
                  v-model="paymentForm.amount"
                  required
                  min="1"
                  :max="dueAmount(paymentTargetInvoice)"
                >
              </div>
              <div class="form-group mt-2">
                <label>ملاحظات</label>
                <textarea class="form-control" v-model="paymentForm.remarks" rows="2"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">حفظ الدفعة</button>
              <button type="button" class="btn btn-secondary" @click="closeAddPaymentModal">إلغاء</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- List Payments Modal -->
    <div class="modal fade" id="listPaymentsModal" tabindex="-1" role="dialog" aria-labelledby="listPaymentsModalLabel" aria-hidden="true" ref="listPaymentsModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="listPaymentsModalLabel">قائمة الدفعات</h5>
            <button type="button" class="btn-close" @click="closeListModal"></button>
          </div>
          <div class="modal-body">
            <div v-if="listTargetInvoice">
              <div><b>رقم الفاتورة:</b> {{ listTargetInvoice.id }}</div>
              <div><b>الزبون:</b> {{ listTargetInvoice.customer_name }}</div>
              <div><b>المبلغ الكلي:</b> {{ listTargetInvoice.total_price }} IQD</div>
              <div><b>المبلغ المدفوع:</b> {{ listTargetInvoice.total_paid || 0 }} IQD</div>
              <div><b>المبلغ المتبقي:</b> {{ dueAmount(listTargetInvoice) }} IQD</div>
            </div>
            <table
              v-if="listTargetInvoice && listTargetInvoice.payments && listTargetInvoice.payments.length"
              class="table table-bordered table-sm mt-3"
            >
              <thead>
                <tr>
                  <th>#</th>
                  <th>المبلغ</th>
                  <th>الملاحظات</th>
                  <th>التاريخ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(pay, idx) in listTargetInvoice.payments" :key="idx">
                  <td>{{ idx + 1 }}</td>
                  <td>{{ Number(pay.amount).toLocaleString() }} IQD</td>
                  <td>{{ pay.remarks }}</td>
                  <td>{{ pay.created_at | formatDate }}</td>
                </tr>
                <tr v-if="!listTargetInvoice.payments || listTargetInvoice.payments.length === 0">
                  <td colspan="4" class="text-center text-muted">لحد الآن ماكو دفعات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeListModal">إغلاق</button>
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
      filter: {
        from_date: "",
        to_date: ""
      },
      paginateData: {},
      rows: [],
      totalThisMonth: 0,

      // Payment modal state
      paymentTargetInvoice: null,
      paymentForm: {
        amount: '',
        remarks: ''
      },

      // List payments modal
      listTargetInvoice: null,
    }
  },
  methods: {
    async getReport(page = 1) {
      let params = { page, ...this.filter };
      await axios.get('/dashboard/api/sales', { params }).then(resp => {
        const data = resp.data;
        this.paginateData = data;
        this.rows = data.data || [];
        this.totalThisMonth = data.total_sales_month || 0;
      }).catch(() => {
        this.paginateData = {};
        this.rows = [];
        this.totalThisMonth = 0;
      });
    },
    parseProducts(products) {
      try {
        return JSON.parse(products);
      } catch {
        return [];
      }
    },
    dueAmount(row) {
      if (row) {
        let total = Number(row.total_price || 0);
        let paid = Number(row.total_paid || 0);
        return Math.max(0, total - paid);
      }
      return 0;
    },
    openPaymentModal(invoice) {
      this.paymentTargetInvoice = invoice;
      this.paymentForm = {
        amount: '',
        remarks: ''
      };
      $(this.$refs.addPaymentModal).modal('show');
    },
    closeAddPaymentModal() {
      $(this.$refs.addPaymentModal).modal('hide');
      this.paymentTargetInvoice = null;
    },
    async submitPayment() {
      if (!this.paymentTargetInvoice) return;
      let payload = {
        invoice_id: this.paymentTargetInvoice.id,
        amount: this.paymentForm.amount,
        remarks: this.paymentForm.remarks
      };
      await axios.post('/dashboard/api/store-sale-payment', payload)
        .then(resp => resp.data)
        .then(data => {
          if (data.status === "ok") {
            this.closeAddPaymentModal();
            this.getReport(this.paginateData.current_page || 1);
            swal.fire("Success", data.msg, "success");
          } else {
            swal.fire("Failed", data.msg || "Could not add payment.", "error");
          }
        })
        .catch(err => {
          swal.fire("Error", "Could not add payment.", "error");
        });
    },
    openViewPayments(invoice) {
      this.listTargetInvoice = invoice;
      $(this.$refs.listPaymentsModal).modal('show');
    },
    closeListModal() {
      $(this.$refs.listPaymentsModal).modal('hide');
      this.listTargetInvoice = null;
    }
  },
  filters: {
    formatDate(val) {
      if (!val) return '';
      const d = new Date(val);
      return d.toLocaleDateString() + " " + d.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
    }
  },
  mounted() {
    this.getReport();
  }
}
</script>
