<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <strong>تحليل الأرباح</strong> - {{ period }} <i class="fas fa-chart-pie"></i>
            </h5>
            <button class="btn btn-secondary btn-sm" @click="$router.back()">
              <i class="fas fa-arrow-right"></i> رجوع
            </button>
          </div>
          <div class="card-body">
            <!-- Profit Summary Cards -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <h5 class="card-title">الإيرادات المحصلة</h5>
                    <h3>{{ formatCurrency(profitData.collected_revenue) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card bg-danger text-white">
                  <div class="card-body">
                    <h5 class="card-title">تكلفة البضاعة</h5>
                    <h3>{{ formatCurrency(profitData.cogs) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card bg-warning text-white">
                  <div class="card-body">
                    <h5 class="card-title">المصروفات</h5>
                    <h3>{{ formatCurrency(profitData.expenses) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <h5 class="card-title">صافي الربح</h5>
                    <h3>{{ formatCurrency(profitData.net_profit) }}</h3>
                  </div>
                </div>
              </div>
            </div>

            <!-- Profit Calculation Formula -->
            <div class="alert alert-info">
              <h6><strong>معادلة حساب الربح:</strong></h6>
              <p class="mb-0">
                صافي الربح = الإيرادات المحصلة ({{ formatCurrency(profitData.collected_revenue) }})
                - تكلفة البضاعة ({{ formatCurrency(profitData.cogs) }})
                - المصروفات ({{ formatCurrency(profitData.expenses) }})
                - المستردات ({{ formatCurrency(profitData.refunds) }})
                = <strong>{{ formatCurrency(profitData.net_profit) }}</strong>
              </p>
            </div>

            <!-- Detailed Breakdown -->
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0">تحليل مفصل حسب الفاتورة</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th>رقم الفاتورة</th>
                        <th>إجمالي الفاتورة</th>
                        <th>المحصل في الشهر</th>
                        <th>إجمالي تكلفة البضاعة</th>
                        <th>تكلفة البضاعة التناسبية</th>
                        <th>مساهمة الربح</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in breakdown" :key="item.invoice_number">
                        <td>{{ item.invoice_number }}</td>
                        <td>{{ formatCurrency(item.invoice_total) }}</td>
                        <td>{{ formatCurrency(item.collected_in_month) }}</td>
                        <td>{{ formatCurrency(item.sale_cogs_total) }}</td>
                        <td>{{ formatCurrency(item.proportional_cogs) }}</td>
                        <td>
                          <span :class="item.profit_contribution >= 0 ? 'text-success' : 'text-danger'">
                            {{ formatCurrency(item.profit_contribution) }}
                          </span>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr class="table-dark">
                        <th>الإجمالي</th>
                        <th>{{ formatCurrency(totalInvoiceTotal) }}</th>
                        <th>{{ formatCurrency(totalCollected) }}</th>
                        <th>{{ formatCurrency(totalCogs) }}</th>
                        <th>{{ formatCurrency(totalProportionalCogs) }}</th>
                        <th>{{ formatCurrency(totalProfitContribution) }}</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>

            <!-- COGS Calculation Explanation -->
            <div class="alert alert-secondary mt-3">
              <h6><strong>طريقة حساب تكلفة البضاعة:</strong></h6>
              <p class="mb-2">
                يتم حساب تكلفة البضاعة تناسبيا بناءً على المدفوعات النقدية:
              </p>
              <ul class="mb-0">
                <li>لكل فاتورة: <code class="bg-light p-1 rounded">التكلفة التناسبية = إجمالي تكلفة البضاعة × (المحصل في الشهر ÷ إجمالي الفاتورة)</code></li>
                <li>يتم التقاط تكلفة الوحدة عند وقت البيع لضمان دقة الحسابات التاريخية</li>
                <li>يتم اعتبار المدفوعات المدفوعة فقط (المبدأ النقدي)</li>
              </ul>
            </div>
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
      profitData: {
        period: '',
        collected_revenue: 0,
        cogs: 0,
        expenses: 0,
        refunds: 0,
        net_profit: 0
      },
      breakdown: []
    }
  },
  computed: {
    period() {
      return this.$route.params.year + '-' + String(this.$route.params.month).padStart(2, '0');
    },
    totalInvoiceTotal() {
      return this.breakdown.reduce((sum, item) => sum + item.invoice_total, 0);
    },
    totalCollected() {
      return this.breakdown.reduce((sum, item) => sum + item.collected_in_month, 0);
    },
    totalCogs() {
      return this.breakdown.reduce((sum, item) => sum + item.sale_cogs_total, 0);
    },
    totalProportionalCogs() {
      return this.breakdown.reduce((sum, item) => sum + item.proportional_cogs, 0);
    },
    totalProfitContribution() {
      return this.breakdown.reduce((sum, item) => sum + item.profit_contribution, 0);
    }
  },
  methods: {
    async fetchProfitBreakdown() {
      try {
        const response = await axios.get(`/dashboard/api/partner-profit-breakdown/${this.$route.params.year}/${this.$route.params.month}`);
        this.profitData = response.data.profit_data;
        this.breakdown = response.data.breakdown;
      } catch (error) {
        swal.fire("خطأ", "فشل تحميل تحليل الأرباح.", "error");
        this.$router.back();
      }
    },
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(amount);
    }
  },
  mounted() {
    this.fetchProfitBreakdown();
  },
  watch: {
    '$route.params.year'() {
      this.fetchProfitBreakdown();
    },
    '$route.params.month'() {
      this.fetchProfitBreakdown();
    }
  }
}
</script>
